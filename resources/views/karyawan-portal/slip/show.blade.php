@extends('karyawan-portal.layouts.app')
@section('title', 'Detail Slip Gaji')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm text-gray-500">Slip Gaji</p>
            <h1 class="text-2xl font-bold text-gray-900">{{ $slip->karyawan->nama }}</h1>
            <p class="text-sm text-gray-600 mt-1">Periode {{ $slip->periode->bulan }} {{ $slip->periode->tahun }}</p>
        </div>
        <a href="{{ route('portal.slip.index') }}" class="inline-flex items-center gap-2 text-amber-700 hover:text-amber-900 text-sm font-semibold">
            <i class="fa fa-arrow-left"></i>
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-amber-100 shadow-sm p-6">
        <div class="grid gap-4 md:grid-cols-2 mb-6">
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-wider text-amber-600 font-semibold">Nama</p>
                <p class="text-sm font-semibold text-gray-800">{{ $slip->karyawan->nama }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-wider text-amber-600 font-semibold">NIP</p>
                <p class="text-sm font-semibold text-gray-800">{{ $slip->karyawan->nip }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-wider text-amber-600 font-semibold">Jabatan</p>
                <p class="text-sm font-semibold text-gray-800">{{ $slip->karyawan->jabatan }}</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-wider text-amber-600 font-semibold">Departemen</p>
                <p class="text-sm font-semibold text-gray-800">{{ $slip->karyawan->departemen }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="bg-amber-50 border border-amber-100 rounded-3xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-amber-700">Rincian Penghasilan</p>
                        <p class="text-xs text-gray-500">Semua komponen sebelum potongan</p>
                    </div>
                </div>

                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex justify-between"><span>Gaji Pokok</span><span class="font-semibold">Rp {{ number_format($slip->gaji_pokok, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Jabatan</span><span class="font-semibold">Rp {{ number_format($slip->tunj_jabatan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Masa Kerja</span><span class="font-semibold">Rp {{ number_format($slip->tunj_masa_kerja, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Komunikasi</span><span class="font-semibold">Rp {{ number_format($slip->tunj_komunikasi, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Transportasi</span><span class="font-semibold">Rp {{ number_format($slip->tunj_transportasi, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Performance</span><span class="font-semibold">Rp {{ number_format($slip->tunj_performance, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Tambahan</span><span class="font-semibold">Rp {{ number_format($slip->tunj_tambahan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Overtime</span><span class="font-semibold">Rp {{ number_format($slip->overtime, 0, ',', '.') }}</span></div>
                    <div class="border-t border-amber-100 pt-3 mt-3 flex justify-between text-sm font-semibold text-gray-900"><span>Total Penghasilan</span><span>Rp {{ number_format($slip->total_penghasilan, 0, ',', '.') }}</span></div>
                </div>
            </section>

            <section class="bg-white border border-amber-100 rounded-3xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-amber-700">Rincian Potongan</p>
                        <p class="text-xs text-gray-500">Komponen potongan payroll</p>
                    </div>
                </div>

                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex justify-between"><span>PPH 21</span><span class="font-semibold">Rp {{ number_format($slip->pph21, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>BPJS Kesehatan</span><span class="font-semibold">Rp {{ number_format($slip->bpjs_kesehatan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>BPJS Ketenagakerjaan</span><span class="font-semibold">Rp {{ number_format($slip->bpjs_ketenagakerjaan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Lain</span><span class="font-semibold">Rp {{ number_format($slip->potongan_lain, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Pinjaman</span><span class="font-semibold">Rp {{ number_format($slip->pinjaman, 0, ',', '.') }}</span></div>
                    <div class="border-t border-amber-100 pt-3 mt-3 flex justify-between text-sm font-semibold text-gray-900"><span>Total Potongan</span><span>Rp {{ number_format($slip->total_potongan, 0, ',', '.') }}</span></div>
                </div>
            </section>
        </div>

        <div class="mt-6 rounded-3xl bg-gradient-to-r from-amber-500 to-amber-600 p-6 text-white shadow-lg">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-amber-100">Gaji Diterima</p>
                    <p class="text-3xl font-bold">Rp {{ number_format($slip->gaji_diterima, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('portal.slip.download', $slip) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-white/20 px-5 py-3 text-sm font-semibold text-white hover:bg-white/30 transition">
                    <i class="fa fa-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
