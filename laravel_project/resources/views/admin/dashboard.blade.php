@extends('admin.layout.structure')
@section('content')

<!--Main-->
<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <!-- Page Title -->
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>

    <!-- Stats Row -->
    <div class="flex flex-col md:flex-row lg:flex-row mb-4 space-x-0 md:space-x-4">
        <div class="shadow-lg bg-red-500 border-l-8 hover:bg-red-700 border-red-700 mb-2 p-4 md:w-1/4">
            <div class="text-white text-lg">Total Sales</div>
            <div class="text-white text-2xl font-bold">$199.4</div>
        </div>
        <div class="shadow-lg bg-blue-500 border-l-8 hover:bg-blue-700 border-blue-700 mb-2 p-4 md:w-1/4">
            <div class="text-white text-lg">Total Cost</div>
            <div class="text-white text-2xl font-bold">$199.4</div>
        </div>
        <div class="shadow-lg bg-yellow-500 border-l-8 hover:bg-yellow-700 border-yellow-700 mb-2 p-4 md:w-1/4">
            <div class="text-white text-lg">Total Users</div>
            <div class="text-white text-2xl font-bold">900</div>
        </div>
        <div class="shadow-lg bg-green-500 border-l-8 hover:bg-green-700 border-green-700 mb-2 p-4 md:w-1/4">
            <div class="text-white text-lg">Total Products</div>
            <div class="text-white text-2xl font-bold">500</div>
        </div>
    </div>

    <!-- Trending Categories Table -->
    <div class="shadow bg-white rounded p-4 mb-4">
        <h3 class="font-bold text-xl mb-2">Trending Categories</h3>
        <table class="table-auto w-full text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-2 py-1">#</th>
                    <th class="px-2 py-1">Item</th>
                    <th class="px-2 py-1">Last</th>
                    <th class="px-2 py-1">Current</th>
                    <th class="px-2 py-1">Change</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-2 py-1">1</td>
                    <td class="border px-2 py-1">Twitter</td>
                    <td class="border px-2 py-1">4500</td>
                    <td class="border px-2 py-1">4600</td>
                    <td class="border px-2 py-1 text-green-500">+5%</td>
                </tr>
                <tr>
                    <td class="border px-2 py-1">2</td>
                    <td class="border px-2 py-1">Facebook</td>
                    <td class="border px-2 py-1">10000</td>
                    <td class="border px-2 py-1">3000</td>
                    <td class="border px-2 py-1 text-red-500">-65%</td>
                </tr>
                <tr>
                    <td class="border px-2 py-1">3</td>
                    <td class="border px-2 py-1">Amazon</td>
                    <td class="border px-2 py-1">10000</td>
                    <td class="border px-2 py-1">3000</td>
                    <td class="border px-2 py-1 text-red-500">-65%</td>
                </tr>
            </tbody>
        </table>
    </div>

</main>
<!--/Main-->

@endsection