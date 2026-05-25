@extends('karyawan-portal.layouts.app')
@section('title', 'Buat Password Baru')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-[#78350f] via-[#b45309] to-[#fbbf24] flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-2xl border border-amber-100 shadow-2xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Buat Password Baru</h1>
        <p class="text-sm text-gray-600 mb-4">Demi keamanan, segera ganti password default Anda</p>

        <div class="bg-amber-50 border border-amber-200 rounded p-3 mb-4 text-sm text-amber-800">
            Password default Anda perlu diganti sebelum melanjutkan
        </div>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('portal.password.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Password Baru</label>
                <div class="relative">
                    <input id="pwd_new" name="password" type="password" minlength="6" required class="w-full border border-amber-200 rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-amber-300" />
                    <button type="button" onclick="togglePwd('pwd_new', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors focus:outline-none" tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>

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
                <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input id="pwd_confirm" name="password_confirmation" type="password" minlength="6" required class="w-full border border-amber-200 rounded px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-amber-300" />
                    <button type="button" onclick="togglePwd('pwd_confirm', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors focus:outline-none" tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 text-white py-3 rounded-lg font-medium">Ganti Password</button>
        </form>
    </div>
</div>

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
@endsection
