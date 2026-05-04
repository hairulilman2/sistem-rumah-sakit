@extends('layouts.dashboard')
@section('title', 'Semua Appointment')
@section('page-title', 'Semua Appointment Saya')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👤 Profil Saya</span></a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal Praktek</span></a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📋 Semua Appointment</span></a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📝 Artikel Kesehatan</span></a>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($appointments as $a)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900 text-sm">{{ $a->patient->user->name ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500">{{ $a->patient->user->phone }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $a->schedule_date->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $a->start_time }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($a->complaint, 50) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $a->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                           ($a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($a->status === 'done' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($a->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($a->status === 'confirmed')
                    <form method="POST" action="{{ route('dashboard.dokter.appointments.done', $a->id) }}">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Selesai</button>
                    </form>
                    @else
                    <span class="text-gray-400 text-xs">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada appointment</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
