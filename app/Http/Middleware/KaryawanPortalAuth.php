<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KaryawanPortalAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('portal_karyawan_id')) {
            return redirect()->route('portal.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek last activity
        $lastActivity = session('portal_last_activity');
        $timeout = 30 * 60; // 30 menit dalam detik

        if ($lastActivity && (time() - $lastActivity > $timeout)) {
            session()->forget(['portal_karyawan_id', 'portal_last_activity']);
            return redirect()->route('portal.login')
                ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        // Update last activity
        session(['portal_last_activity' => time()]);

        return $next($request);
    }
}