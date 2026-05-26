{{-- Products Index - Merch Catalog Storefront --}}
@extends('layouts.layout')

@section('title', 'Merch Store - Creator Merch Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Hero Section --}}
    <div class="text-center mb-12 slide-up">
        <h1 class="font-display text-4xl md:text-5xl font-bold mb-4">
            <span class="gradient-text">Creator Merch</span> Store
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            Discover exclusive merchandise from your favorite content creators. Premium quality, unique designs.
        </p>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="glass rounded-2xl p-6 mb-8 slide-up">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="🔍 Search merchandise..."
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div class="md:w-48">
                <select name="category"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all"
                    onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}
                            style="background: #1a1a2e;">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow">
                Search
            </button>
        </form>
    </div>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="glass rounded-2xl overflow-hidden card-hover group">
                    {{-- Product Image --}}
                    <div class="relative h-56 bg-gradient-to-br from-brand-900/50 to-dark-800 overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Stock Badge --}}
                        @if($product->stock_count > 0)
                            <div class="absolute top-3 right-3 bg-green-500/90 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">
                                In Stock ({{ $product->stock_count }})
                            </div>
                        @else
                            <div class="absolute top-3 right-3 bg-red-500/90 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">
                                Out of Stock
                            </div>
                        @endif

                        {{-- Category Badge --}}
                        @if($product->category)
                            <div class="absolute top-3 left-3 bg-brand-500/90 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">
                                {{ $product->category->name }}
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="p-5">
                        <h3 class="font-display font-semibold text-lg text-white mb-1 truncate">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>

                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-brand-400">₹{{ number_format($product->price, 2) }}</span>
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                   class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg text-sm transition-all">
                                    View
                                </a>
                                @auth
                                    @if($product->stock_count > 0)
                                        <a href="{{ route('orders.create', $product) }}"
                                           class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-lg text-sm transition-all btn-glow">
                                            Buy
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        {{-- Creator Info --}}
                        @if($product->user)
                            <div class="mt-3 pt-3 border-t border-white/5 flex items-center gap-2">
                                <div class="w-5 h-5 bg-gradient-to-br from-brand-400 to-accent-400 rounded-full flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-500 text-xs">by {{ $product->user->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10 flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-20 glass rounded-2xl">
            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="font-display text-xl text-gray-400 mb-2">No merchandise found</h3>
            <p class="text-gray-600">Check back later for new drops!</p>
            @auth
                <a href="{{ route('products.create') }}" class="inline-block mt-4 bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow">
                    ➕ Add Your First Product
                </a>
            @endauth
        </div>
    @endif
</div>
@endsection
