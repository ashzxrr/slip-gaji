<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\{Karyawan, OtpCode};
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(protected OtpService $otp) {}

    public function showLogin()
    {
        return view('karyawan-portal.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $karyawan = Karyawan::where('username', $request->username)
            ->where('aktif', true)->first();

        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            return back()->withErrors(['username' => 'Username atau password salah.']);
        }

        if (!$karyawan->email) {
            return back()->withErrors([
                'username' => 'Akun Anda belum memiliki email. Hubungi HRD.'
            ]);
        }

        // Generate & kirim OTP ke email
        $code = $this->otp->generate($karyawan);
        $this->otp->send($karyawan, $code);

        Session::put('otp_karyawan_id', $karyawan->id);

        return redirect()->route('portal.otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm()
    {
        if (!Session::has('otp_karyawan_id')) {
            return redirect()->route('portal.login');
        }
        return view('karyawan-portal.auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $karyawanId = Session::get('otp_karyawan_id');
        $karyawan   = Karyawan::find($karyawanId);

        if (!$karyawan) {
            return redirect()->route('portal.login');
        }

        if (!$this->otp->verify($karyawan, $request->code)) {
            $otp = OtpCode::where('karyawan_id', $karyawan->id)
                ->latest()->first();

            $sisaCoba = $otp ? max(0, 5 - $otp->attempts) : 0;

            if ($sisaCoba === 0) {
                Session::forget('otp_karyawan_id');
                return redirect()->route('portal.login')
                    ->withErrors(['username' => 'Terlalu banyak percobaan. Silakan login ulang.']);
            }

            return back()->withErrors([
                'code' => "Kode OTP salah. Sisa percobaan: {$sisaCoba}x"
            ]);
        }

        Session::forget('otp_karyawan_id');
        Session::put('portal_karyawan_id', $karyawan->id);

        return redirect()->route('portal.dashboard');
    }

    public function logout()
    {
        Session::forget('portal_karyawan_id');
        return redirect()->route('portal.login');
    }
}