@extends('layouts.public')

@section('title', 'Layanan - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Layanan Kami</h1>
            <p class="mt-4 text-xl text-gray-500">Berbagai layanan kesehatan untuk kebutuhan Anda</p>
        </div>

        @foreach($departments as $department)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $department->name }}</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($department->services as $service)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-500 mb-4">{{ $service->description ?? 'Layanan ' . $service->name }}</p>
                    <p class="text-blue-600 font-semibold">{{ $service->price_range }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
