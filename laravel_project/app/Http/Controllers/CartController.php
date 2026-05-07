<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
   public function viewCart()
{
    $cartItems = \DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->select(
            'cart.id as cart_id',
            'cart.qty',
            'cart.price',
            'cart.total_price',
            'products.name as product_name',
            'products.image'
        )
        ->get();

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

public function deleteCart($id)
{
    \DB::table('cart')->where('id', $id)->delete();
    return back()->with('success', 'Item removed from cart!');
}
}
