@extends('admin.layout.structure')
@section('content')

<!--Main-->
<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <div class="flex flex-col">

        <!-- Page Title -->
        <h2 class="text-2xl font-bold mb-6">Add Category</h2>

        <!-- Category Form Box -->
        <div class="bg-white shadow-md rounded p-6 w-full md:w-1/2">

            <form action="{{ url('/add-category') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Category Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
                    <input 
                        type="text" 
                        name="category_name" 
                        class="w-full p-2 border border-gray-300 rounded" 
                        placeholder="Enter Category Name"
                        required
                    >
                </div>

                <!-- Category Image -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Category Image</label>
                    <input 
                        type="file" 
                        name="category_image" 
                        class="w-full p-2 border border-gray-300 rounded"
                        required
                    >
                </div>

                <!-- Submit Button -->
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