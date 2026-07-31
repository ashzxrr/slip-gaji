<?php

function session_karyawan(): \App\Models\Karyawan
{
    $id = session('portal_karyawan_id');
    if (!$id) abort(401);
    return \App\Models\Karyawan::findOrFail($id);
}

function mask_email(?string $email): ?string
{
    if (!$email || !str_contains($email, '@')) {
        return $email;
    }

    [$local, $domain] = explode('@', $email, 2);
    $length = mb_strlen($local);

    if ($length <= 2) {
        $masked = $local . '***';
    } else {
        // Tampilkan 6 karakter awal, sensor sisanya
        $visible = min($length, 6);
        $masked  = mb_substr($local, 0, $visible) . str_repeat('*', $length - $visible);
    }

    return $masked . '@' . $domain;
}