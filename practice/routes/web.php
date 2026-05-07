<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AdminController::class, 'index']);
Route::get('/index', [AdminController::class, 'index']);
Route::post('/admin', [AdminController::class, 'admin_auth'])->name('admin.auth');
Route::get('/admin_logout', [AdminController::class, 'admin_logout']);




Route::get('/dashboard', function () {
    return view('dashboard');
});



Route::get('/add_product', function () {
    return view('add_product');
});



Route::get('/edit_product', function () {
    return view('edit_product');
});

Route::get('/delete_product', function () {
    return view('delete_product');
});
