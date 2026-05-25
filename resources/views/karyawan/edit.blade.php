@extends('layouts.app')
@section('title', 'Edit Karyawan')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('karyawan.index') }}"
       class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">← Kembali</a>

    <div class="bg-white rounded-xl shadow p-6">
        <form method="POST" action="{{ route('karyawan.update', $karyawan) }}">
            @csrf @method('PUT')
            @include('karyawan._form')
            <div class="mt-6">
                <button type="submit"
                        class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 text-sm">
                    Update Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection