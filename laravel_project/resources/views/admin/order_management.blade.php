@extends('admin.layout.structure')
@section('content')

<!--Main-->
<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <!-- Page Title -->
    <h2 class="text-2xl font-bold mb-4">Order Management</h2>

    <!-- Action Buttons -->
    <div class="flex gap-4 mb-6">

        <a href="{{ url('admin/orders') }}" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            📋 View & Manage All Orders (Update Status)
        </a>

    </div>


    <!-- Rest of your original dashboard -->
    <div class="flex flex-col">

        <!-- Stats Row -->
        <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
            <div class="shadow-lg bg-red-vibrant border-l-8 border-red-vibrant-dark hover:bg-red-vibrant-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">{{ $totalOrders }}</span>
                    <span class="text-lg">Total Orders</span>
                </div>
            </div>

            <div class="shadow bg-info border-l-8 border-info-dark hover:bg-info-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">${{ number_format($totalRevenue, 2) }}</span>
                    <span class="text-lg">Total Revenue</span>
                </div>
            </div>

            <div class="shadow bg-warning border-l-8 border-warning-dark hover:bg-warning-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">{{ $pendingOrders }}</span>
                    <span class="text-lg">Pending Orders</span>
                </div>
            </div>

            <div class="shadow bg-success border-l-8 border-success-dark hover:bg-success-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">{{ $deliveredOrders }}</span>
                    <span class="text-lg">Delivered Orders</span>
                </div>
            </div>
        </div>


        <!-- Order Status Progress -->
        <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2 mt-4">
            <div class="rounded overflow-hidden shadow bg-white mx-2 w-full pt-2">
                <div class="px-6 py-2 border-b border-light-grey">
                    <div class="font-bold text-xl">Order Status Progress</div>
                </div>

                <div class="p-4 space-y-4">

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-yellow-500 text-xs leading-none py-1 text-center text-white" style="width: {{ $pendingPercent }}%">
                            Pending - {{ $pendingPercent }}%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-blue-500 text-xs leading-none py-1 text-center text-white" style="width: {{ $processingPercent }}%">
                            Processing - {{ $processingPercent }}%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-purple-500 text-xs leading-none py-1 text-center text-white" style="width: {{ $shippedPercent }}%">
                            Shipped - {{ $shippedPercent }}%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-green-600 text-xs leading-none py-1 text-center text-white" style="width: {{ $deliveredPercent }}%">
                            Delivered - {{ $deliveredPercent }}%
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</main>

@endsection