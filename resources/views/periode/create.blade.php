@extends('layouts.app')
@section('title', 'Buat Periode Baru')

@section('content')
<div class="max-w-md">
    <a href="{{ route('periode.index') }}"
       class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← Kembali</a>

    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('periode.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="bulan"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach($bulanList as $b)
                        <option value="{{ $b }}" {{ old('bulan') === $b ? 'selected' : '' }}>
                            {{ $b }}
                        </option>
                    @endforeach
                </select>
                @error('bulan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}"
                       min="2020" max="2099"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('tahun')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 text-sm font-medium">
                Buat Periode
            </button>
        </form>
    </div>
</div>
@endsection