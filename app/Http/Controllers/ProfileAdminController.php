<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\AdminOtpService;
use App\Models\AdminOtpCode;
use App\Models\User;

class ProfileAdminController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile-admin.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user =  auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email'=> $request->email,
        ]);
        return back()->with('success', 'Profile updated successfully.');

    }

    public function updatePassword(Request $request)
    {
      $request->validate([
        'current_password' =>'required',
        'password' => ['required','confirmed', Password::min(8)],
      ]);

      if (!Hash::check($request->current_password, auth()->user()->password)) {
          return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
      }

      // Simpan password baru yang sudah di-hash ke session
      Session::put('admin_change_password_user_id', auth()->user()->id);
      Session::put('admin_new_password', Hash::make($request->password));

      // Generate & kirim OTP
      $code = app(AdminOtpService::class)->generate(auth()->user());
      app(AdminOtpService::class)->send(auth()->user(), $code);

      return redirect()->route('admin.profile.otp.form')
          ->with('success', 'Kode OTP telah dikirim ke email Anda untuk konfirmasi ganti password.');
}

    public function showChangePasswordOtp()
    {
        if (!Session::has('admin_change_password_user_id')) {
            return redirect()->route('admin.profile')
                ->with('error', 'Sesi ganti password tidak valid.');
        }

        return view('profile-admin.otp-change-password');
    }

    public function verifyChangePasswordOtp(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = Session::get('admin_change_password_user_id');
        $user = User::find($userId);

        if (! $user || $user->id !== auth()->user()->id) {
            Session::forget(['admin_change_password_user_id', 'admin_new_password']);
            return redirect()->route('admin.profile')
                ->with('error', 'Sesi tidak valid.');
        }

        if (! app(AdminOtpService::class)->verify($user, $request->code)) {
            $otp = AdminOtpCode::where('user_id', $user->id)->latest()->first();
            $sisaCoba = $otp ? max(0, 5 - $otp->attempts) : 0;

            if ($sisaCoba === 0) {
                Session::forget(['admin_change_password_user_id', 'admin_new_password']);
                return redirect()->route('admin.profile')
                    ->with('error', 'Terlalu banyak percobaan. Silakan ulangi proses ganti password.');
            }

            return back()->withErrors([
                'code' => "Kode OTP salah. Sisa percobaan: {$sisaCoba}x"
            ]);
        }

        // OTP valid, terapkan password baru dari session
        $newPassword = Session::get('admin_new_password');
        $user->update(['password' => $newPassword]);

        // Hapus session
        Session::forget(['admin_change_password_user_id', 'admin_new_password']);

        return redirect()->route('admin.profile')
            ->with('success', 'Password berhasil diperbarui.');
    }
}