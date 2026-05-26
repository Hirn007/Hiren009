<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * OrderController
 * Handles the order simulation workflow.
 * When a user "purchases" an item, triggers a Laravel Mailable
 * to send an Order Confirmation Email.
 */
class OrderController extends Controller
{
    /**
     * Display all orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::with('product')
                       ->where('user_id', Auth::id())
                       ->latest()
                       ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the purchase form for a product.
     */
    public function create(Product $product)
    {
        return view('orders.create', compact('product'));
    }

    /**
     * Process a purchase (Order Simulation).
     * Triggers an Order Confirmation Email via Mail facade.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'     => 'required|exists:products,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'quantity'       => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check stock availability
        if ($product->stock_count < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available!');
        }

        // Calculate total price
        $totalPrice = $product->price * $validated['quantity'];

        // Create the order using Eloquent ORM
        $order = Order::create([
            'product_id'     => $product->id,
            'user_id'        => Auth::id(),
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'quantity'       => $validated['quantity'],
            'total_price'    => $totalPrice,
            'status'         => 'confirmed',
        ]);

        // Reduce stock count
        $product->decrement('stock_count', $validated['quantity']);

        // Send Order Confirmation Email using Mail facade
        // In production, this would use Queue: Mail::to()->queue()
        // For demo, using Mail::to()->send() with the Mailable class
        Mail::to($validated['customer_email'])
            ->send(new OrderConfirmation($order));

        return redirect()->route('orders.index')
                         ->with('success', 'Order placed successfully! Confirmation email sent to ' . $validated['customer_email']);
    }

    /**
     * Display a specific order.
     */
    public function show(Order $order)
    {
        $order->load('product');
        return view('orders.show', compact('order'));
    }
}
