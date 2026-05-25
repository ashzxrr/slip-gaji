<?php
namespace App\Http\Controllers;

use App\Models\GajiPeriode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = GajiPeriode::latest()->paginate(10);
        return view('periode.index', compact('periodes'));
    }

    public function create()
    {
        $bulanList = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];
        return view('periode.create', compact('bulanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|digits:4|integer',
        ]);

        $exists = GajiPeriode::where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)->exists();

        if ($exists) {
            return back()->withErrors(['bulan' => 'Periode ini sudah ada.']);
        }

        $periode = GajiPeriode::create($request->only('bulan','tahun'));

        return redirect()->route('periode.slip.index', $periode)
            ->with('success', 'Periode berhasil dibuat');
    }

    public function destroy(GajiPeriode $periode)
    {
        $periode->delete();
        return back()->with('success', 'Periode dihapus');
    }
}