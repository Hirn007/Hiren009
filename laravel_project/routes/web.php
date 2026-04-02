<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

       //====== website routes ========
      
   
Route::get('/', function () {
    return view('website.index');
});
Route::get('/index', function () {
    return view('website.index');
});
Route::get('/blank', function () {
    return view('website.blank');
});
Route::get('/checkout', [CheckoutController::class, 'checkoutPage'])->name('checkout.page');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('place.order');

Route::get('/cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.cart');
Route::get('/cart/delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');

// Fallback for old place-order URL to prevent 404 on refresh
Route::any('/place-order', function() {
    return redirect('/checkout');
});


Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/store', function () {
    return view('website.store');
});

// Login & Signup
Route::get('/login', [UserAuthController::class, 'login']);
Route::post('/login-check', [UserAuthController::class, 'loginCheck']);

Route::get('/sign-up', [UserAuthController::class, 'signUp']);
Route::post('/sign-up', [UserAuthController::class, 'register']);

// Logout & Account page
Route::get('/logout', [UserAuthController::class, 'logout']);
Route::get('/account', [UserAuthController::class, 'account'])->name('user.account');


       //====== admin routes ========


// Admin Login Routes
Route::get('/admin-login', [AdminController::class, 'admin_login'])->name('admin.login');
Route::post('/admin-login', [AdminController::class, 'loginCheck'])->name('admin.loginCheck');

// Admin Logout
Route::get('/admin-logout', [AdminController::class, 'admin_logout'])->name('admin.logout');

// Dashboard (NO MIDDLEWARE)
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/add-category', [CategoryController::class, 'create'])->name('add_category');
    Route::post('/add-category', [CategoryController::class, 'store'])->name('store_category');

    Route::get('/category-management', [CategoryController::class, 'index'])->name('category_management');

    Route::get('/admin/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category_delete');

     Route::get('/add-products',[ProductController::class,'create'])->name('add_product');
     Route::post('/add-products',[ProductController::class,'store'])->name('store_products');


    Route::get('/product-management', [ProductController::class, 'index'])->name('product_management');
    Route::get('/admin/get-products/{cat_id}', [ProductController::class, 'getProducts'])->name('get_products');

    Route::get('/order-management', function () {
        return view('admin.order_management');
    });
    Route::get('/add-order', [OrderController::class, 'create'])->name('add_order');
    Route::post('/add-order', [OrderController::class, 'store'])->name('store_order');

    Route::get('admin/orders', [OrderController::class, 'index']);
    Route::get('admin/order/add', [OrderController::class, 'create']);
    Route::post('admin/order/store', [OrderController::class, 'store']);
    Route::get('admin/order/store', function() {
        return redirect('admin/order/add');
    });
     Route::get('/user-management', function () {
        return view('admin.user_management');
    });
    




