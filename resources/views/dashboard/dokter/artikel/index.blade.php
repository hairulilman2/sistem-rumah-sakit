@extends('layouts.dashboard')
@section('title', 'Artikel Kesehatan')
@section('page-title', 'Artikel Kesehatan Saya')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👤 Profil Saya</span></a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal Praktek</span></a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Semua Appointment</span></a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📝 Artikel Kesehatan</span></a>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Artikel Saya ({{ $articles->count() }})</h2>
    <a href="{{ route('dashboard.dokter.artikel.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Tulis Artikel</a>
</div>

@if($articles->isEmpty())
<div class="bg-white rounded-lg shadow-sm p-12 text-center">
    <div class="text-4xl mb-4">📝</div>
    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada artikel</h3>
    <p class="text-gray-500 mb-4">Bagikan pengetahuan kesehatan Anda kepada pasien</p>
    <a href="{{ route('dashboard.dokter.artikel.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Tulis Artikel Pertama</a>
</div>
@else
<div class="bg-white rounded-lg shadow-sm overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($articles as $a)
            <tr>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900 text-sm">{{ Str::limit($a->title, 60) }}</div>
                    @if($a->excerpt)<div class="text-xs text-gray-500">{{ Str::limit($a->excerpt, 60) }}</div>@endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $a->category->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $a->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $a->status === 'published' ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $a->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    <form method="POST" action="{{ route('dashboard.dokter.artikel.destroy', $a->id) }}" onsubmit="return confirm('Hapus artikel ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
