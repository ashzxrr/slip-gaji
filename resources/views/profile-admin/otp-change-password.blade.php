@extends('layouts.app')
@section('title', 'Verifikasi OTP - Ganti Password')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                <i class="fa fa-lock text-emerald-600 text-2xl"></i>
            </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Ganti Password</h3>
        <p class="text-sm text-gray-500 mt-2">Kode OTP telah dikirim ke email Anda</p>
        <p class="text-sm text-gray-500 font-medium">{{ auth()->user()->email }}</p>

        <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded p-3 text-emerald-700 text-sm">
            Masukkan kode OTP untuk mengkonfirmasi perubahan password Anda
        </div>

        <form method="POST" action="{{ route('admin.profile.otp.verify') }}" class="mt-6">
            @csrf
            <div>
                <input type="text" name="code" maxlength="6" placeholder="······" autofocus
                       class="w-full text-center text-2xl font-bold tracking-widest border border-emerald-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                @error('code')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 text-white py-2.5 rounded-lg font-semibold">Verifikasi</button>
            </div>
        </form>

        <a href="{{ route('admin.profile') }}" class="block mt-3 text-sm text-gray-500 hover:text-gray-700">Batal, kembali ke profil</a>

        <p class="text-xs text-gray-400 mt-3">Kode berlaku 5 menit</p>
    </div>
</div>
@endsection
