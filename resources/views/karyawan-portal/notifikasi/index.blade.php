@extends('karyawan-portal.layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="bg-[#fdfbf5] p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-bold">Notifikasi</h1>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('portal.notifikasi.readAll') }}">
                @csrf
                <button class="border border-amber-200 text-amber-600 px-3 py-2 rounded hover:bg-amber-50 text-sm">Tandai Semua Dibaca</button>
            </form>
        @endif
    </div>

    @forelse($notifikasi as $note)
        <div class="mb-3 p-4 rounded-lg shadow-sm {{ $note->dibaca ? 'bg-white border-l-4 border-gray-100' : 'bg-amber-50 border-l-4 border-amber-400' }}">
            <div class="flex items-start">
                <div class="mr-3 text-2xl">
                    @if($note->tipe === 'slip')
                        <i class="fa fa-file-invoice text-amber-600"></i>
                    @elseif($note->tipe === 'warning')
                        <i class="fa fa-exclamation-triangle text-red-500"></i>
                    @else
                        <i class="fa fa-info-circle text-blue-500"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold">{{ $note->judul }}</div>
                            <div class="text-xs text-gray-400">{{ $note->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(! $note->dibaca)
                                <form method="POST" action="{{ route('portal.notifikasi.read', $note) }}">
                                    @csrf
                                    <button class="text-sm text-amber-600 border border-amber-200 px-2 py-1 rounded hover:bg-amber-50">Tandai Dibaca</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('portal.notifikasi.destroy', $note) }}" onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-2 text-sm {{ $note->dibaca ? 'text-gray-600' : 'text-gray-800' }}">{!! nl2br(e($note->pesan)) !!}</div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <i class="fa fa-bell text-6xl text-amber-200 mb-4"></i>
            <h3 class="text-gray-600">Belum ada notifikasi</h3>
            <p class="text-sm text-gray-400">Notifikasi slip gaji akan muncul di sini</p>
        </div>
    @endforelse

    <div class="mt-4">{{ $notifikasi->links() }}</div>
</div>
@endsection
