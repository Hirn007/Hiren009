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
    $products = \App\Models\product::limit(10)->get(); // basic fetching for demo
    return view('website.index', compact('products'));
});
Route::get('/index', function () {
    $products = \App\Models\product::limit(10)->get();
    return view('website.index', compact('products'));
});
Route::get('/blank', function () {
    return view('website.blank');
});
Route::get('/checkout', [CheckoutController::class, 'checkoutPage'])->name('checkout.page');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('place.order');

Route::get('/cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.cart');

// Fallback for improper GET requests to add-to-cart
Route::get('/add-to-cart', function(){
    return redirect('/')->with('error', 'Please click the Add to Cart button.');
});

Route::get('/cart/delete/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');

// Fallback for old place-order URL to prevent 404 on refresh
Route::any('/place-order', function() {
    return redirect('/checkout');
});


Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/ajax-search', [ProductController::class, 'ajaxSearch'])->name('product.ajax_search');
Route::get('/product/{id}', [ProductController::class, 'productDetail'])->name('product.detail');
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


// =========================
// Public Admin Login Routes
// =========================
Route::get('/admin-login', [AdminController::class, 'admin_login'])->name('admin.login');
Route::post('/admin-login', [AdminController::class, 'loginCheck'])->name('admin.loginCheck');


// =========================
// Protected Admin Routes
// =========================
Route::middleware(['adminAuth'])->group(function () {

    // Logout
    Route::get('/admin-logout', [AdminController::class, 'admin_logout'])->name('admin.logout');

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CATEGORY ROUTES
    Route::get('/add-category', [CategoryController::class, 'create'])->name('add_category');
    Route::post('/add-category', [CategoryController::class, 'store'])->name('store_category');

    Route::get('/category-management', [CategoryController::class, 'index'])->name('category_management');

    Route::get('/admin/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category_delete');


    // PRODUCT ROUTES
    Route::get('/add-products',[ProductController::class,'create'])->name('add_product');
    Route::post('/add-products',[ProductController::class,'store'])->name('store_products');

    Route::get('/product-management', [ProductController::class, 'index'])->name('product_management');
    Route::get('/admin/get-products/{cat_id}', [ProductController::class, 'getProducts'])->name('get_products');


    // ORDER ROUTES
    Route::get('/order-management', [OrderController::class, 'orderManagement'])->name('order_management');

    Route::get('/add-order', [OrderController::class, 'create'])->name('add_order');
    Route::post('/add-order', [OrderController::class, 'store'])->name('store_order');

    Route::get('admin/order/details/{id}', [OrderController::class, 'show']);
    Route::post('admin/order/update-status/{id}', [OrderController::class, 'updateStatus']);
    Route::get('admin/order/delete/{id}', [OrderController::class, 'deleteOrder']);

    Route::get('admin/orders', [OrderController::class, 'index']);
    Route::get('admin/order/add', [OrderController::class, 'create']);
    Route::post('admin/order/store', [OrderController::class, 'store']);

    Route::get('admin/order/store', function() {
        return redirect('admin/order/add');
    });

    // USER MANAGEMENT
   Route::get('/admin/users', [AdminController::class, 'userManagement'])->name('admin.users');
   Route::get('/admin/users/blocked', [AdminController::class, 'blockedUsers'])->name('admin.users.blocked');

Route::get('/admin/user/block/{id}', [AdminController::class, 'blockUser'])->name('user.block');
Route::get('/admin/user/unblock/{id}', [AdminController::class, 'unblockUser'])->name('user.unblock');
Route::get('/admin/user/view/{id}', [AdminController::class, 'viewUser'])->name('user.view');

});




