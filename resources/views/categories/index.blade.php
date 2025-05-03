@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg mr-1"></i> New Category
        </a>
    </div>
    
    @if ($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="card hover:bg-gray-700 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $category->color_code }}">
                                <i class="bi bi-{{ $category->icon }} text-primary"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold">{{ $category->name }}</h3>
                                <div class="text-xs text-gray-400">
                                    {{ $category->goals->count() }} goals,
                                    {{ $category->dailyTasks->count() }} tasks
                                </div>
                            </div>
                        </div>
                        
                        <div class="dropdown relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-400 hover:text-white">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded shadow-lg py-1 z-10">
                                <a href="{{ route('categories.show', $category) }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                                    <i class="bi bi-eye mr-2"></i> View
                                </a>
                                <a href="{{ route('categories.edit', $category) }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                                    <i class="bi bi-pencil mr-2"></i> Edit
                                </a>
                                <button @click="$refs.deleteForm{{ $category->id }}.submit()" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700">
                                    <i class="bi bi-trash mr-2"></i> Delete
                                </button>
                                
                                <form x-ref="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <a href="{{ route('categories.show', $category) }}" class="text-secondary hover:text-opacity-80 text-sm">
                            <i class="bi bi-arrow-right mr-1"></i> View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card py-12">
            <div class="text-center text-gray-400">
                <i class="bi bi-tags text-4xl mb-3"></i>
                <h3 class="text-xl mb-2">No Categories Yet</h3>
                <p class="mb-6">Categories help you organize your goals and habits</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Your First Category</a>
            </div>
        </div>
    @endif
</div>
@endsection 