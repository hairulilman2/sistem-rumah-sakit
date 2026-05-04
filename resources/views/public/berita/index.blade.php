@extends('layouts.public')

@section('title', 'Berita - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900">Berita & Artikel</h1>
            <p class="mt-4 text-xl text-gray-500">Informasi kesehatan terkini</p>
        </div>

        <!-- Filter -->
        <div class="mb-8 flex gap-4">
            <form method="GET" class="flex-1 flex gap-4">
                <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}" class="flex-1 rounded-md border-gray-300 shadow-sm">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Cari</button>
            </form>
        </div>

        <!-- Categories -->
        <div class="mb-8 flex gap-2 flex-wrap">
            <a href="{{ route('berita.index') }}" class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">Semua</a>
            @foreach($categories as $category)
            <a href="{{ route('berita.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full {{ request('category') == $category->slug ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ $category->name }} ({{ $category->news_count }})
            </a>
            @endforeach
        </div>

        <!-- News Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($news as $item)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="h-48 bg-gray-300"></div>
                <div class="p-6">
                    <p class="text-sm font-medium text-blue-600">{{ $item->category->name }}</p>
                    <h3 class="mt-2 text-xl font-semibold text-gray-900">{{ $item->title }}</h3>
                    <p class="mt-2 text-gray-500">{{ $item->excerpt }}</p>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span>{{ $item->author->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $item->published_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('berita.show', $item->slug) }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-semibold">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Tidak ada berita ditemukan.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
