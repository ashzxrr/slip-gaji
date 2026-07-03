<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\SlipGaji;

class PortalSlipController extends Controller
{
    public function show(SlipGaji $slip)
    {
        $karyawan = session_karyawan();

        if ($slip->karyawan_id !== $karyawan->id) {
            abort(403);
        }

        $slip->load('periode', 'karyawan');

        return view('karyawan-portal.slip.show', compact('slip'));
    }
}
