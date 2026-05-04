@extends('layouts.dashboard')
@section('title', 'Jadwal Dokter')
@section('page-title', 'Kelola Jadwal Dokter')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📅 Jadwal Dokter</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🖼️ Galeri</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📊 Laporan</span></a>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Daftar Jadwal Dokter</h2>
    <a href="{{ route('admin.jadwal.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Tambah Jadwal</a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Mulai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Selesai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuota</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($schedules as $schedule)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $schedule->doctor->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $schedule->doctor->specialization }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->day_of_week }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->start_time }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->end_time }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->max_quota }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $schedule->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <form method="POST" action="{{ route('admin.jadwal.destroy', $schedule->id) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada jadwal</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
