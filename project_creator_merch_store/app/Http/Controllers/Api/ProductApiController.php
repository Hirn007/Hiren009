<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * ProductApiController
 * Public-facing API Endpoint that returns JSON response
 * of all available merchandise following REST standards.
 */
class ProductApiController extends Controller
{
    /**
     * GET /api/products
     * Returns a well-structured JSON response of all available merchandise.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category:id,name,slug', 'user:id,name']);

        // Optional: Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Optional: Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->where('stock_count', '>', 0)
                          ->latest()
                          ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data'    => $products->items(),
            'meta'    => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
            ],
        ], 200);
    }

    /**
     * GET /api/products/{id}
     * Returns a single product by ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::with(['category:id,name,slug', 'user:id,name'])
                          ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product retrieved successfully',
            'data'    => $product,
        ], 200);
    }
}
