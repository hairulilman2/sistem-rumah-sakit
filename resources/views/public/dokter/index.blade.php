@extends('layouts.public')

@section('title', 'Daftar Dokter - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Dokter Kami</h1>
            <p class="mt-4 text-xl text-gray-500">Tim dokter profesional dan berpengalaman</p>
        </div>

        <!-- Filter -->
        <div class="mb-8">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" placeholder="Cari dokter..." value="{{ request('search') }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <select name="specialization" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Spesialisasi</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Filter</button>
            </form>
        </div>

        <!-- Doctors Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($doctors as $doctor)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-48 bg-gray-300 flex items-center justify-center">
                    <svg class="h-24 w-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <p class="text-sm font-medium text-blue-600">{{ $doctor->specialization }}</p>
                    <h3 class="mt-2 text-xl font-semibold text-gray-900">{{ $doctor->user->name }}</h3>
                    <p class="mt-2 text-gray-500">{{ Str::limit($doctor->bio ?? 'Dokter spesialis ' . $doctor->specialization, 100) }}</p>
                    <p class="mt-2 text-sm text-gray-500">Pengalaman: {{ $doctor->experience }} tahun</p>
                    <a href="{{ route('dokter.show', $doctor->id) }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-semibold">
                        Lihat Profil →
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Tidak ada dokter ditemukan.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
