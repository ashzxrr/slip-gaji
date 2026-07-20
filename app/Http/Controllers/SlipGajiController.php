<?php
namespace App\Http\Controllers;

use App\Models\{Karyawan, GajiPeriode, SlipGaji};
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SlipGajiController extends Controller
{

    public function index(GajiPeriode $periode)
    {
        $slips = $periode->slipGaji()->with('karyawan')->get();
        $sudahInput = $slips->pluck('karyawan_id')->toArray();
        $belumInput = Karyawan::where('aktif', true)
            ->whereNotIn('id', $sudahInput)->get();

        $stats = [
            'total'    => $slips->count(),
            'terkirim' => $slips->where('status_kirim', 'terkirim')->count(),
            'gagal'    => $slips->where('status_kirim', 'gagal')->count(),
            'pending'  => $slips->where('status_kirim', 'pending')->count(),
        ];

        return view('slip.index', compact('periode','slips','belumInput','stats'));
    }

    public function create(GajiPeriode $periode, Karyawan $karyawan)
    {
        $existing = SlipGaji::where('periode_id', $periode->id)
            ->where('karyawan_id', $karyawan->id)->first();

        return view('slip.form', compact('periode','karyawan','existing'));
    }

    public function store(Request $request, GajiPeriode $periode, Karyawan $karyawan)
    {
        $data = $request->validate([
            'gaji_pokok'           => 'required|numeric|min:0',
            'tunj_jabatan'         => 'nullable|numeric|min:0',
            'tunj_masa_kerja'      => 'nullable|numeric|min:0',
            'tunj_komunikasi'      => 'nullable|numeric|min:0',
            'tunj_transportasi'    => 'nullable|numeric|min:0',
            'tunj_performance'     => 'nullable|numeric|min:0',
            'tunj_tambahan'        => 'nullable|numeric|min:0',
            'overtime'             => 'nullable|numeric|min:0',
            'pph21'                => 'nullable|numeric|min:0',
            'bpjs_kesehatan'       => 'nullable|numeric|min:0',
            'bpjs_ketenagakerjaan' => 'nullable|numeric|min:0',
            'potongan_lain'        => 'nullable|numeric|min:0',
            'pinjaman'             => 'nullable|numeric|min:0',
        ]);

        foreach ($data as $k => $v) $data[$k] = $v ?? 0;

        SlipGaji::updateOrCreate(
            ['periode_id' => $periode->id, 'karyawan_id' => $karyawan->id],
            array_merge($data, ['karyawan_id' => $karyawan->id, 'periode_id' => $periode->id])
        );

        return redirect()->route('periode.slip.index', $periode)
            ->with('success', 'Gaji '.$karyawan->nama.' berhasil disimpan');
    }

    public function preview(GajiPeriode $periode, SlipGaji $slip)
    {
        $slip->load('karyawan','periode');
        $pdf = Pdf::loadView('pdf.slip-template', compact('slip'))
            ->setPaper('a4','portrait');

        return $pdf->stream('slip_'.$slip->karyawan->nip.'.pdf');
    }

    public function kirim(GajiPeriode $periode, SlipGaji $slip)
    {
        $slip->load('karyawan','periode');

        if (!$slip->karyawan->email) {
            return back()->with('error', 'Karyawan ' . $slip->karyawan->nama . ' belum memiliki email.');
        }

        $ok = false;
        try {
            Mail::to($slip->karyawan->email)->send(
                new \App\Mail\SlipGajiNotifMail($slip, $periode)
            );
            $ok = true;
        } catch (\Exception $e) {
            \Log::error('Kirim email slip gagal: ' . $e->getMessage());
        }

        $slip->update([
            'status_kirim' => $ok ? 'terkirim' : 'gagal',
            'waktu_kirim'  => now(),
        ]);

        if ($ok) {
            Notifikasi::create([
                'karyawan_id' => $slip->karyawan_id,
                'judul'       => 'Slip Gaji Tersedia',
                'pesan'       => 'Slip gaji Anda periode ' . $periode->bulan . ' ' . $periode->tahun . ' telah tersedia.',
                'tipe'        => 'slip',
            ]);
        }

        return back()->with(
            $ok ? 'success' : 'error',
            $ok ? 'Notifikasi berhasil dikirim ke email!' : 'Gagal kirim email. Cek konfigurasi mail.'
        );
    }

    public function kirimSemua(GajiPeriode $periode)
    {
        $slips   = $periode->slipGaji()->with('karyawan','periode')->get();
        $berhasil = $gagal = $skip = 0;

        foreach ($slips as $slip) {
            if (!$slip->karyawan->email) {
                $skip++;
                continue;
            }

            $ok = false;
            try {
                Mail::to($slip->karyawan->email)->send(
                    new \App\Mail\SlipGajiNotifMail($slip, $periode)
                );
                $ok = true;
            } catch (\Exception $e) {
                \Log::error('Kirim email slip gagal: ' . $e->getMessage());
            }

            $slip->update([
                'status_kirim' => $ok ? 'terkirim' : 'gagal',
                'waktu_kirim'  => now(),
            ]);

            if ($ok) {
                Notifikasi::create([
                    'karyawan_id' => $slip->karyawan_id,
                    'judul'       => 'Slip Gaji Tersedia',
                    'pesan'       => 'Slip gaji Anda periode ' . $periode->bulan . ' ' . $periode->tahun . ' telah tersedia.',
                    'tipe'        => 'slip',
                ]);
            }

            $ok ? $berhasil++ : $gagal++;
            sleep(1);
        }

        $msg = "Selesai! ✅ Terkirim: {$berhasil} | ❌ Gagal: {$gagal}";
        if ($skip > 0) {
            $msg .= " | ⏭️ Skip (no email): {$skip}";
        }

        return back()->with('success', $msg);
    }

    /**
     * Generate PDF ke storage/public dan return [url, path]
     */
    private function generatePublicPdf(SlipGaji $slip): array
    {
        // Buat signed URL yang expire 10 menit
        $url = URL::temporarySignedRoute(
            'slip.stream',
            now()->addMinutes(10),
            ['slip' => $slip->id]
        );

        return [$url, ''];
    }
    public function streamPdf(SlipGaji $slip)
    {
        $slip->load('karyawan', 'periode');

        $pdf = Pdf::loadView('pdf.slip-template', compact('slip'))
            ->setPaper('a4', 'portrait');

        $namaFormatted = str_replace(' ', '', $slip->karyawan->nama);
        $filename = 'Slip-' . $namaFormatted . '-' . $slip->karyawan->nip . '.pdf';

        return $pdf->stream($filename);
    }

    public function salinDariSebelumnya(GajiPeriode $periode)
    {
        // Cari periode sebelumnya
        $sebelumnya = GajiPeriode::where('id', '<', $periode->id)
            ->latest('id')
            ->first();

        if (!$sebelumnya) {
            return back()->with('error', 'Tidak ada periode sebelumnya untuk disalin.');
        }

        $slipSebelumnya = $sebelumnya->slipGaji()->get();

        if ($slipSebelumnya->isEmpty()) {
            return back()->with('error', 'Periode sebelumnya tidak memiliki data gaji.');
        }

        $disalin = 0;
        $dilewati = 0;

        foreach ($slipSebelumnya as $slip) {
            // Skip kalau karyawan sudah punya slip di periode ini
            $sudahAda = SlipGaji::where('periode_id', $periode->id)
                ->where('karyawan_id', $slip->karyawan_id)
                ->exists();

            if ($sudahAda) {
                $dilewati++;
                continue;
            }

            // Skip kalau karyawan sudah tidak aktif
            if (!$slip->karyawan || !$slip->karyawan->aktif) {
                $dilewati++;
                continue;
            }

            SlipGaji::create([
                'karyawan_id'          => $slip->karyawan_id,
                'periode_id'           => $periode->id,
                'gaji_pokok'           => $slip->gaji_pokok,
                'tunj_jabatan'         => $slip->tunj_jabatan,
                'tunj_masa_kerja'      => $slip->tunj_masa_kerja,
                'tunj_komunikasi'      => $slip->tunj_komunikasi,
                'tunj_transportasi'    => $slip->tunj_transportasi,
                'tunj_performance'     => $slip->tunj_performance,
                'tunj_tambahan'        => $slip->tunj_tambahan,
                'overtime'             => $slip->overtime,
                'pph21'                => $slip->pph21,
                'bpjs_kesehatan'       => $slip->bpjs_kesehatan,
                'bpjs_ketenagakerjaan' => $slip->bpjs_ketenagakerjaan,
                'potongan_lain'        => $slip->potongan_lain,
                'pinjaman'             => $slip->pinjaman,
                'status_kirim'         => 'pending',
                'waktu_kirim'          => null,
            ]);

            $disalin++;
        }

        return back()->with('success', 
            "Berhasil menyalin {$disalin} data gaji dari periode {$sebelumnya->label}."
            . ($dilewati > 0 ? " {$dilewati} dilewati (sudah ada/nonaktif)." : '')
        );
    }
}