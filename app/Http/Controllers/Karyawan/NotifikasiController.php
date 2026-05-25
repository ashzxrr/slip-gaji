<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $karyawan = session_karyawan();
        $notifikasi = $karyawan->notifikasi()->latest()->paginate(10);
        $unreadCount = $karyawan->unreadNotifikasi()->count();

        return view('karyawan-portal.notifikasi.index', compact('notifikasi', 'unreadCount'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        $karyawan = session_karyawan();
        if ($notifikasi->karyawan_id !== $karyawan->id) abort(403);

        $notifikasi->update(['dibaca' => true]);
        return back();
    }

    public function markAllAsRead()
    {
        $karyawan = session_karyawan();
        $karyawan->notifikasi()->update(['dibaca' => true]);
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca');
    }

    public function destroy(Notifikasi $notifikasi)
    {
        $karyawan = session_karyawan();
        if ($notifikasi->karyawan_id !== $karyawan->id) abort(403);

        $notifikasi->delete();
        return back()->with('success', 'Notifikasi dihapus');
    }
}
