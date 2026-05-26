{{-- Creator Dashboard --}}
@extends('layouts.layout')
@section('title', 'Dashboard - Creator Merch Store')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8 slide-up">
        <h1 class="font-display text-3xl font-bold gradient-text">Creator Dashboard</h1>
        <p class="text-gray-400 mt-2">Welcome back, {{ Auth::user()->name }}! 👋</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 slide-up">
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-brand-500/20 rounded-xl flex items-center justify-center text-2xl">📦</div>
                <div>
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-3xl font-bold text-white">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center text-2xl">🛒</div>
                <div>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                    <p class="text-3xl font-bold text-white">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-accent-400/20 rounded-xl flex items-center justify-center text-2xl">💰</div>
                <div>
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <p class="text-3xl font-bold text-white">₹{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="flex flex-wrap gap-3 mb-10 slide-up">
        <a href="{{ route('products.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all btn-glow">➕ Add New Merch</a>
        <a href="{{ route('products.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all">🛍️ View Store</a>
        <a href="{{ route('orders.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all">📦 View Orders</a>
    </div>

    {{-- My Products --}}
    <div class="mb-10 slide-up">
        <h2 class="font-display text-xl font-bold text-white mb-4">My Products</h2>
        @if($products->count() > 0)
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Product</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Price</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Stock</th>
                            <th class="text-right px-6 py-4 text-gray-400 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-white/5 rounded-lg flex items-center justify-center text-gray-600">📷</div>
                                    @endif
                                    <span class="text-white font-medium">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-brand-400 font-semibold">₹{{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $product->stock_count > 0 ? 'text-green-400' : 'text-red-400' }}">{{ $product->stock_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="text-brand-400 hover:text-brand-300 text-xs px-3 py-1 bg-brand-500/10 rounded-lg">Edit</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-300 text-xs px-3 py-1 bg-red-500/10 rounded-lg">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="glass rounded-2xl p-10 text-center">
            <p class="text-gray-500 mb-4">No products yet. Start building your merch empire!</p>
            <a href="{{ route('products.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow inline-block">➕ Add Your First Product</a>
        </div>
        @endif
    </div>

    {{-- Recent Orders --}}
    <div class="slide-up">
        <h2 class="font-display text-xl font-bold text-white mb-4">Recent Orders</h2>
        @if($orders->count() > 0)
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Order ID</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Customer</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Total</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-b border-white/5 hover:bg-white/5">
                            <td class="px-6 py-4 text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 text-brand-400 font-semibold">₹{{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4"><span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-xs">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="glass rounded-2xl p-10 text-center">
            <p class="text-gray-500">No orders yet. Share your store to get started!</p>
        </div>
        @endif
    </div>
</div>
@endsection
