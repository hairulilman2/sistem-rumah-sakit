@extends('layouts.dashboard')
@section('title', 'Kelola Fasilitas')
@section('page-title', 'Fasilitas Rumah Sakit')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🖼️ Galeri</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📊 Laporan</span></a>
@endsection

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    {{-- Form Tambah --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Fasilitas</h3>
        <form method="POST" action="{{ route('admin.fasilitas.store') }}">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fasilitas *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="cth: Rawat Inap, Lab, dll">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
        </form>
    </div>

    {{-- Daftar Fasilitas --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Fasilitas ({{ $facilities->count() }})</h3>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse($facilities as $f)
            <div class="border border-gray-200 rounded-lg p-3">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-medium text-gray-900">{{ $f->name }}</div>
                        @if($f->category)<div class="text-xs text-blue-600 mt-1">{{ $f->category }}</div>@endif
                        @if($f->description)<div class="text-sm text-gray-500 mt-1">{{ Str::limit($f->description, 60) }}</div>@endif
                    </div>
                    <form method="POST" action="{{ route('admin.fasilitas.destroy', $f->id) }}" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">Belum ada fasilitas</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
