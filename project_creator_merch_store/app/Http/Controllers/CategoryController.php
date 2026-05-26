<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * CategoryController - Resource Controller
 * Handles full CRUD operations for product categories.
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     * GET /categories
     */
    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     * GET /categories/create
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in the database.
     * POST /categories
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Auto-generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
                        ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing a category.
     * GET /categories/{category}/edit
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the database.
     * PUT/PATCH /categories/{category}
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Auto-generate slug from name
        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')
                        ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete a category from the database.
     * DELETE /categories/{category}
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                            ->with('error', 'Cannot delete category with existing products. Please reassign or delete those products first.');
        }

        $category->delete();

        return redirect()->route('categories.index')
                        ->with('success', 'Category deleted successfully!');
    }
}
