<?php
namespace App\Http\Controllers;

use App\Models\{Karyawan, GajiPeriode, SlipGaji};

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan  = Karyawan::where('aktif', true)->count();
        $totalPeriode   = GajiPeriode::count();
        $periodeTerakhir = GajiPeriode::latest()->first();
        $statsKirim = null;

        if ($periodeTerakhir) {
            $statsKirim = SlipGaji::where('periode_id', $periodeTerakhir->id)
                ->selectRaw("
                    COUNT(*) as total,
                    SUM(status_kirim = 'terkirim') as terkirim,
                    SUM(status_kirim = 'gagal') as gagal,
                    SUM(status_kirim = 'pending') as pending
                ")->first();
        }

        return view('dashboard', compact(
            'totalKaryawan','totalPeriode','periodeTerakhir','statsKirim'
        ));
    }
}