{{-- Add New Merch Form with CSRF and @error validation --}}
@extends('layouts.layout')
@section('title', 'Add New Merch')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="mb-8 slide-up">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-white transition-colors text-sm mb-4 inline-block">← Back to Store</a>
        <h1 class="font-display text-3xl font-bold gradient-text">Add New Merch</h1>
        <p class="text-gray-400 mt-2">List a new product in your creator merch store</p>
    </div>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="glass rounded-2xl p-8 slide-up">
        @csrf
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name <span class="text-accent-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Premium Logo T-Shirt"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Describe your merchandise..."
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (₹) <span class="text-accent-400">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0.01" placeholder="299.00"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="stock_count" class="block text-sm font-medium text-gray-300 mb-2">Stock Count <span class="text-accent-400">*</span></label>
                <input type="number" name="stock_count" id="stock_count" value="{{ old('stock_count', 0) }}" min="0" placeholder="50"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all @error('stock_count') border-red-500 @enderror">
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
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} style="background:#1a1a2e;">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-8">
            <label for="image" class="block text-sm font-medium text-gray-300 mb-2">Product Image</label>
            <div class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-brand-500/50 transition-all cursor-pointer" onclick="document.getElementById('image').click()">
                <p class="text-gray-500 text-sm">📷 Click to upload product image (JPEG, PNG, WebP up to 2MB)</p>
                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="document.getElementById('imgName').textContent=this.files[0]?.name||''">
                <p id="imgName" class="text-brand-400 text-sm mt-2"></p>
            </div>
            @error('image')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-500 text-white py-3 rounded-xl font-medium transition-all btn-glow">🚀 Add Product to Store</button>
            <a href="{{ route('products.index') }}" class="bg-white/5 hover:bg-white/10 text-gray-300 px-6 py-3 rounded-xl font-medium transition-all">Cancel</a>
        </div>
    </form>
</div>
@endsection
