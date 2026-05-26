<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Eloquent Relationship: Category has many Products.
     * This is the inverse of the belongsTo relationship in Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
