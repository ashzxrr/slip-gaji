<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#78350f] via-[#b45309] to-[#fbbf24] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-amber-100">
        <div class="text-center mb-8">
            <div class="bg-gradient-to-br from-amber-400 to-amber-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi OTP</h1>
            <p class="text-amber-700 text-sm mt-1">Cek WhatsApp & email Anda untuk kode OTP</p>
        </div>

        <form method="POST" action="{{ route('portal.otp.verify') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode OTP (6 digit)</label>
                <input type="text" name="code" maxlength="6" required autofocus
                       placeholder="______"
                       class="w-full border border-amber-200 rounded-lg px-4 py-3 text-center
                              text-2xl font-bold tracking-widest text-amber-800
                              focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                @error('code')<p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-amber-500 to-amber-600 text-white py-2.5 rounded-lg font-semibold
                           hover:from-amber-600 hover:to-amber-700 transition text-sm shadow-md">
                Verifikasi
            </button>

            <p class="text-center text-xs text-gray-500 mt-4">
                Kode berlaku 5 menit.
                <a href="{{ route('portal.login') }}" class="text-amber-700 hover:underline font-medium">Kirim ulang?</a>
            </p>
        </form>
    </div>
</body>
</html>