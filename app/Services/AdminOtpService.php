<?php

namespace App\Services;

use App\Models\AdminOtpCode;
use App\Models\User;
use App\Mail\AdminOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminOtpService
{
    public function generate(User $user): string
    {
        // Invalidate previous unused OTPs
        AdminOtpCode::where('user_id', $user->id)->where('used', false)->delete();

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        AdminOtpCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
            'used' => false,
            'attempts' => 0,
        ]);

        return $code;
    }

    public function send(User $user, string $code): void
    {
        try {
            Mail::to($user->email)->send(new AdminOtpMail($code, $user->name));
        } catch (\Throwable $e) {
            Log::error('Failed to send admin OTP: ' . $e->getMessage());
        }
    }

    public function verify(User $user, string $code): bool
    {
        $otp = AdminOtpCode::where('user_id', $user->id)->where('used', false)->latest()->first();
        if (! $otp) return false;

        if (! $otp->isValid()) return false;

        if ($otp->attempts >= 5) {
            $otp->update(['used' => true]);
            return false;
        }

        $otp->increment('attempts');

        if ($otp->code !== $code) {
            return false;
        }

        $otp->update(['used' => true]);
        return true;
    }
}
