{{-- Product Detail View --}}
@extends('layouts.layout')

@section('title', $product->name . ' - Creator Merch Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-white transition-colors">🛍️ Store</a>
        <span class="text-gray-600 mx-2">/</span>
        @if($product->category)
            <span class="text-gray-500">{{ $product->category->name }}</span>
            <span class="text-gray-600 mx-2">/</span>
        @endif
        <span class="text-brand-400">{{ $product->name }}</span>
    </nav>

    {{-- Product Detail Card --}}
    <div class="glass rounded-2xl overflow-hidden slide-up">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

            {{-- Product Image --}}
            <div class="relative h-96 lg:h-full bg-gradient-to-br from-brand-900/30 to-dark-800">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="p-8 lg:p-12 flex flex-col justify-center">
                @if($product->category)
                    <span class="inline-block bg-brand-500/20 text-brand-400 text-xs px-3 py-1 rounded-full font-medium mb-4 w-fit">
                        {{ $product->category->name }}
                    </span>
                @endif

                <h1 class="font-display text-3xl lg:text-4xl font-bold text-white mb-4">{{ $product->name }}</h1>

                <p class="text-gray-400 text-base leading-relaxed mb-6">
                    {{ $product->description ?? 'No description available for this product.' }}
                </p>

                <div class="flex items-center gap-4 mb-6">
                    <span class="text-4xl font-bold gradient-text">₹{{ number_format($product->price, 2) }}</span>
                    @if($product->stock_count > 0)
                        <span class="bg-green-500/20 text-green-400 text-sm px-3 py-1 rounded-full">
                            ✅ {{ $product->stock_count }} in stock
                        </span>
                    @else
                        <span class="bg-red-500/20 text-red-400 text-sm px-3 py-1 rounded-full">
                            ❌ Out of stock
                        </span>
                    @endif
                </div>

                {{-- Creator Info --}}
                @if($product->user)
                    <div class="flex items-center gap-3 mb-8 p-4 bg-white/5 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-accent-400 rounded-full flex items-center justify-center font-bold">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">{{ $product->user->name }}</p>
                            <p class="text-gray-500 text-xs">Creator</p>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-3">
                    @auth
                        @if($product->stock_count > 0)
                            <a href="{{ route('orders.create', $product) }}"
                               class="bg-brand-600 hover:bg-brand-500 text-white px-8 py-3 rounded-xl font-medium transition-all btn-glow text-center flex-1 sm:flex-none">
                                🛒 Purchase Now
                            </a>
                        @endif

                        @if($product->user_id === Auth::id())
                            <a href="{{ route('products.edit', $product) }}"
                               class="bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded-xl font-medium transition-all text-center">
                                ✏️ Edit
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-6 py-3 rounded-xl font-medium transition-all">
                                    🗑️ Delete
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-8 py-3 rounded-xl font-medium transition-all btn-glow">
                            Login to Purchase
                        </a>
                    @endauth

                    <a href="{{ route('products.index') }}" class="bg-white/5 hover:bg-white/10 text-gray-300 px-6 py-3 rounded-xl font-medium transition-all">
                        ← Back to Store
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="font-display text-2xl font-bold text-white mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related) }}" class="glass rounded-xl overflow-hidden card-hover group block">
                        <div class="h-40 bg-gradient-to-br from-brand-900/30 to-dark-800 overflow-hidden">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="text-white font-medium text-sm truncate">{{ $related->name }}</h4>
                            <p class="text-brand-400 font-bold mt-1">₹{{ number_format($related->price, 2) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
