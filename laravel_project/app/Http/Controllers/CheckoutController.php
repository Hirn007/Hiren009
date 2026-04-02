<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // SHOW CHECKOUT PAGE
    public function checkoutPage()
    {
        $cartItems = \DB::table('cart')
                        ->join('products', 'cart.product_id', '=', 'products.id')
                        ->select('cart.*', 'products.name as product_name')
                        ->get();
        return view('website.checkout', compact('cartItems'));
    }

    // PLACE ORDER
    public function placeOrder(Request $request)
    {
        // ✔ Validation (form ke names ke according)
        $request->validate([
            'customer_name'    => 'required',
            'customer_phone'   => 'required',
            'customer_email'   => 'nullable|email',
            'customer_address' => 'required',
            'note'             => 'nullable',
            'payment_method'   => 'required'
        ]);

        // ✔ Fetch cart
        $cartItems = \DB::table('cart')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        // ✔ Total price
        $total = $cartItems->sum('total_price');

        // ✔ SAVE ORDER
        $orderId = \DB::table('orders')->insertGetId([
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'customer_email'   => $request->customer_email,
            'customer_address' => $request->customer_address,
            'payment_method'   => $request->payment_method,
            'note'             => $request->note,
            'grand_total'      => $total,
            'status'           => 'Pending',
            'created_at'       => now(),
        ]);

        // ✔ SAVE ORDER ITEMS
        foreach ($cartItems as $item) {
            \DB::table('order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'price'      => $item->price,
                'total'      => $item->total_price,
                'created_at' => now()
            ]);
        }

        // ✔ Empty the cart
        \DB::table('cart')->truncate();

        return redirect('/')->with('success', 'Order placed successfully!');
    }
}