@extends('layouts.dashboard')
@section('title', 'Tulis Artikel')
@section('page-title', 'Tulis Artikel Kesehatan')

@section('sidebar')
<a href="{{ route('dashboard.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('dashboard.dokter.profil') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>👤 Profil Saya</span></a>
<a href="{{ route('dashboard.dokter.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal Praktek</span></a>
<a href="{{ route('dashboard.dokter.appointments') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📋 Semua Appointment</span></a>
<a href="{{ route('dashboard.dokter.artikel.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>📝 Artikel Kesehatan</span></a>
@endsection

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('dashboard.dokter.artikel.index') }}" class="text-blue-600 text-sm mb-4 inline-block">← Kembali</a>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('dashboard.dokter.artikel.store') }}">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="cth: Tips Menjaga Kesehatan Jantung">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ringkasan</label>
                <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ringkasan singkat artikel...">{{ old('excerpt') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Artikel *</label>
                <textarea name="body" rows="12" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('body') }}</textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (simpan dulu)</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publish langsung</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Artikel</button>
                <a href="{{ route('dashboard.dokter.artikel.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
