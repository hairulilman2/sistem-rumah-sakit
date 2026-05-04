@extends('layouts.dashboard')
@section('title', 'Laporan & Statistik')
@section('page-title', 'Laporan & Statistik')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🖼️ Galeri</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📊 Laporan & Statistik</span></a>
@endsection

@section('content')
<div class="grid md:grid-cols-2 gap-6 mb-6">
    {{-- Status Appointment --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment per Status</h3>
        @foreach($appointments_by_status as $stat)
        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
            <span class="text-gray-700 capitalize">{{ $stat->status }}</span>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                {{ $stat->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                   ($stat->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                   ($stat->status === 'done' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                {{ $stat->total }}
            </span>
        </div>
        @endforeach
    </div>

    {{-- Top Dokter --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 5 Dokter (Total Appointment)</h3>
        @forelse($top_doctors as $i => $doc)
        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
            <div>
                <span class="font-medium text-gray-900">{{ $i+1 }}. {{ $doc->user->name }}</span>
                <div class="text-xs text-gray-500">{{ $doc->specialization }}</div>
            </div>
            <span class="text-blue-600 font-semibold">{{ $doc->appointments_count }}</span>
        </div>
        @empty
        <p class="text-gray-500 text-center py-4">Belum ada data</p>
        @endforelse
    </div>
</div>

{{-- Appointment per Bulan --}}
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment per Bulan ({{ date('Y') }})</h3>
    @php $bulanNames = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des']; $max = $appointments_per_month->max('total') ?: 1; @endphp
    <div class="space-y-2">
        @foreach($appointments_per_month as $bln)
        <div class="flex items-center gap-3">
            <span class="w-10 text-sm text-gray-600 text-right">{{ $bulanNames[$bln->bln] }}</span>
            <div class="flex-1 bg-gray-100 rounded-full h-4">
                <div class="bg-blue-500 h-4 rounded-full" style="width: {{ ($bln->total / $max) * 100 }}%"></div>
            </div>
            <span class="w-8 text-sm font-semibold text-gray-700">{{ $bln->total }}</span>
        </div>
        @endforeach
        @if($appointments_per_month->isEmpty())
        <p class="text-gray-500 text-center py-4">Belum ada data appointment tahun ini</p>
        @endif
    </div>
</div>

{{-- Tabel Appointment Terbaru --}}
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">20 Appointment Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recent_appointments as $a)
                <tr>
                    <td class="px-6 py-3 text-sm text-gray-900">{{ $a->patient->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-900">{{ $a->doctor->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-900">{{ $a->schedule_date->format('d M Y') }}</td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $a->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                               ($a->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                               ($a->status === 'done' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($a->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada appointment</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
