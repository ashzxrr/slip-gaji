<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi OTP Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Kode akan dikirim ke email Anda</p>
        </div>

        @if(session('status'))
            <div class="mb-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.otp.verify') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
                <input type="text" name="code" value="{{ old('code') }}" maxlength="6" autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" data-loading="Memverifikasi OTP..."
                    class="w-full bg-green-700 text-white py-2.5 rounded-lg font-semibold hover:bg-green-800 transition text-sm">
                Verifikasi
            </button>
        </form>
    </div>
</x-guest-layout>
