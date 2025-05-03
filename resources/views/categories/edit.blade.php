@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Categories
        </a>
    </div>
    
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">Edit Category</h2>
        
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name" class="block mb-2">Category Name</label>
                <input type="text" id="name" name="name" class="input w-full" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="color_code" class="block mb-2">Color</label>
                <div class="flex items-center space-x-2">
                    <input type="color" id="color_code" name="color_code" class="h-10 w-10 rounded" value="{{ old('color_code', $category->color_code) }}">
                    <span class="text-sm text-gray-400">Select a color to represent this category</span>
                </div>
                @error('color_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="icon" class="block mb-2">Icon</label>
                <div class="grid grid-cols-8 gap-2 mb-2">
                    @php
                        $icons = [
                            'house', 'briefcase', 'book', 'heart', 'graph-up', 'music-note', 'camera', 'bicycle', 
                            'brush', 'cup-hot', 'bank', 'alarm', 'journal', 'trophy', 'basket', 'cpu',
                            'controller', 'globe', 'lightbulb', 'palette', 'pencil', 'people', 'stars', 'wrench'
                        ];
                    @endphp
                    
                    @foreach($icons as $icon)
                        <div 
                            class="h-10 w-10 rounded flex items-center justify-center cursor-pointer border border-gray-700 hover:border-secondary icon-option"
                            data-icon="{{ $icon }}"
                            onclick="selectIcon('{{ $icon }}')"
                        >
                            <i class="bi bi-{{ $icon }}"></i>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="icon" name="icon" value="{{ old('icon', $category->icon) }}">
                @error('icon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between">
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                    Delete Category
                </button>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
        
        <form id="delete-form" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('scripts')
<script>
    function selectIcon(icon) {
        // Clear previous selection
        document.querySelectorAll('.icon-option').forEach(el => {
            el.classList.remove('border-secondary');
            el.classList.add('border-gray-700');
        });
        
        // Mark selected icon
        document.querySelector(`.icon-option[data-icon="${icon}"]`).classList.remove('border-gray-700');
        document.querySelector(`.icon-option[data-icon="${icon}"]`).classList.add('border-secondary');
        
        // Set hidden input value
        document.getElementById('icon').value = icon;
    }
    
    // Set initial selected icon on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialIcon = document.getElementById('icon').value;
        if (initialIcon) {
            selectIcon(initialIcon);
        }
    });
</script>
@endpush
@endsection 