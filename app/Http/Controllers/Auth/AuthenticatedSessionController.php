<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();
        if (! $user) {
            return back()->withErrors(['email' => 'Autentikasi gagal.']);
        }

        // Immediately logout to avoid establishing full session before OTP verification
        Auth::logout();

        // Store pending admin id and send OTP
        session(['admin_otp_user_id' => $user->id]);

        $otpService = app(\App\Services\AdminOtpService::class);
        $code = $otpService->generate($user);
        $otpService->send($user, $code);

        return redirect()->route('admin.otp.form')->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
