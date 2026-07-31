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
            <p class="text-amber-700 text-sm mt-1">
                Kode OTP sudah dikirim ke email
                <span class="font-semibold text-gray-800">{{ mask_email($email) }}</span>
            </p>
        </div>

        <form method="POST" action="{{ route('portal.otp.verify') }}" id="portal-otp-form">
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

            <button type="submit" id="btn-portal-otp"
                    class="w-full bg-gradient-to-r from-amber-500 to-amber-600 text-white py-2.5 rounded-lg font-semibold
                           hover:from-amber-600 hover:to-amber-700 transition text-sm shadow-md
                           disabled:opacity-70 disabled:cursor-not-allowed">
                <span class="inline-flex items-center justify-center gap-2">
                    <svg id="spinner-portal-otp" class="hidden w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span id="label-portal-otp">Verifikasi</span>
                </span>
            </button>

            <p class="text-center text-xs text-gray-500 mt-4">
                Kode berlaku 5 menit.
                <a href="{{ route('portal.login') }}" class="text-amber-700 hover:underline font-medium">Kirim ulang?</a>
            </p>
        </form>
    </div>

    <!-- Overlay loading full layar -->
    <div id="otp-loading-overlay"
         class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center gap-4 bg-black/60 backdrop-blur-sm">
        <svg class="w-12 h-12 animate-spin text-amber-400" fill="none" viewBox="0 0 24 24" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <p class="text-white text-lg font-semibold">Sedang memuat...</p>
        <p class="text-white/70 text-sm">Menuju halaman dashboard</p>
    </div>

    <script>
        // Animasi loading full layar saat submit verifikasi OTP
        window.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('portal-otp-form');
            if (!form) return;

            form.addEventListener('submit', function () {
                // Cegah dobel submit
                if (this.dataset.submitting === '1') return;
                this.dataset.submitting = '1';

                const btn     = document.getElementById('btn-portal-otp');
                const spinner = document.getElementById('spinner-portal-otp');
                const label   = document.getElementById('label-portal-otp');

                // JANGAN disable input hidden _token (CSRF) -> bikin 419.
                // Input teks pakai readonly supaya tetap ikut terkirim.
                this.querySelectorAll('input[type="text"], input[type="password"]')
                    .forEach(el => el.readOnly = true);

                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('cursor-wait');
                    btn.classList.remove('hover:from-amber-600', 'hover:to-amber-700');
                }
                if (spinner) spinner.classList.remove('hidden');
                if (label) label.textContent = 'Memproses...';

                // Tampilkan overlay full layar
                const overlay = document.getElementById('otp-loading-overlay');
                if (overlay) overlay.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>