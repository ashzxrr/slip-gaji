<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Karyawan — Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#78350f] via-[#b45309] to-[#fbbf24] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-amber-100">
        <div class="text-center mb-8">
            <div class="bg-gradient-to-br from-amber-400 to-amber-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa fa-lock text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Portal Karyawan</h1>
            <p class="text-amber-700 text-sm mt-1">PT Walet Abdillah Jabli</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-amber-100 border border-amber-300 text-amber-800 px-4 py-3 rounded-lg text-sm shadow-sm">
                <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

       <form method="POST" action="{{ route('portal.login') }}">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" required autofocus
               class="w-full border border-amber-200 rounded-lg px-4 py-2.5 text-sm
                      focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
        @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
            <input type="password" name="password" id="pwd_portal_login" required
                   class="w-full border border-amber-200 rounded-lg px-4 py-2.5 pr-10 text-sm
                          focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
            <button type="button" onclick="togglePwd('pwd_portal_login', this)"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors focus:outline-none"
                    tabindex="-1">
                <i class="fa fa-eye text-sm"></i>
            </button>
        </div>
        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
            class="w-full bg-gradient-to-r from-amber-500 to-amber-600 text-white py-2.5 rounded-lg font-semibold
                   hover:from-amber-600 hover:to-amber-700 transition text-sm shadow-md">
        Login & Kirim OTP
    </button>
</form>

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
    </div>
</body>
</html>