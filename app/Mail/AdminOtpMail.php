<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $nama;

    public function __construct(string $otp, string $nama)
    {
        $this->otp = $otp;
        $this->nama = $nama;
    }

    public function build()
    {
        return $this->subject('Kode OTP Login Admin - PT Walet Abdillah Jabli')
            ->view('emails.admin-otp')
            ->with(['otp' => $this->otp, 'nama' => $this->nama]);
    }
}
