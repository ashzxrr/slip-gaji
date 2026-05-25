<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'Test kirim email';

    public function handle()
    {
        try {
            Mail::raw('Test email dari sistem slip gaji', function($msg) {
                $msg->to('ahmadshohazar2911@gmail.com')
                    ->subject('Test Email Laravel');
            });
            $this->info('Email berhasil dikirim!');
        } catch (\Exception $e) {
            $this->error('Gagal: ' . $e->getMessage());
        }
    }
}