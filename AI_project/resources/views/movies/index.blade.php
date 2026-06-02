@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8 text-center">Now Showing</h1>

    @if($movies->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg">No movies currently available</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($movies as $movie)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="aspect-video bg-gray-300 overflow-hidden">
                        @if($movie->poster_url)
                            <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full bg-gradient-to-r from-purple-400 to-pink-600">
                                <span class="text-white text-4xl">🎬</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2 line-clamp-2">{{ $movie->title }}</h2>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded">{{ $movie->rating }}</span>
                            <span class="inline-block ml-2 text-gray-600">{{ $movie->duration }} min</span>
                        </p>
                        <p class="text-sm text-gray-500 mb-3">{{ $movie->genre }}</p>
                        @if($movie->shows->count() > 0)
                            <a href="{{ route('movies.show', $movie) }}" class="block w-full bg-red-600 text-white py-2 px-4 rounded text-center hover:bg-red-700 transition">
                                Book Tickets
                            </a>
                        @else
                            <button disabled class="block w-full bg-gray-400 text-white py-2 px-4 rounded text-center cursor-not-allowed">
                                No Shows Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
