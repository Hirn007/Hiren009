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
            📋 Order List
        </a>

        <a href="{{ url('admin/order/details') }}" 
            class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded shadow">
            📑 Order Details
        </a>

        <a href="{{ url('admin/order/status') }}" 
            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded shadow">
            🔄 Change Order Status
        </a>

        <a href="{{ url('admin/order/status/manage') }}" 
            class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded shadow">
            🚚 Manage Status (Pending / Processing / Shipped / Delivered)
        </a>

    </div>


    <!-- Rest of your original dashboard -->
    <div class="flex flex-col">

        <!-- Stats Row -->
        <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
            <div class="shadow-lg bg-red-vibrant border-l-8 border-red-vibrant-dark hover:bg-red-vibrant-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">1250</span>
                    <span class="text-lg">Total Orders</span>
                </div>
            </div>

            <div class="shadow bg-info border-l-8 border-info-dark hover:bg-info-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">$24,999</span>
                    <span class="text-lg">Total Revenue</span>
                </div>
            </div>

            <div class="shadow bg-warning border-l-8 border-warning-dark hover:bg-warning-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">320</span>
                    <span class="text-lg">Pending Orders</span>
                </div>
            </div>

            <div class="shadow bg-success border-l-8 border-success-dark hover:bg-success-dark mb-2 p-2 md:w-1/4 mx-2">
                <div class="p-4 flex flex-col text-white">
                    <span class="text-2xl">780</span>
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
                        <div class="bg-yellow-500 text-xs leading-none py-1 text-center text-white" style="width: 30%">
                            Pending - 30%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-blue-500 text-xs leading-none py-1 text-center text-white" style="width: 25%">
                            Processing - 25%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-purple-500 text-xs leading-none py-1 text-center text-white" style="width: 20%">
                            Shipped - 20%
                        </div>
                    </div>

                    <div class="shadow w-full bg-grey-light">
                        <div class="bg-green-600 text-xs leading-none py-1 text-center text-white" style="width: 25%">
                            Delivered - 25%
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</main>

@endsection