@extends('layouts.dashboard')
@section('title', 'Antrian Harian')
@section('page-title', 'Antrian Appointment Hari Ini')

@section('sidebar')
<a href="{{ route('staff.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('staff.antrian') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📋 Antrian Harian</span></a>
<a href="{{ route('staff.pesan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>✉️ Pesan Masuk</span></a>
<a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🌐 Kembali ke Website</span></a>
@endsection

@section('content')
<div class="mb-4">
    <p class="text-gray-600">Tanggal: <strong>{{ now()->format('d F Y') }}</strong> — Total: <strong>{{ $antrian->count() }}</strong> appointment</p>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keluhan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($antrian as $i => $a)
            <tr class="{{ $a->status === 'done' ? 'opacity-60' : '' }}">
                <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $i + 1 }}</td>
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $a->start_time }}</td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900 text-sm">{{ $a->patient->user->name ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500">{{ $a->patient->user->phone }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">{{ $a->doctor->user->name ?? 'N/A' }}</div>
                    <div class="text-xs text-gray-500">{{ $a->doctor->specialization }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($a->complaint, 40) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $a->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                           ($a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                           ($a->status === 'done' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($a->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 flex-wrap">
                        @if($a->status === 'pending')
                        <form method="POST" action="{{ route('staff.appointments.confirm', $a->id) }}">
                            @csrf
                            <button class="px-2 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Konfirmasi</button>
                        </form>
                        <form method="POST" action="{{ route('staff.appointments.reject', $a->id) }}" onsubmit="return confirm('Tolak?')">
                            @csrf
                            <button class="px-2 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Tolak</button>
                        </form>
                        @elseif($a->status === 'confirmed')
                        <form method="POST" action="{{ route('staff.appointments.done', $a->id) }}">
                            @csrf
                            <button class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Selesai</button>
                        </form>
                        @else
                        <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                    <div class="text-4xl mb-2">📅</div>
                    <p>Tidak ada appointment hari ini</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
