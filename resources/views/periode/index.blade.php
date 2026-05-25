@extends('layouts.app')
@section('title', 'Periode Gaji')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-sm text-gray-500">Kelola periode penggajian</p>
    <a href="{{ route('periode.create') }}"
       class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 flex items-center gap-2 shadow-md transition-all">
        <i class="fa fa-plus"></i> Buat Periode Baru
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($periodes as $p)
    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm p-5">
        <div class="flex justify-between items-start mb-3">
            <div>
                <h3 class="font-bold text-gray-800 text-lg">{{ $p->label }}</h3>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $p->status === 'published'
                        ? 'bg-emerald-100 text-emerald-800'
                        : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($p->status) }}
                </span>
            </div>
            <form method="POST" action="{{ route('periode.destroy', $p) }}"
                  onsubmit="return confirm('Hapus periode ini beserta semua slip gajinya?')">
                @csrf @method('DELETE')
                <button class="text-red-400 hover:text-red-600">
                    <i class="fa fa-trash text-sm"></i>
                </button>
            </form>
        </div>

        <p class="text-sm text-gray-500 mb-4">{{ $p->slipGaji->count() }} slip gaji</p>

        <a href="{{ route('periode.slip.index', $p) }}"
           class="w-full block text-center bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 shadow-md transition-all">
            Kelola Slip Gaji →
        </a>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-gray-400">
        <i class="fa fa-calendar text-5xl mb-3 block"></i>
        <p>Belum ada periode. Buat periode baru untuk mulai input gaji.</p>
    </div>
    @endforelse
</div>
@endsection