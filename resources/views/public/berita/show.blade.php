@extends('layouts.public')

@section('title', $news->title . ' - Rumah Sakit')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article>
            <header class="mb-8">
                <p class="text-sm font-medium text-blue-600 mb-2">{{ $news->category->name }}</p>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $news->title }}</h1>
                <div class="flex items-center text-gray-500">
                    <span>{{ $news->author->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $news->published_at->format('d F Y') }}</span>
                </div>
            </header>

            <div class="h-96 bg-gray-300 rounded-lg mb-8"></div>

            <div class="prose prose-lg max-w-none">
                {!! nl2br(e($news->body)) !!}
            </div>
        </article>

        @if($relatedNews->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Berita Terkait</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($relatedNews as $related)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-32 bg-gray-300"></div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900">{{ $related->title }}</h3>
                        <a href="{{ route('berita.show', $related->slug) }}" class="mt-2 inline-block text-blue-600 hover:text-blue-700 text-sm font-semibold">
                            Baca →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
