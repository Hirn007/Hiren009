{{-- Purchase / Order Creation Form --}}
@extends('layouts.layout')
@section('title', 'Purchase: ' . $product->name)
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-8 slide-up">
        <a href="{{ route('products.show', $product) }}" class="text-gray-500 hover:text-white transition-colors text-sm mb-4 inline-block">← Back to Product</a>
        <h1 class="font-display text-3xl font-bold gradient-text">Complete Purchase</h1>
    </div>
    {{-- Product Summary --}}
    <div class="glass rounded-2xl p-6 mb-6 slide-up">
        <div class="flex items-center gap-4">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 rounded-xl object-cover">
            @else
                <div class="w-20 h-20 bg-white/5 rounded-xl flex items-center justify-center text-3xl">🛍️</div>
            @endif
            <div>
                <h3 class="text-white font-semibold text-lg">{{ $product->name }}</h3>
                <p class="text-brand-400 text-xl font-bold">₹{{ number_format($product->price, 2) }}</p>
                <p class="text-gray-500 text-sm">{{ $product->stock_count }} in stock</p>
            </div>
        </div>
    </div>
    {{-- Order Form --}}
    <form method="POST" action="{{ route('orders.store') }}" class="glass rounded-2xl p-8 slide-up">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="mb-6">
            <label for="customer_name" class="block text-sm font-medium text-gray-300 mb-2">Your Name <span class="text-accent-400">*</span></label>
            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', Auth::user()->name) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('customer_name') border-red-500 @enderror">
            @error('customer_name')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="customer_email" class="block text-sm font-medium text-gray-300 mb-2">Email Address <span class="text-accent-400">*</span></label>
            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', Auth::user()->email) }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('customer_email') border-red-500 @enderror">
            @error('customer_email')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
            <p class="text-gray-600 text-xs mt-1">Order confirmation will be sent to this email</p>
        </div>
        <div class="mb-8">
            <label for="quantity" class="block text-sm font-medium text-gray-300 mb-2">Quantity <span class="text-accent-400">*</span></label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock_count }}"
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-all @error('quantity') border-red-500 @enderror">
            @error('quantity')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="bg-white/5 rounded-xl p-4 mb-6">
            <div class="flex justify-between text-sm text-gray-400 mb-2">
                <span>Price per item</span>
                <span>₹{{ number_format($product->price, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold text-white border-t border-white/10 pt-2">
                <span>Estimated Total</span>
                <span class="text-brand-400" id="totalPrice">₹{{ number_format($product->price, 2) }}</span>
            </div>
        </div>
        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white py-3 rounded-xl font-medium transition-all btn-glow">🛒 Place Order & Send Confirmation</button>
    </form>
</div>
<script>
    document.getElementById('quantity').addEventListener('input', function() {
        const qty = parseInt(this.value) || 1;
        const price = {{ $product->price }};
        document.getElementById('totalPrice').textContent = '₹' + (qty * price).toFixed(2);
    });
</script>
@endsection
