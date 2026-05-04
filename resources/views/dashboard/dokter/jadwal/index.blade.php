@extends('layouts.dashboard')
@section('title', 'Jadwal Praktek')
@section('page-title', 'Kelola Jadwal Praktek')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👤 Profil Saya</span></a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📅 Jadwal Praktek</span></a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Semua Appointment</span></a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📝 Artikel Kesehatan</span></a>
@endsection

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Jadwal Praktek</h3>
        <form method="POST" action="{{ route('dashboard.dokter.jadwal.store') }}">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hari *</label>
                <select name="day_of_week" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                    <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai *</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai *</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Pasien *</label>
                <input type="number" name="max_quota" value="{{ old('max_quota', 10) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Tambah Jadwal</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Saya ({{ $schedules->count() }})</h3>
        @forelse($schedules as $s)
        <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
            <div>
                <div class="font-medium text-gray-900">{{ $s->day_of_week }}</div>
                <div class="text-sm text-gray-500">{{ $s->start_time }} - {{ $s->end_time }} (Kuota: {{ $s->max_quota }})</div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs {{ $s->is_active ? 'text-green-600' : 'text-red-500' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <form method="POST" action="{{ route('dashboard.dokter.jadwal.destroy', $s->id) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-center py-8">Belum ada jadwal praktek. Tambahkan jadwal Anda.</p>
        @endforelse
    </div>
</div>
@endsection
