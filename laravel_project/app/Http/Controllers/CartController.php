<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
   public function viewCart()
{
    $cartItems = \DB::table('cart')->get();

    return view('website.cart', compact('cartItems'));
}
public function addToCart(Request $request)
{
    \DB::table('cart')->insert([
        'product_id'  => $request->product_id,
        'qty'         => 1,
        'price'       => $request->price,
        'total_price' => $request->price,
        'created_at'  => now(),
    ]);

    return back()->with('success', 'Product added to cart!');
}
}
