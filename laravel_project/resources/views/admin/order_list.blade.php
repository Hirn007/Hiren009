@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-4 overflow-hidden">

    <h2 class="text-2xl font-bold mb-4">Order List</h2>

    <a href="{{ url('admin/order/add') }}" class="bg-green-600 text-white px-4 py-2 rounded">
        ➕ Add Order
    </a>

    <table class="w-full border mt-4">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3 border-b">ID</th>
                <th class="p-3 border-b">Customer</th>
                <th class="p-3 border-b">Phone</th>
                <th class="p-3 border-b">Total</th>
                <th class="p-3 border-b">Status</th>
                <th class="p-3 border-b text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-3 text-left">{{ $order->id }}</td>
                <td class="p-3 text-left">{{ $order->customer_name }}</td>
                <td class="p-3 text-left">{{ $order->customer_phone }}</td>
                <td class="p-3 text-left">₹{{ $order->grand_total }}</td>
                <td class="p-3">
                    @if($order->status == 'Pending')
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Pending</span>
                    @elseif($order->status == 'Processing')
                        <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Processing</span>
                    @elseif($order->status == 'Shipped')
                        <span class="bg-purple-500 text-white px-2 py-1 rounded text-xs">Shipped</span>
                    @elseif($order->status == 'Delivered')
                        <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">Delivered</span>
                    @endif
                </td>
                <td class="p-3 text-center">
                    <form action="{{ url('admin/order/update-status/'.$order->id) }}" method="POST" class="inline-flex gap-2">
                        @csrf
                        <select name="status" class="border px-2 py-1 rounded text-sm bg-gray-50 focus:outline-none">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white text-sm px-3 py-1 rounded shadow hover:bg-blue-700">Update</button>
                    </form>
                    <div class="inline-flex gap-2 mt-2 md:mt-0 md:ml-2">
                        <a href="{{ url('admin/order/details/'.$order->id) }}" class="bg-teal-600 text-white text-sm px-3 py-1 rounded shadow hover:bg-teal-700">View</a>
                        <a href="{{ url('admin/order/delete/'.$order->id) }}" class="bg-red-600 text-white text-sm px-3 py-1 rounded shadow hover:bg-red-700">Delete</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</main>

@endsection