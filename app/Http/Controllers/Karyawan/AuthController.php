<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct() {}

    public function showLogin()
    {
        return view('karyawan-portal.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $karyawan = Karyawan::where('username', $request->username)
            ->where('aktif', true)->first();

        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            return back()->withErrors(['username' => 'Username atau password salah.']);
        }

        Session::put('portal_karyawan_id', $karyawan->id);

        return redirect()->route('portal.dashboard');
    }

    public function logout()
    {
        Session::forget('portal_karyawan_id');
        return redirect()->route('portal.login');
    }
}