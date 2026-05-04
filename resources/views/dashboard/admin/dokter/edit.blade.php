@extends('layouts.dashboard')
@section('title', 'Edit Dokter')
@section('page-title', 'Edit Data Dokter')

@section('sidebar')
<a href="{{ route('admin.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏠 Dashboard</span></a>
<a href="{{ route('admin.dokter.index') }}" class="flex items-center px-6 py-3 text-gray-700 bg-gray-100 border-l-4 border-blue-600"><span>👨‍⚕️ Kelola Dokter</span></a>
<a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📅 Jadwal</span></a>
<a href="{{ route('admin.berita.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📰 Berita</span></a>
<a href="{{ route('admin.fasilitas.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🏥 Fasilitas</span></a>
<a href="{{ route('admin.layanan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>⚕️ Layanan</span></a>
<a href="{{ route('admin.galeri.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>🖼️ Galeri</span></a>
<a href="{{ route('admin.laporan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100"><span>📊 Laporan</span></a>
@endsection

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.dokter.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mb-4 inline-block">← Kembali</a>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <p class="text-gray-600 mb-4">Mengedit: <strong>{{ $doctor->user->name }}</strong></p>
        <form method="POST" action="{{ route('admin.dokter.update', $doctor->id) }}">
            @csrf @method('PUT')
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi *</label>
                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
                <select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan *</label>
                <input type="text" name="education" value="{{ old('education', $doctor->education) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman (tahun) *</label>
                <input type="number" name="experience" value="{{ old('experience', $doctor->experience) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor STR</label>
                <input type="text" name="str_number" value="{{ old('str_number', $doctor->str_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea name="bio" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $doctor->bio) }}</textarea>
            </div>
            <div class="mb-6">
                <label class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $doctor->is_active ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">Dokter Aktif</span>
                </label>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                <a href="{{ route('admin.dokter.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
