@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-lg">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="mr-2"> Remember me
                </label>
                <a href="#" class="text-sm text-blue-600">Forgot password?</a>
            </div>

            <div>
                <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md">Login</button>
            </div>
        </form>

        <p class="mt-4 text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600">Sign up</a></p>
    </div>
</div>
@endsection
