<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\{GajiPeriode, SlipGaji};
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $karyawan = session_karyawan();
        $slips = SlipGaji::where('karyawan_id', $karyawan->id)
            ->with('periode')
            ->latest()
            ->get();

        return view('karyawan-portal.dashboard', compact('karyawan', 'slips'));
    }

    public function downloadSlip(SlipGaji $slip)
    {
        $karyawan = session_karyawan();

        // Pastikan slip milik karyawan yang login
        if ($slip->karyawan_id !== $karyawan->id) {
            abort(403);
        }

        $slip->load('karyawan', 'periode');
        $pdf = Pdf::loadView('pdf.slip-template', compact('slip'))
            ->setPaper('a4', 'portrait');

        $namaFormatted = str_replace(' ', '', $slip->karyawan->nama);
        $filename = 'Slip-' . $namaFormatted . '-' . $slip->karyawan->nip . '.pdf';

        return $pdf->download($filename);
    }
}