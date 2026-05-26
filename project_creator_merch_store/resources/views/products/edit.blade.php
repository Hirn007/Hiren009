{{-- Edit Merch Form --}}
@extends('layouts.layout')
@section('title', 'Edit: ' . $product->name)
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="mb-8 slide-up">
        <a href="{{ route('products.show', $product) }}" class="text-gray-500 hover:text-white transition-colors text-sm mb-4 inline-block">← Back to Product</a>
        <h1 class="font-display text-3xl font-bold gradient-text">Edit Merch</h1>
        <p class="text-gray-400 mt-2">Update "{{ $product->name }}"</p>
    </div>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="glass rounded-2xl p-8 slide-up">
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name <span class="text-accent-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (₹) <span class="text-accent-400">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0.01" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="stock_count" class="block text-sm font-medium text-gray-300 mb-2">Stock Count <span class="text-accent-400">*</span></label>
                <input type="number" name="stock_count" id="stock_count" value="{{ old('stock_count', $product->stock_count) }}" min="0" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('stock_count') border-red-500 @enderror">
                @error('stock_count')
                    <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mb-6">
            <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
            <select name="category_id" id="category_id" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all">
                <option value="" style="background:#1a1a2e;">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }} style="background:#1a1a2e;">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-300 mb-2">Product Image</label>
            @if($product->image)
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current" class="w-20 h-20 object-cover rounded-lg">
                    <span class="text-gray-500 text-sm">Current image</span>
                </div>
            @endif
            <input type="file" name="image" id="image" accept="image/*" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm">
            <p class="text-gray-600 text-xs mt-1">Leave empty to keep current image</p>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-500 text-white py-3 rounded-xl font-medium transition-all btn-glow">💾 Update Product</button>
            <a href="{{ route('products.show', $product) }}" class="bg-white/5 hover:bg-white/10 text-gray-300 px-6 py-3 rounded-xl font-medium transition-all">Cancel</a>
        </div>
    </form>
</div>
@endsection
