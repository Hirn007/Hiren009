<?php

use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Public-facing RESTful API Endpoints for the Creator Merch Store.
| Returns well-structured JSON responses following REST standards.
|
*/

// ─── Public API Endpoints ───────────────────────────────────────────────────

// GET /api/products - Returns JSON of all available merchandise
Route::get('/products', [ProductApiController::class, 'index']);

// GET /api/products/{id} - Returns a single product by ID
Route::get('/products/{id}', [ProductApiController::class, 'show']);

// ─── Authenticated API Endpoints ────────────────────────────────────────────

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
