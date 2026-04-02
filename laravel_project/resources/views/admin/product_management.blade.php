@extends('admin.layout.structure')
@section('content')

<!--Main-->
<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <!-- Page Title -->
    <h2 class="text-2xl font-bold mb-4">Product Management</h2>

    <!-- Action Buttons -->
    <div class="flex gap-4 mb-6">
       <a href="{{ url('add-product') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ➕ Add Product
        </a>
    </div>

    <!-- Product List Table -->
    <div class="bg-white shadow-md rounded p-5 mb-6 overflow-x-auto">
        <h3 class="text-xl font-semibold mb-4">Product List</h3>

        <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Id</th>
                    <th class="px-4 py-2 text-left">Product Image</th>
                    <th class="px-4 py-2 text-left">Product Name</th>
                    <th class="px-4 py-2 text-left">Brand</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Description</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                   @if(isset($prod_arr) && count($prod_arr) > 0)
                   @foreach($prod_arr as $key => $prod)
                   <tr class="border-t hover:bg-gray-100">
                   <td class="px-4 py-2">{{ $key + 1 }}</td>
            
                   <td class="px-4 py-2">
                   @if($prod->image)
                    <img src="{{ asset('upload/product/' . $prod->image) }}" alt="Product Image" class="w-16 h-16 object-cover rounded">
                   @else
                    <span class="text-gray-500 text-sm">No Image</span>
                   @endif
                   </td>
            
                   <td class="px-4 py-2">{{ $prod->name }}</td>
                   <td class="px-4 py-2">{{ $prod->brand }}</td>
                   <td class="px-4 py-2">{{ $prod->price }}</td>
                   <td class="px-4 py-2 limit-text">{{ $prod->description }}</td>
                   <td class="px-4 py-2 flex gap-3">
                   <a href="{{ url('edit-product/'.$prod->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                   <a href="{{ url('delete-product/'.$prod->id) }}" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Delete</a>
                   </td>
                   </tr>
                   @endforeach
                   @else
                   <tr>
                   <td colspan="7" class="text-center text-gray-600 py-4">No products found.</td>
                   </tr>
                   @endif
            </tbody>
        </table>

    </div>

</main>

@endsection