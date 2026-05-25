@extends('layouts.app')
@section('title', 'Data Karyawan')

@section('content')

<div class="flex justify-between items-center mb-5">
<div class="flex gap-2">
    <form method="POST" action="{{ route('karyawan.kirimKredensial') }}"
          onsubmit="return confirm('Kirim username & password ke semua karyawan via WhatsApp? Pastikan ini hanya dilakukan SEKALI!')">
        @csrf
        <button data-loading="Mengirim ke semua WA..." class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 flex items-center gap-2 shadow-md transition-all">
            <i class="fa fa-whatsapp"></i> Kirim Kredensial ke Semua
        </button>
    </form>

    <a href="{{ route('karyawan.create') }}"
       class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:from-emerald-600 hover:to-emerald-700 flex items-center gap-2 shadow-md transition-all">
        <i class="fa fa-plus"></i> Tambah Karyawan
    </a>
</div>
</div>

<!-- Search Form -->
<div class="mb-5">
    <form method="GET" action="{{ route('karyawan.index') }}" id="karyawan-search-form" class="space-y-2">
        <label for="karyawan-search-input" class="text-gray-600 text-sm font-medium">Cari karyawan</label>
        <div class="flex gap-2 items-center">
            <input id="karyawan-search-input" type="text" name="search" placeholder="Cari nama, NIP, jabatan, atau departemen..." 
                   value="{{ $search ?? '' }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            @if($search)
                <a href="{{ route('karyawan.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-500 shadow-md transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('#karyawan-search-input');
        const searchForm = document.querySelector('#karyawan-search-form');
        let typingTimeout;

        if (searchInput && searchForm) {
            searchInput.addEventListener('input', function () {
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(function () {
                    searchForm.submit();
                }, 350);
            });
        }
    });
</script>

<div id="tableSkeleton" class="space-y-3 p-4">
    @for($i = 0; $i < 5; $i++)
    <div class="flex gap-4 animate-pulse">
        <div class="h-4 bg-gray-200 rounded w-8"></div>
        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
        <div class="h-4 bg-gray-200 rounded w-1/6"></div>
        <div class="h-4 bg-gray-200 rounded w-1/5"></div>
        <div class="h-4 bg-gray-200 rounded w-1/6"></div>
        <div class="h-4 bg-gray-200 rounded flex-1"></div>
    </div>
    @endfor
</div>

<div id="tableContent" style="display:none;">
<div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-[#f0fdf9] text-emerald-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">
                    <a href="{{ route('karyawan.index', [...request()->query(), 'sort' => 'nama', 'direction' => $sort === 'nama' && $direction === 'asc' ? 'desc' : 'asc']) }}" 
                       class="hover:text-emerald-700 flex items-center gap-1">
                        Nama
                        @if($sort === 'nama')
                            <i class="fa fa-{{ $direction === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="px-4 py-3 text-left">
                    <a href="{{ route('karyawan.index', [...request()->query(), 'sort' => 'nip', 'direction' => $sort === 'nip' && $direction === 'asc' ? 'desc' : 'asc']) }}" 
                       class="hover:text-emerald-700 flex items-center gap-1">
                        NIP
                        @if($sort === 'nip')
                            <i class="fa fa-{{ $direction === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="px-4 py-3 text-left">
                    <a href="{{ route('karyawan.index', [...request()->query(), 'sort' => 'jabatan', 'direction' => $sort === 'jabatan' && $direction === 'asc' ? 'desc' : 'asc']) }}" 
                       class="hover:text-emerald-700 flex items-center gap-1">
                        Jabatan
                        @if($sort === 'jabatan')
                            <i class="fa fa-{{ $direction === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="px-4 py-3 text-left">
                    <a href="{{ route('karyawan.index', [...request()->query(), 'sort' => 'departemen', 'direction' => $sort === 'departemen' && $direction === 'asc' ? 'desc' : 'asc']) }}" 
                       class="hover:text-emerald-700 flex items-center gap-1">
                        Departemen
                        @if($sort === 'departemen')
                            <i class="fa fa-{{ $direction === 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                        @endif
                    </a>
                </th>
                <th class="px-4 py-3 text-left">No. WhatsApp</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Kredensial</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($karyawan as $i => $k)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $karyawan->firstItem() + $i }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $k->nama }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $k->nip }}</td>
                <td class="px-4 py-3">{{ $k->jabatan }}</td>
                <td class="px-4 py-3">{{ $k->departemen }}</td>
                <td class="px-4 py-3">{{ $k->no_whatsapp }}</td>
                <td class="px-4 py-3 text-center">
                    @if($k->aktif)
                        <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                    @endif
                    @if($k->must_change_password)
                        <span class="bg-amber-100 text-amber-700 text-xs px-1.5 py-0.5 rounded-full ml-1">Belum ganti PW</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <form method="POST" action="{{ route('karyawan.kirimKredensialKaryawan', $k) }}"
                          onsubmit="return confirm('Kirim kredensial ke {{ $k->nama }} via WhatsApp?')">
                        @csrf
                        <button type="submit" class="text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-xs px-2 py-1 rounded inline-flex items-center gap-1 shadow-md transition-all">
                            <i class="fa fa-paper-plane"></i> Kirim
                        </button>
                    </form>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('karyawan.edit', $k) }}"
                           class="text-emerald-600 hover:text-emerald-800 text-xs px-2 py-1 border border-emerald-200 rounded shadow-sm transition-colors">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('karyawan.resetPassword', $k) }}" onsubmit="return confirm('Reset password {{ $k->nama }} ke default karyawan123?')">
                            @csrf
                            <button type="submit" class="text-amber-600 text-xs px-2 py-1 rounded border border-amber-200 hover:bg-amber-50">Reset PW</button>
                        </form>
                        <form method="POST" action="{{ route('karyawan.destroy', $k) }}"
                              onsubmit="return confirm('Hapus karyawan ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-800 text-xs px-2 py-1 border border-red-200 rounded shadow-sm transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-10 text-gray-400">
                    Belum ada data karyawan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $karyawan->links() }}</div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const skeleton = document.getElementById('tableSkeleton');
        const content  = document.getElementById('tableContent');
        if (skeleton && content) {
            skeleton.style.display = 'none';
            content.style.display  = 'block';
        }
    }, 500);
});
</script>

@endsection