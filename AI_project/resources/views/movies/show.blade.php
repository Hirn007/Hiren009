@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('movies.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back to Movies</a>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="aspect-video bg-gray-300 rounded-lg overflow-hidden">
                    @if($movie->poster_url)
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full bg-gradient-to-r from-purple-400 to-pink-600">
                            <span class="text-white text-4xl">🎬</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="md:col-span-2">
                <h1 class="text-4xl font-bold mb-3">{{ $movie->title }}</h1>
                <div class="mb-4">
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded mr-2">{{ $movie->rating }}</span>
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded">{{ $movie->language }}</span>
                </div>
                <p class="text-gray-700 mb-4"><strong>Genre:</strong> {{ $movie->genre }}</p>
                <p class="text-gray-700 mb-4"><strong>Duration:</strong> {{ $movie->duration }} minutes</p>
                <p class="text-gray-700 mb-4"><strong>Release Date:</strong> {{ $movie->release_date->format('d M Y') }}</p>
                <p class="text-gray-600">{{ $movie->description }}</p>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6">Available Shows</h2>

    @if($shows->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
            <p class="font-bold">No shows available</p>
        </div>
    @else
        @foreach($shows as $date => $showsByDate)
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">{{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($showsByDate as $show)
                        <div class="bg-white rounded-lg border border-gray-300 p-4 hover:shadow-lg transition">
                            <div class="mb-3">
                                <p class="text-lg font-semibold text-red-600">{{ $show->show_date_time->format('g:i A') }}</p>
                                <p class="text-sm text-gray-600">{{ $show->theater->name }}</p>
                                <p class="text-sm text-gray-500">{{ $show->theater->city }} - Screen {{ $show->screen_number }}</p>
                            </div>
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Available Seats:</span>
                                    <span class="font-semibold {{ $show->available_seats > 10 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $show->available_seats }} / {{ $show->total_seats }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($show->available_seats / $show->total_seats) * 100 }}%"></div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold">₹{{ number_format($show->ticket_price, 0) }}</p>
                                @auth
                                    <a href="{{ route('shows.seat-selection', $show) }}" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition text-sm">
                                        Book Now
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition text-sm">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
