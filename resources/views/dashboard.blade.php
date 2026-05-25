@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-5 flex items-center gap-4">
        <div class="bg-emerald-100 text-emerald-800 rounded-full p-4">
            <i class="fa fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Karyawan Aktif</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalKaryawan }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-5 flex items-center gap-4">
        <div class="bg-emerald-100 text-emerald-800 rounded-full p-4">
            <i class="fa fa-calendar text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Periode</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPeriode }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-5 flex items-center gap-4">
        <div class="bg-emerald-100 text-emerald-800 rounded-full p-4">
            <i class="fa fa-paper-plane text-2xl"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500">Periode Terakhir</p>
            <p class="text-xl font-bold text-gray-800">
                {{ $periodeTerakhir ? $periodeTerakhir->label : '-' }}
            </p>
        </div>
    </div>
</div>

@if($periodeTerakhir && $statsKirim)
<div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-6">
    <h3 class="font-semibold text-gray-700 mb-4">
        Status Pengiriman — {{ $periodeTerakhir->label }}
    </h3>
    <div class="grid grid-cols-3 gap-4">
        <div class="text-center bg-emerald-100 rounded-lg p-4">
            <p class="text-3xl font-bold text-emerald-800">{{ $statsKirim->terkirim }}</p>
            <p class="text-sm text-gray-500 mt-1">Terkirim</p>
        </div>
        <div class="text-center bg-red-100 rounded-lg p-4">
            <p class="text-3xl font-bold text-red-800">{{ $statsKirim->gagal }}</p>
            <p class="text-sm text-gray-500 mt-1">Gagal</p>
        </div>
        <div class="text-center bg-yellow-100 rounded-lg p-4">
            <p class="text-3xl font-bold text-yellow-800">{{ $statsKirim->pending }}</p>
            <p class="text-sm text-gray-500 mt-1">Pending</p>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('periode.slip.index', $periodeTerakhir) }}"
           class="text-emerald-700 text-sm hover:underline font-medium">
            → Lihat detail periode ini
        </a>
    </div>
</div>
@endif
@endsection