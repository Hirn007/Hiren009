@extends('admin.layout.structure')
@section('content')

<!--Main-->
<main class="bg-white-medium flex-1 p-3 overflow-hidden">

    <!-- Page Title -->
    <h2 class="text-2xl font-bold mb-4">Category Management</h2>

    <!-- Action Buttons -->
    <div class="flex gap-4 mb-6">
        <a href="{{ url('add-category') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ➕ Add Category
        </a>
        <a href="{{ url('admin/category/deleted') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
            🗑 Deleted Category
        </a>
    </div>

    <!-- Category List Table -->
    <div class="bg-white shadow-md rounded p-5 mb-6">
        <h3 class="text-xl font-semibold mb-4">Category List</h3>

        <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Id</th>
                    <th class="px-4 py-2 text-left">Category Name</th>
                    <th class="px-4 py-2 text-left">Category Image</th>
                    <th class="px-4 py-2 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cate_arr as $key => $cat)
                <tr class="border-t hover:bg-gray-100">
                <td class="px-4 py-2">{{ $key + 1 }}</td>
                <td class="px-4 py-2">{{ $cat->name }}</td>
                <td class="px-4 py-2">
                    @if($cat->image)
                    <img src="{{ asset('upload/category/' . $cat->image) }}" alt="Category" class="w-16 h-16 object-cover rounded">
                    @else
                    <span class="text-gray-500 text-sm">No Image</span>
                    @endif
                </td>
                <td class="px-4 py-2 flex gap-3">
                <a href="{{ url('admin/category/edit/' . $cat->id) }}" 
                 class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>

                <a href="{{ url('admin/category/delete/' . $cat->id) }}" 
               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Delete</a>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>

        @if(count($cate_arr) == 0)
            <p class="text-center text-gray-600 py-3">No categories found.</p>
        @endif
    </div>

</main>

@endsection