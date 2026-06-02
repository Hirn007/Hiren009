@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-2">My Bookings</h1>
    <p class="text-gray-600 mb-8">View and manage all your ticket bookings</p>

    @if($bookings->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">🎬</div>
            <h2 class="text-2xl font-semibold mb-2">No bookings yet</h2>
            <p class="text-gray-600 mb-6">You haven't booked any tickets yet. Let's book some movies!</p>
            <a href="{{ route('movies.index') }}" class="inline-block bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition">
                Browse Movies
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <div class="md:col-span-2">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-2xl font-bold">{{ $booking->show->movie->title }}</h2>
                                    <p class="text-gray-600 mt-1">Booking Reference: <span class="font-mono font-semibold">{{ $booking->booking_reference }}</span></p>
                                </div>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $booking->status === 'confirmed' 
                                        ? 'bg-green-100 text-green-800' 
                                        : ($booking->status === 'pending' 
                                            ? 'bg-yellow-100 text-yellow-800' 
                                            : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm mb-4">
                                <div>
                                    <p class="text-gray-600">Theater</p>
                                    <p class="font-semibold">{{ $booking->show->theater->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Date & Time</p>
                                    <p class="font-semibold">{{ $booking->show->show_date_time->format('d M Y, g:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Seats</p>
                                    <p class="font-semibold">{{ implode(', ', $booking->seat_numbers) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Screen</p>
                                    <p class="font-semibold">{{ $booking->show->screen_number }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Tickets</p>
                                    <p class="font-semibold">{{ $booking->total_seats }} Seat(s)</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Booked On</p>
                                    <p class="font-semibold">{{ $booking->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold mb-3">Total Price</h3>
                            <div class="space-y-2 text-sm mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between">
                                    <span>Tickets</span>
                                    <span>₹{{ number_format($booking->total_price, 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>GST (18%)</span>
                                    <span>₹{{ number_format($booking->total_price * 0.18, 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Charges</span>
                                    <span>₹{{ number_format($booking->total_price * 0.02, 0) }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-red-600">₹{{ number_format($booking->total_price + ($booking->total_price * 0.18) + ($booking->total_price * 0.02), 0) }}</span>
                            </div>

                            @if($booking->show->show_date_time->isFuture())
                                <button class="w-full mt-4 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 text-sm font-semibold transition">
                                    Manage Booking
                                </button>
                            @else
                                <div class="w-full mt-4 px-4 py-2 bg-gray-200 rounded-lg text-center text-sm font-semibold text-gray-600">
                                    Show Completed
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
