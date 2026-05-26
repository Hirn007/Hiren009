{{-- Categories Index - Manage all categories --}}
@extends('layouts.layout')

@section('title', 'Manage Categories')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- Header Section --}}
    <div class="mb-8 slide-up">
        <div class="flex justify-between items-center gap-4">
            <div>
                <h1 class="font-display text-3xl font-bold gradient-text">Manage Categories</h1>
                <p class="text-gray-400 mt-2">Create and organize product categories</p>
            </div>
            @auth
                <a href="{{ route('categories.create') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow flex items-center gap-2">
                    ➕ Add Category
                </a>
            @endauth
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl text-green-400 slide-up">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 slide-up">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- Categories Table --}}
    @if($categories->count() > 0)
        <div class="glass rounded-2xl overflow-hidden slide-up">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="text-left px-6 py-4 text-gray-400 font-medium text-sm">Category Name</th>
                            <th class="text-left px-6 py-4 text-gray-400 font-medium text-sm">Slug</th>
                            <th class="text-center px-6 py-4 text-gray-400 font-medium text-sm">Products</th>
                            <th class="text-right px-6 py-4 text-gray-400 font-medium text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($categories as $category)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-brand-400 to-brand-600 rounded-lg flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($category->name, 0, 1)) }}
                                        </div>
                                        <span class="text-white font-medium">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-gray-400 text-sm bg-white/5 px-2 py-1 rounded">{{ $category->slug }}</code>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1 bg-brand-500/10 text-brand-400 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2 rounded-lg text-sm font-medium transition-all">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-20 glass rounded-2xl slide-up">
            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h3 class="font-display text-xl text-gray-400 mb-2">No categories yet</h3>
            <p class="text-gray-600 mb-6">Create your first category to get started organizing products</p>
            @auth
                <a href="{{ route('categories.create') }}" class="inline-block bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-medium transition-all btn-glow">
                    ➕ Create First Category
                </a>
            @endauth
        </div>
    @endif

    {{-- Back Link --}}
    <div class="mt-8">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-white transition-colors text-sm">← Back to Store</a>
    </div>

</div>
@endsection
