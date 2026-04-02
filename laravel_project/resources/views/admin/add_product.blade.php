@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <div class="flex flex-col">

        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-6">Add Product</h2>

        <!-- Product Form Box -->
        <div class="bg-white shadow-md rounded p-6 w-full md:w-1/2">

           <form action="{{ url('add-products') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>

                    <select name="cate_id" class="w-full p-2 border border-gray-300 rounded" required>
                        <option value="">Select Category</option>
                        @foreach($cate_arr as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
                    <input 
                        type="text" 
                        name="product_name"
                        class="w-full p-2 border border-gray-300 rounded"
                        placeholder="Enter Product Name"
                        required
                    >
                </div>

                <!-- Brand -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Brand</label>
                    <input 
                        type="text" 
                        name="brand"
                        class="w-full p-2 border border-gray-300 rounded"
                        placeholder="Enter Brand Name"
                        required
                    >
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Price</label>
                    <input 
                        type="text" 
                        name="price"
                        class="w-full p-2 border border-gray-300 rounded"
                        placeholder="Enter Price"
                        required
                    >
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea 
                        name="description"
                        class="w-full p-2 border border-gray-300 rounded"
                        placeholder="Enter Product Description"
                        rows="4"
                        required
                    ></textarea>
                </div>

                <!-- Image -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Product Image</label>
                    <input 
                        type="file" 
                        name="image"
                        class="w-full p-2 border border-gray-300 rounded"
                        required
                    >
                </div>

                <!-- Submit -->
                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Submit
                </button>

            </form>

        </div>

    </div>

</main>

@endsection