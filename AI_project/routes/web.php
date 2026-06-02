<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/shows/{show}/seats', [ShowController::class, 'seatSelection'])->name('shows.seat-selection');
Route::get('/shows/{show}/api/seats', [ShowController::class, 'getSeats']);

// Protected booking routes
Route::middleware('auth')->group(function () {
    Route::get('/bookings/create/{show}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/store/{show}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my-bookings');
});

require __DIR__.'/auth.php';
