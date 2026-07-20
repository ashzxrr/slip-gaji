<?php
namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'nama');
        $direction = $request->input('direction', 'asc');

        $query = Karyawan::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('departemen', 'like', "%{$search}%");
        }

        $karyawan = $query->orderBy($sort, $direction)->paginate(15);

        return view('karyawan.index', compact('karyawan', 'search', 'sort', 'direction'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nama'         => 'required|string|max:100',
        'nip'          => 'required|string|unique:karyawan,nip',
        'no_whatsapp'  => 'required|string',
        'jabatan'      => 'required|string',
        'departemen'   => 'required|string',
    ]);

    Karyawan::create([
        ...$request->only('nama', 'nip', 'jabatan', 'departemen', 'no_whatsapp'),
        'aktif'                => $request->boolean('aktif', true),
        'username'             => $request->nip,
        'password'             => Hash::make('karyawan123'),
        'must_change_password' => true,
    ]);

    return redirect()->route('karyawan.index')
        ->with('success', 'Karyawan berhasil ditambahkan.');
}
    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

public function update(Request $request, Karyawan $karyawan)
{
    $request->validate([
        'nama'        => 'required|string|max:100',
        'nip'         => 'required|string|unique:karyawan,nip,'.$karyawan->id,
        'jabatan'     => 'required|string',
        'departemen'  => 'required|string',
        'no_whatsapp' => 'required|string',
        'username'    => 'nullable|string|unique:karyawan,username,'.$karyawan->id,
        'password'    => 'nullable|min:6',
    ]);

    $karyawan->update([
        ...$request->only('nama','nip','jabatan','departemen','no_whatsapp','username'),
        'aktif'    => $request->boolean('aktif'),
        'password' => $request->password
            ? Hash::make($request->password)
            : $karyawan->password,
    ]);

    return redirect()->route('karyawan.index')
        ->with('success', 'Data karyawan diperbarui');
}

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return back()->with('success', 'Karyawan berhasil dihapus');
    }

    public function kirimKredensial()
{
    $karyawan = Karyawan::where('aktif', true)
        ->whereNotNull('email')
        ->whereNotNull('username')
        ->get();

    $berhasil = $gagal = 0;

    foreach ($karyawan as $k) {
        try {
            Mail::to($k->email)->send(new \App\Mail\KredensialMail($k));
            $berhasil++;
        } catch (\Exception $e) {
            \Log::error('Kirim kredensial gagal: ' . $e->getMessage());
            $gagal++;
        }
        sleep(1);
    }

    return back()->with('success', 
        "Selesai! ✅ Terkirim: {$berhasil} | ❌ Gagal: {$gagal}"
    );
}

    public function kirimKredensialKaryawan(Karyawan $karyawan)
    {
        if (! $karyawan->aktif || ! $karyawan->email || ! $karyawan->username) {
            return back()->with('error', 'Karyawan tidak memenuhi syarat pengiriman kredensial.');
        }

        $ok = false;
        try {
            Mail::to($karyawan->email)->send(new \App\Mail\KredensialMail($karyawan));
            $ok = true;
        } catch (\Exception $e) {
            \Log::error('Kirim kredensial gagal: ' . $e->getMessage());
        }

        return back()->with(
            $ok ? 'success' : 'error',
            $ok ? "Kredensial berhasil dikirim ke email {$karyawan->nama}."
                : "Gagal mengirim kredensial ke {$karyawan->nama}."
        );
}

    public function resetPassword(Karyawan $karyawan)
    {
        $karyawan->update([
            'password' => Hash::make('karyawan123'),
            'must_change_password' => true,
        ]);

        return back()->with('success', 'Password ' . $karyawan->nama . ' berhasil direset ke default (karyawan123). Karyawan akan diminta ganti password saat login berikutnya.');
    }

}