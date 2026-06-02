<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration',
        'rating',
        'poster_url',
        'language',
        'release_date',
        'is_active',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
