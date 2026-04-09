@extends('admin.layout.structure')
@section('content')

<main class="bg-white-medium flex-1 p-6 overflow-hidden">

    <!-- Page Title -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">User Management</h2>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4 mb-6">
        <a href="{{ url('admin/users') }}"
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
            👥 All Users
        </a>

        <a href="{{ url('admin/users/blocked') }}"
           class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">
            🚫 Blocked Users
        </a>
    </div>

    <!-- User Table -->
    <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-200">

        <h3 class="text-xl font-semibold mb-4 text-gray-700">Users List</h3>

        <table class="min-w-full bg-white border border-gray-300 rounded overflow-hidden">

            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">id</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Name</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Email</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $key => $user)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3 font-medium text-gray-700">{{ $key + 1 }}</td>

                    <td class="px-4 py-3 font-semibold text-gray-800">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-3">

                        @if($user->status == 1)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                Active
                            </span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                Blocked
                            </span>
                        @endif

                    </td>

                    <td class="px-4 py-3">
                        <div class="flex gap-3">

                            <!-- View Button -->
                            <a href="{{ url('admin/user/view/'.$user->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                                View
                            </a>

                            <!-- Block / Unblock Button -->
                            @if($user->status == 1)
                                <a href="{{ url('admin/user/block/'.$user->id) }}"
                                   class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                                    Block
                                </a>
                            @else
                                <a href="{{ url('admin/user/unblock/'.$user->id) }}"
                                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition">
                                    Unblock
                                </a>
                            @endif

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</main>

@endsection