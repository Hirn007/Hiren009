@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">✓</div>
            <h1 class="text-4xl font-bold text-green-600 mb-2">Booking Confirmed!</h1>
            <p class="text-gray-600">Your tickets have been booked successfully</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <p class="text-green-700"><strong>Booking Reference:</strong></p>
                <p class="text-2xl font-bold text-green-600">{{ $booking->booking_reference }}</p>
                <p class="text-sm text-green-600 mt-2">Save this reference for your records</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Show Details</h2>
                    <div class="space-y-3">
                        <p><strong class="block text-gray-600">Movie</strong> <span class="text-lg">{{ $booking->show->movie->title }}</span></p>
                        <p><strong class="block text-gray-600">Theater</strong> <span>{{ $booking->show->theater->name }}</span></p>
                        <p><strong class="block text-gray-600">Location</strong> <span>{{ $booking->show->theater->city }}</span></p>
                        <p><strong class="block text-gray-600">Screen</strong> <span>{{ $booking->show->screen_number }}</span></p>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-4 border-b pb-2">Booking Details</h2>
                    <div class="space-y-3">
                        <p><strong class="block text-gray-600">Date & Time</strong> <span>{{ $booking->show->show_date_time->format('d M Y, g:i A') }}</span></p>
                        <p><strong class="block text-gray-600">Seats</strong> <span class="text-lg font-semibold text-red-600">{{ implode(', ', $booking->seat_numbers) }}</span></p>
                        <p><strong class="block text-gray-600">Number of Tickets</strong> <span>{{ $booking->total_seats }}</span></p>
                        <p><strong class="block text-gray-600">Booking Status</strong> <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded">{{ ucfirst($booking->status) }}</span></p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <h2 class="text-lg font-semibold mb-4">Price Breakdown</h2>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span>Ticket Price ({{ $booking->total_seats }} × ₹{{ number_format($booking->show->ticket_price, 0) }})</span>
                        <span>₹{{ number_format($booking->total_price, 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>GST (18%)</span>
                        <span>₹{{ number_format($booking->total_price * 0.18, 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Convenience Charges</span>
                        <span>₹{{ number_format($booking->total_price * 0.02, 0) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total Paid</span>
                        <span class="text-red-600">₹{{ number_format($booking->total_price + ($booking->total_price * 0.18) + ($booking->total_price * 0.02), 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <p class="text-blue-700"><strong>Important:</strong></p>
                <ul class="text-blue-700 text-sm mt-2 space-y-1">
                    <li>• Please arrive at least 15 minutes before the show time</li>
                    <li>• Carry a valid ID proof for verification</li>
                    <li>• You will receive a confirmation email shortly</li>
                    <li>• Cancellation allowed up to 2 hours before show time</li>
                </ul>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('bookings.my-bookings') }}" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition text-center">
                    View All Bookings
                </a>
                <a href="{{ route('movies.index') }}" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-semibold transition text-center">
                    Book More Tickets
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
