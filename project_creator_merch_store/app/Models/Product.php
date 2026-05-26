<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_count',
        'image',
        'category_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock_count' => 'integer',
    ];

    /**
     * Eloquent Relationship: Product belongs to a Category.
     * Preferred over manual joins for cleaner, more readable queries.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Eloquent Relationship: Product belongs to a User (Creator).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Eloquent Relationship: Product has many Orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
