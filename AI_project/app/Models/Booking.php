<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'show_id',
        'seat_numbers',
        'total_seats',
        'total_price',
        'status',
        'booking_reference',
        'payment_date',
    ];

    protected $casts = [
        'seat_numbers' => 'array',
        'total_price' => 'decimal:2',
        'booked_at' => 'datetime',
        'payment_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
}
