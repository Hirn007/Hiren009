<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Seat;
use Illuminate\View\View;

class ShowController extends Controller
{
    public function seatSelection(Show $show): View
    {
        $show->load(['movie', 'theater', 'seats']);
        
        $seats = $show->seats()
            ->orderBy('seat_number')
            ->get()
            ->groupBy(function ($seat) {
                return substr($seat->seat_number, 0, 1); // Group by row
            });

        return view('shows.seat-selection', compact('show', 'seats'));
    }

    public function getSeats(Show $show)
    {
        $seats = $show->seats()->get();
        
        return response()->json([
            'seats' => $seats,
            'total_price' => $show->ticket_price,
        ]);
    }
}
