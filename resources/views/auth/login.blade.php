<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">PT Walet Abdillah Jabli</h1>
            <p class="text-gray-500 text-sm mt-1">Sistem Informasi Slip Gaji</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="pwd_login" required
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button type="button" onclick="togglePwd('pwd_login', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none"
                            tabindex="-1">
                        <i class="fa fa-eye text-sm"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" data-loading="Memverifikasi..."
                    class="w-full bg-green-700 text-white py-2.5 rounded-lg font-semibold
                           hover:bg-green-800 transition text-sm">
                Login
            </button>
        </form>
    </div>
</x-guest-layout>