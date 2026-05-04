@extends('layouts.public')

@section('title', 'Galeri - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Galeri</h1>
            <p class="mt-4 text-xl text-gray-500">Dokumentasi kegiatan dan fasilitas kami</p>
        </div>

        <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-4">
            @forelse($galleries as $gallery)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-48 bg-gray-300"></div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $gallery->description }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-12">
                <p class="text-gray-500">Belum ada galeri.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    </div>
</div>
@endsection
