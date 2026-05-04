@extends('layouts.dashboard')
@section('title', 'Tulis Berita')
@section('page-title', 'Tulis Berita Baru')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🖼️ Galeri</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📊 Laporan</span></a>
@endsection

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.berita.index') }}" class="text-blue-600 text-sm mb-4 inline-block">← Kembali</a>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.berita.store') }}">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Tanpa Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ringkasan (Excerpt)</label>
                <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('excerpt') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Berita *</label>
                <textarea name="body" rows="10" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('body') }}</textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                <a href="{{ route('admin.berita.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
