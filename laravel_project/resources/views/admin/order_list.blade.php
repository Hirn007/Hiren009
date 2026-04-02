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
                <td class="p-3 text-center">
                    <button class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</main>

@endsection