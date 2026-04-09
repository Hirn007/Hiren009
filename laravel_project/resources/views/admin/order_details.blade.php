@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-6 overflow-hidden">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Order Details - #{{ $order->id }}</h2>
        <a href="{{ url('admin/orders') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow transition">
            🔙 Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Customer Details -->
        <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">
            <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Customer Information</h3>
            <ul class="space-y-2">
                <li><span class="font-semibold text-gray-600">Name:</span> {{ $order->customer_name }}</li>
                <li><span class="font-semibold text-gray-600">Email:</span> {{ $order->customer_email }}</li>
                <li><span class="font-semibold text-gray-600">Phone:</span> {{ $order->customer_phone }}</li>
                <li><span class="font-semibold text-gray-600">Address:</span> {{ $order->customer_address }}</li>
                <li><span class="font-semibold text-gray-600">Note:</span> {{ $order->note ?: 'N/A' }}</li>
            </ul>
        </div>

        <!-- Order Info -->
        <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">
            <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Order Information</h3>
            <ul class="space-y-2">
                <li><span class="font-semibold text-gray-600">Order Date:</span> {{ $order->created_at->format('d M Y, h:i A') }}</li>
                <li><span class="font-semibold text-gray-600">Payment Method:</span> {{ $order->payment_method }}</li>
                <li><span class="font-semibold text-gray-600">Status:</span> 
                    @if($order->status == 'Pending')
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                    @elseif($order->status == 'Processing')
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-medium">Processing</span>
                    @elseif($order->status == 'Shipped')
                        <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs font-medium">Shipped</span>
                    @elseif($order->status == 'Delivered')
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">Delivered</span>
                    @endif
                </li>
                <li><span class="font-semibold text-gray-600">Grand Total:</span> <span class="text-xl font-bold text-green-600">₹{{ $order->grand_total }}</span></li>
            </ul>
        </div>
    </div>

    <!-- Product Items -->
    <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">
        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Purchased Items</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Product</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Quantity</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Unit Price</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $item->product ? $item->product->name : 'Unknown Product' }}
                        </td>
                        <td class="px-4 py-3 text-center text-gray-600">
                            {{ $item->qty }}
                        </td>
                        <td class="px-4 py-3 text-right text-gray-600">
                            ₹{{ $item->price }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">
                            ₹{{ $item->total }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100 border-t border-gray-300 text-right">
                    <tr>
                        <td colspan="3" class="px-4 py-3 font-bold text-gray-700">Subtotal:</td>
                        <td class="px-4 py-3 font-bold text-gray-900 text-lg">₹{{ $order->grand_total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</main>

@endsection
