@extends('layouts.dashboard')
@section('title', 'Profil Dokter')
@section('page-title', 'Update Profil')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>👤 Profil Saya</span></a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal Praktek</span></a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Semua Appointment</span></a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📝 Artikel Kesehatan</span></a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('dashboard.dokter.profil.update') }}">
            @csrf @method('PUT')
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Akun</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-4">Data Dokter</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi *</label>
                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan *</label>
                <input type="text" name="education" value="{{ old('education', $doctor->education) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman (tahun) *</label>
                <input type="number" name="experience" value="{{ old('experience', $doctor->experience) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor STR</label>
                <input type="text" name="str_number" value="{{ old('str_number', $doctor->str_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Deskripsi Singkat</label>
                <textarea name="bio" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $doctor->bio) }}</textarea>
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
