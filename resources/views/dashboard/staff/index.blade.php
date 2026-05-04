@extends('layouts.dashboard')
@section('title', 'Dashboard Staff')
@section('page-title', 'Dashboard Staff')

@section('sidebar')
<a href="{{ route('staff.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>🏠 Dashboard</span>
</a>
<a href="{{ route('staff.antrian') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📋 Antrian Harian</span>
</a>
<a href="{{ route('staff.pesan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>✉️ Pesan Masuk</span>
</a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>🌐 Kembali ke Website</span>
</a>
@endsection

@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-3">
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full text-xl">⏳</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Appointment Pending</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $appointments_pending->count() }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full text-xl">📅</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Total Hari Ini</p>
            <p class="text-2xl font-semibold text-gray-700">{{ $appointments_today }}</p>
        </div>
    </div>
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full text-xl">✉️</div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-600">Pesan Belum Dibaca</p>
            <p class="text-2xl font-semibold text-gray-700">{{ \App\Models\Contact::unread()->count() }}</p>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    <a href="{{ route('staff.antrian') }}" class="block bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="text-3xl mb-3">📋</div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Antrian Harian</h3>
        <p class="text-gray-500 text-sm">Lihat dan kelola antrian appointment hari ini</p>
    </a>
    <a href="{{ route('staff.pesan.index') }}" class="block bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="text-3xl mb-3">✉️</div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Pesan & Pertanyaan</h3>
        <p class="text-gray-500 text-sm">Balas pesan dari masyarakat umum</p>
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Appointment Pending Konfirmasi</h3>
        <a href="{{ route('staff.antrian') }}" class="text-blue-600 text-sm hover:text-blue-700">Lihat Antrian →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments_pending as $a)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900 text-sm">{{ $a->patient->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $a->patient->user->phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $a->doctor->user->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $a->doctor->specialization }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $a->schedule_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $a->start_time }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($a->complaint, 40) }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('staff.appointments.confirm', $a->id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Konfirmasi</button>
                            </form>
                            <form method="POST" action="{{ route('staff.appointments.reject', $a->id) }}" onsubmit="return confirm('Tolak appointment ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Tolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada appointment pending</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
