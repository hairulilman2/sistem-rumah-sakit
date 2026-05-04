@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>🏠 Dashboard</span>
</a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>👨‍⚕️ Kelola Dokter</span>
</a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>📅 Jadwal Dokter</span>
</a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>📰 Berita & Pengumuman</span>
</a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>🏥 Fasilitas</span>
</a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>⚕️ Layanan</span>
</a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>🖼️ Galeri Foto</span>
</a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>📊 Laporan & Statistik</span>
</a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>🌐 Kembali ke Website</span>
</a>
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-3 xl:grid-cols-6">
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">👨‍⚕️</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Total Dokter</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['doctors'] }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">🧑‍🤝‍🧑</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Total Pasien</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['patients'] }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">⏳</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Appointment Pending</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['appointments_pending'] }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">📅</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Appointment Hari Ini</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['appointments_today'] }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">📰</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Berita Published</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['news'] }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full">🏥</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Fasilitas</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $stats['facilities'] }}</p>
        </div>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-2">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Menu Cepat</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.dokter.create') }}" class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-center">
                <div class="text-xl mb-1">👨‍⚕️</div>
                <div class="text-sm font-semibold text-blue-900">Tambah Dokter</div>
            </a>
            <a href="{{ route('admin.jadwal.create') }}" class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg transition text-center">
                <div class="text-xl mb-1">📅</div>
                <div class="text-sm font-semibold text-green-900">Tambah Jadwal</div>
            </a>
            <a href="{{ route('admin.berita.create') }}" class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-center">
                <div class="text-xl mb-1">📰</div>
                <div class="text-sm font-semibold text-purple-900">Tulis Berita</div>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition text-center">
                <div class="text-xl mb-1">📊</div>
                <div class="text-sm font-semibold text-yellow-900">Lihat Laporan</div>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Terbaru</h3>
        @foreach(\App\Models\Appointment::with(['patient.user','doctor.user'])->latest()->take(5)->get() as $a)
        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
            <div>
                <div class="text-sm font-medium text-gray-900">{{ $a->patient->user->name ?? 'N/A' }}</div>
                <div class="text-xs text-gray-500">{{ $a->doctor->user->name ?? 'N/A' }} — {{ $a->schedule_date->format('d M Y') }}</div>
            </div>
            <span class="px-2 py-1 text-xs rounded-full {{ $a->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($a->status) }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endsection