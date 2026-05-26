{{-- Create Category Form --}}
@extends('layouts.layout')

@section('title', 'Create Category')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6 slide-up">
        <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-white transition-colors text-sm inline-block">← Back to Categories</a>
        <h1 class="font-display text-3xl font-bold gradient-text">Create Category</h1>
        <p class="text-gray-400 mt-1">Add a new category to organize your products</p>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="glass rounded-2xl p-6 slide-up">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Category Name <span class="text-accent-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., T-Shirts"
                   class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-red-400">⚠️ {{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all">Create</button>
            <a href="{{ route('categories.index') }}" class="bg-white/5 hover:bg-white/10 text-gray-300 px-4 py-3 rounded-xl">Cancel</a>
        </div>
    </form>
</div>
@endsection
