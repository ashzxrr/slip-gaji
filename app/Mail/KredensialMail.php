<?php
namespace App\Mail;

use App\Models\Karyawan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KredensialMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Karyawan $karyawan) {}

    public function build()
    {
        return $this->subject('Akun Portal Slip Gaji - PT Walet Abdillah Jabli')
                    ->view('emails.kredensial');
    }
}
