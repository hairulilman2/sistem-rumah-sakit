@extends('layouts.dashboard')
@section('title', 'Kelola Dokter')
@section('page-title', 'Kelola Dokter')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>🏠 Dashboard</span>
</a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600">
    <span>👨‍⚕️ Kelola Dokter</span>
</a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📅 Jadwal Dokter</span>
</a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📰 Berita</span>
</a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>🏥 Fasilitas</span>
</a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>⚕️ Layanan</span>
</a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>🖼️ Galeri</span>
</a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
    <span>📊 Laporan</span>
</a>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Daftar Dokter</h2>
    <a href="{{ route('admin.dokter.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        + Tambah Dokter
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Spesialisasi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Departemen</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengalaman</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($doctors as $doctor)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $doctor->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $doctor->user->email }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $doctor->specialization }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $doctor->department->name ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $doctor->experience }} tahun</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $doctor->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $doctor->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.dokter.edit', $doctor->id) }}" class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">Edit</a>
                        <form method="POST" action="{{ route('admin.dokter.destroy', $doctor->id) }}" onsubmit="return confirm('Hapus dokter ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data dokter</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
