@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
<div class="max-w-2xl space-y-6">

    {{-- Info Profil --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold text-gray-700 mb-5 flex items-center gap-2">
            <i class="fa fa-user text-green-700"></i> Informasi Akun
        </h3>

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-800 font-medium">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold text-gray-700 mb-5 flex items-center gap-2">
            <i class="fa fa-lock text-green-700"></i> Ganti Password
        </h3>

        <form method="POST" action="{{ route('admin.profile.password') }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <div class="relative">
                    <input type="password" name="current_password" id="pwd_current" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="button" onclick="togglePwd('pwd_current', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none" tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="pwd_new" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="button" onclick="togglePwd('pwd_new', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none" tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                <div id="strengthBar" class="mt-2 hidden">
                    <div class="flex gap-1 mb-1">
                        <div id="str1" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                        <div id="str2" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                        <div id="str3" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                        <div id="str4" class="h-1 flex-1 rounded-full bg-gray-200"></div>
                    </div>
                    <p id="strengthText" class="text-xs text-gray-400"></p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="pwd_confirm" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="button" onclick="togglePwd('pwd_confirm', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none" tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="bg-green-700 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-800 font-medium">
                Ganti Password
            </button>
            <p class="text-xs text-gray-400 mt-2">
                <i class="fa fa-shield-alt"></i>
                Kode OTP akan dikirim ke email Anda untuk konfirmasi
            </p>
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

document.getElementById('pwd_new')
    ?.addEventListener('input', function() {
    const val   = this.value;
    const bar   = document.getElementById('strengthBar');
    const bars  = [
        document.getElementById('str1'),
        document.getElementById('str2'),
        document.getElementById('str3'),
        document.getElementById('str4'),
    ];
    const text  = document.getElementById('strengthText');
    
    if (!val) {
        bar.classList.add('hidden');
        return;
    }
    
    bar.classList.remove('hidden');
    
    let score = 0;
    if (val.length >= 6)  score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-emerald-500'];
    const labels = ['Sangat Lemah', 'Lemah', 'Cukup Kuat', 'Kuat 💪'];

    bars.forEach((b, i) => {
        b.className = 'h-1 flex-1 rounded-full ' + 
            (i < score ? colors[score - 1] : 'bg-gray-200');
    });
    
    text.textContent = labels[score - 1] || '';
    text.className   = 'text-xs ' + (
        score <= 1 ? 'text-red-500' :
        score === 2 ? 'text-orange-500' :
        score === 3 ? 'text-yellow-600' : 'text-emerald-600'
    );
});
</script>
@endpush