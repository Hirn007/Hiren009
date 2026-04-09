@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-6 overflow-hidden">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">User Profile</h2>
        <a href="{{ url('admin/users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow transition">
            🔙 Back to Users
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 mt-4 max-w-2xl mx-auto">
        <div class="flex items-center justify-center mb-6">
            <div class="bg-blue-100 text-blue-600 w-24 h-24 rounded-full flex items-center justify-center text-4xl font-bold">
                {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}
            </div>
        </div>

        <div class="space-y-4 text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold w-1/3">User ID:</span> 
                <span class="w-2/3">{{ $user->id }}</span>
            </div>
            
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold w-1/3">Name:</span> 
                <span class="w-2/3">{{ $user->name ?: 'Not Provided' }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold w-1/3">Email:</span> 
                <span class="w-2/3">{{ $user->email }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold w-1/3">Status:</span> 
                <span class="w-2/3">
                    @if($user->status == 1)
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">Active</span>
                    @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">Blocked</span>
                    @endif
                </span>
            </div>
            
            <div class="flex justify-between border-b pb-2">
                <span class="font-semibold w-1/3">Joined:</span> 
                <span class="w-2/3">{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}</span>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-4">
            @if($user->status == 1)
                <a href="{{ url('admin/user/block/'.$user->id) }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded shadow transition">
                    Block User
                </a>
            @else
                <a href="{{ url('admin/user/unblock/'.$user->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow transition">
                    Unblock User
                </a>
            @endif
        </div>
    </div>

</main>

@endsection
