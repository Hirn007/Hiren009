@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('movies.show', $show->movie) }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">&larr; Back</a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-4">{{ $show->movie->title }}</h1>
                <p class="text-gray-600 mb-4">{{ $show->theater->name }} - Screen {{ $show->screen_number }}</p>
                <p class="text-gray-600 mb-6">{{ $show->show_date_time->format('d M Y g:i A') }}</p>

                <div class="mb-8">
                    <div class="bg-gray-200 text-gray-700 text-center py-2 mb-6 rounded">SCREEN</div>
                    
                    <form id="bookingForm" action="{{ route('bookings.create', $show) }}" method="GET">
                        <div class="space-y-4">
                            @foreach($seats as $row => $rowSeats)
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <span class="font-semibold mr-4 inline-block w-8">{{ $row }}</span>
                                    @foreach($rowSeats as $seat)
                                        <button type="button"
                                                data-seat="{{ $seat->seat_number }}"
                                                class="seat-btn w-10 h-10 rounded border-2 font-semibold transition-all
                                                    {{ $seat->status === 'available' 
                                                        ? 'bg-green-400 border-green-600 hover:bg-green-500 cursor-pointer' 
                                                        : 'bg-gray-400 border-gray-600 cursor-not-allowed' }}"
                                                {{ $seat->status !== 'available' ? 'disabled' : '' }}>
                                            {{ substr($seat->seat_number, 1) }}
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                            <h3 class="font-semibold mb-2">Seat Legend:</h3>
                            <div class="flex gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-green-400 border-2 border-green-600 rounded"></div>
                                    <span>Available</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-gray-400 border-2 border-gray-600 rounded"></div>
                                    <span>Booked</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-blue-400 border-2 border-blue-600 rounded"></div>
                                    <span>Selected</span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="selectedSeats" name="seats" value="">

                        <button type="submit" id="proceedBtn" 
                                class="mt-6 w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Proceed to Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4">Booking Summary</h2>
                
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <p class="text-sm text-gray-600"><strong>Movie:</strong> {{ $show->movie->title }}</p>
                    <p class="text-sm text-gray-600"><strong>Theater:</strong> {{ $show->theater->name }}</p>
                    <p class="text-sm text-gray-600"><strong>Date & Time:</strong> {{ $show->show_date_time->format('d M Y g:i A') }}</p>
                    <p class="text-sm text-gray-600"><strong>Price:</strong> ₹{{ number_format($show->ticket_price, 0) }} per ticket</p>
                </div>

                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-600 mb-2">Selected Seats:</p>
                    <div id="selectedSeatsList" class="space-y-1">
                        <p class="text-gray-500 text-sm">No seats selected</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Subtotal:</span>
                        <span id="subtotal">₹0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Taxes & Charges:</span>
                        <span id="charges">₹0</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg pt-2 border-t border-gray-200">
                        <span>Total:</span>
                        <span id="total" class="text-red-600">₹0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedSeats = new Set();
    const price = {{ $show->ticket_price }};
    const taxRate = 0.18; // 18% GST

    document.querySelectorAll('.seat-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const seatNum = this.dataset.seat;
            
            if (this.disabled) return;
            
            if (selectedSeats.has(seatNum)) {
                selectedSeats.delete(seatNum);
                this.classList.remove('bg-blue-400', 'border-blue-600');
                this.classList.add('bg-green-400', 'border-green-600');
            } else {
                selectedSeats.add(seatNum);
                this.classList.remove('bg-green-400', 'border-green-600');
                this.classList.add('bg-blue-400', 'border-blue-600');
            }
            
            updateSummary();
        });
    });

    function updateSummary() {
        const seatsArray = Array.from(selectedSeats).sort();
        document.getElementById('selectedSeats').value = seatsArray.join(',');
        
        // Update selected seats list
        const list = document.getElementById('selectedSeatsList');
        if (seatsArray.length === 0) {
            list.innerHTML = '<p class="text-gray-500 text-sm">No seats selected</p>';
        } else {
            list.innerHTML = `<p class="text-sm font-semibold">${seatsArray.join(', ')}</p>`;
        }
        
        // Calculate totals
        const subtotal = price * seatsArray.length;
        const charges = Math.floor(subtotal * taxRate);
        const total = subtotal + charges;
        
        document.getElementById('subtotal').textContent = '₹' + subtotal.toLocaleString('en-IN');
        document.getElementById('charges').textContent = '₹' + charges.toLocaleString('en-IN');
        document.getElementById('total').textContent = '₹' + total.toLocaleString('en-IN');
        
        // Enable/disable proceed button
        document.getElementById('proceedBtn').disabled = seatsArray.length === 0;
    }
});
</script>
@endsection
