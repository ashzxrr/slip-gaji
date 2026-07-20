<?php
namespace App\Services;

use App\Models\{Karyawan, OtpCode};
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public function __construct() {} // hapus FlowKirimService

    public function generate(Karyawan $karyawan): string
    {
        OtpCode::where('karyawan_id', $karyawan->id)
            ->where('used', false)
            ->delete();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::create([
            'karyawan_id' => $karyawan->id,
            'code'        => $code,
            'expires_at'  => now()->addMinutes(5),
        ]);

        return $code;
    }

    public function send(Karyawan $karyawan, string $code): void
    {
        try {
            if ($karyawan->email) {
                Mail::to($karyawan->email)->send(new OtpMail($code, $karyawan->nama));
            } else {
                Log::warning('OTP tidak terkirim: karyawan ' . $karyawan->nip . ' tidak punya email');
            }
        } catch (\Exception $e) {
            Log::error('OTP Email gagal: ' . $e->getMessage());
        }
    }

    public function verify(Karyawan $karyawan, string $code): bool
    {
        $otp = OtpCode::where('karyawan_id', $karyawan->id)
            ->where('used', false)
            ->latest()
            ->first();

        if (!$otp || !$otp->isValid()) return false;

        if ($otp->attempts >= 5) {
            $otp->update(['used' => true]);
            return false;
        }

        $otp->increment('attempts');

        if ($otp->code !== $code) return false;

        $otp->update(['used' => true]);
        return true;
    }
}