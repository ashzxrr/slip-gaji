<?php

function session_karyawan(): \App\Models\Karyawan
{
    $id = session('portal_karyawan_id');
    if (!$id) abort(401);
    return \App\Models\Karyawan::findOrFail($id);
}