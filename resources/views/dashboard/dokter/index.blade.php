@extends('layouts.dashboard')
@section('title', 'Dashboard Dokter')
@section('page-title', 'Dashboard Dokter')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>🏠 Dashboard</span>
</a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>👤 Profil Saya</span>
</a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📅 Jadwal Praktek</span>
</a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📋 Semua Appointment</span>
</a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📝 Artikel Kesehatan</span>
</a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>🌐 Kembali ke Website</span>
</a>
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-3">
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full text-xl">📅</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Appointment Hari Ini</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $appointments_today->count() }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full text-xl">⏳</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Appointment Pending</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $appointments_pending }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full text-xl">👨‍⚕️</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Spesialisasi</p>
            <p class="text-sm font-semibold text-gray-700">{{ $doctor->specialization }}</p>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Profil Singkat</h3>
        <div class="space-y-3">
            <div class="flex justify-between"><span class="text-gray-500 text-sm">Nama</span><span class="font-medium text-sm">{{ auth()->user()->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500 text-sm">Spesialisasi</span><span class="font-medium text-sm">{{ $doctor->specialization }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500 text-sm">Pendidikan</span><span class="font-medium text-sm">{{ $doctor->education }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500 text-sm">Pengalaman</span><span class="font-medium text-sm">{{ $doctor->experience }} tahun</span></div>
        </div>
        <a href="{{ route('dashboard.dokter.profil') }}" class="mt-4 inline-block text-blue-600 text-sm hover:text-blue-700">Edit Profil →</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('dashboard.dokter.jadwal.index') }}" class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                <div class="font-semibold text-blue-900 text-sm">📅 Kelola Jadwal Praktek</div>
                <div class="text-xs text-blue-700">Tambah/hapus jadwal</div>
            </a>
            <a href="{{ route('dashboard.dokter.appointments') }}" class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg transition">
                <div class="font-semibold text-green-900 text-sm">📋 Lihat Semua Appointment</div>
                <div class="text-xs text-green-700">Kelola status appointment pasien</div>
            </a>
            <a href="{{ route('dashboard.dokter.artikel.create') }}" class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition">
                <div class="font-semibold text-purple-900 text-sm">📝 Tulis Artikel Kesehatan</div>
                <div class="text-xs text-purple-700">Berbagi informasi kesehatan</div>
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Appointment Hari Ini</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments_today as $a)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 text-sm">{{ $a->patient->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $a->patient->user->phone }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $a->start_time }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($a->complaint, 50) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $a->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada appointment hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
