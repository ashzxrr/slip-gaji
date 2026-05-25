@extends('karyawan-portal.layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl">
    {{-- Profile Header --}}
    <div class="bg-gradient-to-r from-amber-600 to-amber-400 rounded-2xl shadow-lg p-6 md:p-8 mb-6 text-white">
        <div class="flex items-center gap-4 md:gap-6">
            <div class="bg-gradient-to-br from-amber-300 to-amber-600 rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center text-2xl md:text-3xl font-bold text-white shadow-lg">
                {{ strtoupper(substr($karyawan->nama, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-xl md:text-2xl font-bold">{{ $karyawan->nama }}</h2>
                <p class="text-amber-100 text-sm md:text-base">{{ $karyawan->jabatan }}</p>
                <p class="text-amber-100 text-xs md:text-sm mt-1">NIP: {{ $karyawan->nip }}</p>
            </div>
        </div>
    </div>

    {{-- Info Statis --}}
    <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-4 md:p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Informasi Karyawan</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between items-center pb-3 border-b border-amber-100">
                <span class="text-gray-600">Nama</span>
                <span class="font-medium text-gray-800">{{ $karyawan->nama }}</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-amber-100">
                <span class="text-gray-600">NIP</span>
                <span class="font-medium text-gray-800">{{ $karyawan->nip }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Jabatan</span>
                <span class="font-medium text-gray-800">{{ $karyawan->jabatan }}</span>
            </div>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="bg-white rounded-xl border border-amber-100 shadow-sm p-4 md:p-6">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Ubah Data Profil</h3>
        
        <form method="POST" action="{{ route('portal.profile.update') }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $karyawan->username) }}" required
                       class="w-full border border-amber-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $karyawan->no_whatsapp) }}" required
                       class="w-full border border-amber-200 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                @error('no_whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="border-t border-amber-100 pt-4 mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-4">Ubah Password</h4>
                

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin ganti)</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="pwd_karyawan"
                               class="w-full border border-amber-200 rounded-lg px-4 py-2.5 pr-10 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <button type="button" onclick="togglePwd('pwd_karyawan', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors focus:outline-none" tabindex="-1">
                            <i class="fa fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="pwd_confirm"
                               class="w-full border border-amber-200 rounded-lg px-4 py-2.5 pr-10 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <button type="button" onclick="togglePwd('pwd_confirm', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors focus:outline-none" tabindex="-1">
                            <i class="fa fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="w-full md:w-auto bg-gradient-to-r from-amber-500 to-amber-600 text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:from-amber-600 hover:to-amber-700 shadow-md transition-all">
                <i class="fa fa-save mr-2"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        btn.title = 'Sembunyikan password';
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        btn.title = 'Tampilkan password';
    }
}
</script>
@endpush