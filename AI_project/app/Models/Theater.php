<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    protected $fillable = [
        'name',
        'city',
        'address',
        'total_screens',
    ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
