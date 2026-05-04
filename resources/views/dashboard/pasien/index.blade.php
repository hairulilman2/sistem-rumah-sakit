@extends('layouts.dashboard')

@section('title', 'Dashboard Pasien')
@section('page-title', 'Dashboard Pasien')

@section('sidebar')
<a href="{{ route('pasien.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>🏠 Dashboard</span>
</a>
<a href="{{ route('pasien.booking') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>📅 Booking Appointment</span>
</a>
<a href="{{ route('pasien.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>👤 Profil Saya</span>
</a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-700">
    <span>🌐 Kembali ke Website</span>
</a>
@endsection


@section('content')
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Total Appointment</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointments->count() }}</p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Confirmed</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointments->where('status', 'confirmed')->count() }}</p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Pending</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointments->where('status', 'pending')->count() }}</p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
        <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600">Done</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointments->where('status', 'done')->count() }}</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('pasien.booking') }}" class="block p-6 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            <h3 class="text-lg font-semibold mb-2">Booking Appointment</h3>
            <p class="text-blue-100">Buat janji temu dengan dokter</p>
        </a>
        <a href="{{ route('dokter.index') }}" class="block p-6 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            <h3 class="text-lg font-semibold mb-2">Lihat Dokter</h3>
            <p class="text-green-100">Cari dokter spesialis</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="block p-6 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
            <h3 class="text-lg font-semibold mb-2">Update Profil</h3>
            <p class="text-purple-100">Perbarui data diri Anda</p>
        </a>
    </div>
</div>

<!-- Appointments List -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Appointment</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->doctor->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->doctor->specialization }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $appointment->schedule_date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $appointment->start_time }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ Str::limit($appointment->complaint, 50) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($appointment->status == 'pending')
                            <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Confirmed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelled</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Done</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada appointment. <a href="{{ route('pasien.booking') }}" class="text-blue-600 hover:text-blue-700">Booking sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
