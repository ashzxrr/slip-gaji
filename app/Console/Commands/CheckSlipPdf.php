<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SlipGaji;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckSlipPdf extends Command
{
    protected $signature = 'slip:pdf-check {id}';
    protected $description = 'Generate slip PDF for given SlipGaji id and show path + size';

    public function handle()
    {
        $id = $this->argument('id');
        $slip = SlipGaji::with('karyawan','periode')->find($id);
        if (! $slip) {
            $this->error('Slip not found');
            return 1;
        }

        $dir = storage_path('app/temp');
        if (! is_dir($dir)) mkdir($dir, 0755, true);
        $path = $dir . '/slip_' . $slip->karyawan->nip . '_' . time() . '.pdf';

        Pdf::loadView('pdf.slip-template', compact('slip'))
            ->setPaper('a4','portrait')
            ->save($path);

        $exists = is_readable($path);
        $size = $exists ? filesize($path) : 0;

        $this->info("Saved: {$path}");
        $this->info("Readable: " . ($exists ? 'yes' : 'no'));
        $this->info("Size: {$size} bytes");

        return 0;
    }
}
