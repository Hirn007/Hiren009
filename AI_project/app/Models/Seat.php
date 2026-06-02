<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'show_id',
        'seat_number',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_BOOKED = 'booked';
    public const STATUS_BLOCKED = 'blocked';
}
