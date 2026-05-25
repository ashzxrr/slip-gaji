<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

class ProfileController extends Controller
{
    public function edit()
    {
        $karyawan = session_karyawan();
        return view('karyawan-portal.profile', compact('karyawan'));
    }

   public function update(Request $request)
    {
        $karyawan = session_karyawan();

        $request->validate([
            'username'    => 'required|string|unique:karyawan,username,' . $karyawan->id,
            'password'    => 'nullable|min:6|confirmed',
            'no_whatsapp' => 'required|string',
        ]);

        $update = [
            'username'     => $request->username,
            'no_whatsapp'  => $request->no_whatsapp,
        ];

        if ($request->password) {
            $update['password'] = Hash::make($request->password);
            $update['must_change_password'] = false;
        }

        $karyawan->update($update);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}