{{-- Orders Index --}}
@extends('layouts.layout')
@section('title', 'My Orders')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8 slide-up">
        <h1 class="font-display text-3xl font-bold gradient-text">My Orders</h1>
        <p class="text-gray-400 mt-2">Track your merchandise orders</p>
    </div>
    @if($orders->count() > 0)
    <div class="glass rounded-2xl overflow-hidden slide-up">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Order ID</th>
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Product</th>
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Qty</th>
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Total</th>
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Status</th>
                        <th class="text-left px-6 py-4 text-gray-400 font-medium">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-white font-mono">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $order->product->name ?? 'Deleted' }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $order->quantity }}</td>
                        <td class="px-6 py-4 text-brand-400 font-semibold">₹{{ number_format($order->total_price, 2) }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['pending'=>'yellow','confirmed'=>'green','shipped'=>'blue','delivered'=>'green','cancelled'=>'red'];
                                $color = $statusColors[$order->status] ?? 'gray';
                            @endphp
                            <span class="bg-{{ $color }}-500/20 text-{{ $color }}-400 px-3 py-1 rounded-full text-xs font-medium">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
    @else
    <div class="glass rounded-2xl p-12 text-center slide-up">
        <div class="text-5xl mb-4">📦</div>
        <h3 class="font-display text-xl text-gray-400 mb-2">No orders yet</h3>
        <p class="text-gray-600 mb-4">Browse our store and make your first purchase!</p>
        <a href="{{ route('products.index') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow inline-block">🛍️ Browse Store</a>
    </div>
    @endif
</div>
@endsection
