<?php
namespace App\Mail;

use App\Models\{SlipGaji, GajiPeriode};
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SlipGajiNotifMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SlipGaji $slip,
        public GajiPeriode $periode
    ) {}

    public function build()
    {
        return $this->subject('Slip Gaji ' . $this->periode->bulan . ' ' . $this->periode->tahun . ' - PT Walet Abdillah Jabli')
                    ->view('emails.slip-gaji-notif');
    }
}
