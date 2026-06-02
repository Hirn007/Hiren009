<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    protected $fillable = [
        'movie_id',
        'theater_id',
        'show_date_time',
        'screen_number',
        'ticket_price',
        'total_seats',
        'available_seats',
        'is_active',
    ];

    protected $casts = [
        'show_date_time' => 'datetime',
        'ticket_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
