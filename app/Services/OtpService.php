<?php
namespace App\Services;

use App\Models\{Karyawan, OtpCode};
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public function __construct(protected FlowKirimService $flowkirim) {}

    public function generate(Karyawan $karyawan): string
    {
        // Hapus OTP lama yang belum dipakai
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
    $message = "PT Walet Abdillah Jabli\n\n"
        . "Halo *{$karyawan->nama}*,\n\n"
        . "Kode OTP login Anda: *{$code}*\n\n"
        . "Berlaku 5 menit. Jangan berikan ke siapapun.";

    try {
        $this->flowkirim->sendText($karyawan->no_whatsapp, $message);
    } catch (\Exception $e) {
        Log::error('OTP WA gagal: ' . $e->getMessage());
    }
}

    public function verify(Karyawan $karyawan, string $code): bool
    {
        $otp = OtpCode::where('karyawan_id', $karyawan->id)
            ->where('used', false)
            ->latest()
            ->first();

        if (!$otp || !$otp->isValid()) return false;

        // Maksimal 5 kali percobaan
        if ($otp->attempts >= 5) {
            $otp->update(['used' => true]); // invalidate otomatis
            return false;
        }

        // Tambah attempts dulu
        $otp->increment('attempts');

        if ($otp->code !== $code) return false;

        $otp->update(['used' => true]);
        return true;
    }
}