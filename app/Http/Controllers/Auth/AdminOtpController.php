<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AdminOtpService;
use App\Models\AdminOtpCode;

class AdminOtpController extends Controller
{
    public function showOtpForm()
    {
        $userId = session('admin_otp_user_id');
        if (! $userId) return redirect()->route('login');

        return view('auth.admin-otp');
    }

    public function verifyOtp(Request $request, AdminOtpService $service)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = session('admin_otp_user_id');
        if (! $userId) return redirect()->route('login');

        $user = User::find($userId);
        if (! $user) return redirect()->route('login');

        $otpRecord = AdminOtpCode::where('user_id', $user->id)->where('used', false)->latest()->first();

        $ok = $service->verify($user, $request->code);

        if (! $ok) {
            if ($otpRecord && $otpRecord->attempts >= 5) {
                Session::forget('admin_otp_user_id');
                return redirect()->route('login')->withErrors(['email' => 'Terlalu banyak percobaan. Silakan login ulang.']);
            }

            $sisa = $otpRecord ? max(0, 5 - $otpRecord->attempts) : 5;
            return back()->withErrors(['code' => "Kode OTP salah. Sisa percobaan: {$sisa}x"]);
        }

        // Success: login user
        Session::forget('admin_otp_user_id');
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
