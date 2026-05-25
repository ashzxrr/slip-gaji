@extends('layouts.app')
@section('title', 'Input Gaji — ' . $karyawan->nama)

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('periode.slip.index', $periode) }}"
       class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← Kembali</a>

    <div class="bg-white rounded-xl shadow p-6">

        {{-- Info Karyawan --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 grid grid-cols-3 gap-3 text-sm">
            <div><span class="text-gray-500 text-xs">Nama</span><p class="font-semibold">{{ $karyawan->nama }}</p></div>
            <div><span class="text-gray-500 text-xs">NIP</span><p class="font-semibold">{{ $karyawan->nip }}</p></div>
            <div><span class="text-gray-500 text-xs">Jabatan</span><p class="font-semibold">{{ $karyawan->jabatan }}</p></div>
            <div><span class="text-gray-500 text-xs">Departemen</span><p class="font-semibold">{{ $karyawan->departemen }}</p></div>
            <div><span class="text-gray-500 text-xs">Periode</span><p class="font-semibold">{{ $periode->label }}</p></div>
        </div>

        <form method="POST" action="{{ route('periode.slip.store', [$periode, $karyawan]) }}">
            @csrf
            @php $e = $existing; @endphp

            {{-- Penghasilan --}}
            <div class="mb-2">
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                    PENGHASILAN
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6 mt-3">
                @php
                $penghasilan = [
                    'gaji_pokok'        => 'Gaji Pokok',
                    'tunj_jabatan'      => 'Tunjangan Jabatan',
                    'tunj_masa_kerja'   => 'Tunjangan Masa Kerja',
                    'tunj_komunikasi'   => 'Tunjangan Komunikasi',
                    'tunj_transportasi' => 'Tunjangan Transportasi',
                    'tunj_performance'  => 'Tunjangan Performance',
                    'tunj_tambahan'     => 'Tunjangan Tambahan',
                    'overtime'          => 'Overtime',
                ];
                @endphp
                @foreach($penghasilan as $field => $label)
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ $label }}</label>
                    <div class="flex">
                        <span class="bg-gray-100 border border-r-0 border-gray-300 px-2 py-2 text-xs text-gray-500 rounded-l-lg">Rp</span>
                        <input type="number" name="{{ $field }}" min="0"
                               value="{{ old($field, $e?->$field ?? 0) }}"
                               class="w-full border border-gray-300 rounded-r-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Potongan --}}
            <div class="mb-2">
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                    POTONGAN
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6 mt-3">
                @php
                $potongan = [
                    'pph21'                => 'PPH 21',
                    'bpjs_kesehatan'       => 'BPJS Kesehatan',
                    'bpjs_ketenagakerjaan' => 'BPJS Ketenagakerjaan',
                    'potongan_lain'        => 'Potongan Lain',
                    'pinjaman'             => 'Pinjaman',
                ];
                @endphp
                @foreach($potongan as $field => $label)
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ $label }}</label>
                    <div class="flex">
                        <span class="bg-gray-100 border border-r-0 border-gray-300 px-2 py-2 text-xs text-gray-500 rounded-l-lg">Rp</span>
                        <input type="number" name="{{ $field }}" min="0"
                               value="{{ old($field, $e?->$field ?? 0) }}"
                               class="w-full border border-gray-300 rounded-r-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-3 border-t pt-4">
                <a href="{{ route('periode.slip.index', $periode) }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-800 font-medium">
                    Simpan Gaji
                </button>
            </div>
        </form>
    </div>
</div>
@endsection