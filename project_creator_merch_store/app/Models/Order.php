<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'customer_name',
        'customer_email',
        'quantity',
        'total_price',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Eloquent Relationship: Order belongs to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Eloquent Relationship: Order belongs to a User (optional, for logged-in buyers).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
