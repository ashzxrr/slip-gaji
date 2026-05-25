<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $nama
    ) {}

    public function build()
    {
        return $this->subject('Kode OTP Login - PT Walet Abdillah Jabli')
                    ->view('emails.otp');
    }
}