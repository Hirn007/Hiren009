@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Review Your Booking</h1>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <p class="text-blue-700"><strong>Booking Reference:</strong> Will be generated after confirmation</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Show Details</h2>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                        <p><strong>Movie:</strong> {{ $show->movie->title }}</p>
                        <p><strong>Theater:</strong> {{ $show->theater->name }}, {{ $show->theater->city }}</p>
                        <p><strong>Screen:</strong> {{ $show->screen_number }}</p>
                        <p><strong>Date & Time:</strong> {{ $show->show_date_time->format('d M Y, g:i A') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Seats Selected</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-lg font-semibold text-red-600">{{ implode(', ', $seats->pluck('seat_number')->toArray()) }}</p>
                        <p class="text-sm text-gray-600 mt-2">Total: {{ $seats->count() }} seat(s)</p>
                    </div>
                </div>

                <form action="{{ route('bookings.store', $show) }}" method="POST" class="mt-8">
                    @csrf
                    @foreach($seats as $seat)
                        <input type="hidden" name="seat_numbers[]" value="{{ $seat->seat_number }}">
                    @endforeach

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                        <p class="text-yellow-700"><strong>Note:</strong> Please review your booking details before confirming. After confirmation, you will receive a booking reference.</p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('shows.seat-selection', $show) }}" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-center font-semibold transition">
                            Change Seats
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4">Price Breakdown</h2>
                
                <div class="space-y-3 mb-4 pb-4 border-b border-gray-200">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ticket Price ({{ $seats->count() }} × ₹{{ number_format($show->ticket_price, 0) }})</span>
                        <span class="font-semibold">₹{{ number_format($total_price, 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">GST (18%)</span>
                        <span class="font-semibold">₹{{ number_format($total_price * 0.18, 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Convenience Charges</span>
                        <span class="font-semibold">₹{{ number_format($total_price * 0.02, 0) }}</span>
                    </div>
                </div>

                <div class="flex justify-between font-bold text-lg mb-6 pb-6 border-b border-gray-200">
                    <span>Total Amount:</span>
                    <span class="text-red-600">₹{{ number_format($total_price + ($total_price * 0.18) + ($total_price * 0.02), 0) }}</span>
                </div>

                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-green-700 text-sm">
                        <strong>✓</strong> Your seats are reserved for 10 minutes only
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
