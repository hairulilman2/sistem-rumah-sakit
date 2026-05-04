@extends('layouts.dashboard')
@section('title', 'Galeri Foto')
@section('page-title', 'Kelola Galeri Foto')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>🖼️ Galeri Foto</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📊 Laporan</span></a>
@endsection

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Foto</h3>
        <form method="POST" action="{{ route('admin.galeri.store') }}">
            @csrf
            @if($errors->any())
            <div class="mb-3 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="cth: Fasilitas, Event">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>
            <p class="text-xs text-gray-500 mb-3">*Upload foto melalui storage/file manager</p>
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Simpan</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Foto ({{ $galleries->count() }})</h3>
        <div class="grid grid-cols-2 gap-3 max-h-96 overflow-y-auto">
            @forelse($galleries as $g)
            <div class="border border-gray-200 rounded-lg p-3">
                <div class="font-medium text-gray-900 text-sm">{{ $g->title }}</div>
                @if($g->category)<div class="text-xs text-blue-600">{{ $g->category }}</div>@endif
                @if($g->description)<div class="text-xs text-gray-500 mt-1">{{ Str::limit($g->description, 40) }}</div>@endif
                <form method="POST" action="{{ route('admin.galeri.destroy', $g->id) }}" onsubmit="return confirm('Hapus?')" class="mt-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700">Hapus</button>
                </form>
            </div>
            @empty
            <div class="col-span-2 text-center py-8 text-gray-500">Belum ada foto di galeri</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
