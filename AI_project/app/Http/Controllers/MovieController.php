<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::where('is_active', true)
            ->with(['shows' => function ($query) {
                $query->where('show_date_time', '>=', now())
                    ->where('is_active', true);
            }])
            ->get();

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie): View
    {
        $shows = $movie->shows()
            ->where('show_date_time', '>=', now())
            ->where('is_active', true)
            ->with('theater')
            ->orderBy('show_date_time')
            ->get()
            ->groupBy(fn ($show) => $show->show_date_time->format('Y-m-d'));

        return view('movies.show', compact('movie', 'shows'));
    }
}
