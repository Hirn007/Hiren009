@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-lg">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Create an account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md">Create account</button>
            </div>
        </form>

        <p class="mt-4 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-blue-600">Login</a></p>
    </div>
</div>
@endsection
