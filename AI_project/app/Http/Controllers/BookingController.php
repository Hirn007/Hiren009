<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Show;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, Show $show): View
    {
        $seatNumbers = $request->query('seats', []);
        if (is_string($seatNumbers)) {
            $seatNumbers = explode(',', $seatNumbers);
        }

        $seats = $show->seats()
            ->whereIn('seat_number', $seatNumbers)
            ->where('status', Seat::STATUS_AVAILABLE)
            ->get();

        if ($seats->count() !== count($seatNumbers)) {
            return back()->with('error', 'Some seats are no longer available');
        }

        $total_price = $show->ticket_price * count($seatNumbers);

        return view('bookings.create', compact('show', 'seats', 'total_price'));
    }

    public function store(Request $request, Show $show)
    {
        $request->validate([
            'seat_numbers' => 'required|array|min:1',
            'seat_numbers.*' => 'string',
        ]);

        $seatNumbers = $request->seat_numbers;

        // Check seat availability
        $seats = $show->seats()
            ->whereIn('seat_number', $seatNumbers)
            ->where('status', Seat::STATUS_AVAILABLE)
            ->lockForUpdate()
            ->get();

        if ($seats->count() !== count($seatNumbers)) {
            return back()->with('error', 'Some seats are no longer available');
        }

        // Create booking
        $totalPrice = $show->ticket_price * count($seatNumbers);
        $bookingReference = 'BMS' . Str::upper(Str::random(8));

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'show_id' => $show->id,
            'seat_numbers' => $seatNumbers,
            'total_seats' => count($seatNumbers),
            'total_price' => $totalPrice,
            'booking_reference' => $bookingReference,
            'status' => Booking::STATUS_CONFIRMED,
            'payment_date' => now(),
        ]);

        // Mark seats as booked
        Seat::whereIn('seat_number', $seatNumbers)
            ->where('show_id', $show->id)
            ->update(['status' => Seat::STATUS_BOOKED]);

        // Update available seats count
        $show->update([
            'available_seats' => $show->available_seats - count($seatNumbers),
        ]);

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Booking confirmed!');
    }

    public function confirmation(Booking $booking): View
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['show' => function ($query) {
            $query->with(['movie', 'theater']);
        }]);

        return view('bookings.confirmation', compact('booking'));
    }

    public function myBookings(): View
    {
        $bookings = auth()->user()->bookings()
            ->with(['show' => function ($query) {
                $query->with(['movie', 'theater']);
            }])
            ->orderByDesc('created_at')
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }
}
