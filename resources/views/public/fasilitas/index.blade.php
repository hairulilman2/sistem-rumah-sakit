@extends('layouts.public')

@section('title', 'Fasilitas - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Fasilitas Kami</h1>
            <p class="mt-4 text-xl text-gray-500">Fasilitas lengkap untuk kenyamanan Anda</p>
        </div>

        @foreach($facilities as $category => $items)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $category }}</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach($items as $facility)
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="text-blue-600 mb-4 flex justify-center">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $facility->name }}</h3>
                    <p class="text-gray-500 text-sm">{{ $facility->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
