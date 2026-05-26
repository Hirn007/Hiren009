<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| RESTful Resource Routes for the Creator Merch Store.
| Resource routes follow REST conventions for scalability.
|
*/

// ─── Public Routes (Storefront) ─────────────────────────────────────────────

// Home page - redirects to product catalog
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Public product routes - browsing the store
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ─── Dashboard Route ────────────────────────────────────────────────────────

Route::get('/dashboard', function () {
    $products = \App\Models\Product::where('user_id', auth()->id())->latest()->get();
    $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->take(5)->get();
    $totalRevenue = \App\Models\Order::where('user_id', auth()->id())->sum('total_price');
    $totalProducts = $products->count();
    $totalOrders = \App\Models\Order::where('user_id', auth()->id())->count();

    return view('dashboard', compact('products', 'orders', 'totalRevenue', 'totalProducts', 'totalOrders'));
})->middleware(['auth'])->name('dashboard');

// ─── Protected Routes (Auth Middleware) ─────────────────────────────────────
// Only logged-in creators can Add/Edit/Delete products and manage orders.

Route::middleware('auth')->group(function () {

    // Product CRUD - Create, Edit, Update, Delete (protected)
    Route::get('/products/create/new', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // Category CRUD
    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/purchase/{product}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
