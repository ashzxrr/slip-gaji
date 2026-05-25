<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Karyawan;

class CheckMustChangePassword
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $karyawanId = session('portal_karyawan_id');
        if (!$karyawanId) {
            return $next($request);
        }

        $karyawan = Karyawan::find($karyawanId);
        if (!$karyawan) {
            return $next($request);
        }

        $currentRoute = $request->route() ? $request->route()->getName() : null;

        if ($karyawan->must_change_password === true && !in_array($currentRoute, [
            'portal.password.change',
            'portal.password.update',
            'portal.logout',
        ])) {
            return redirect()->route('portal.password.change');
        }

        return $next($request);
    }
}
