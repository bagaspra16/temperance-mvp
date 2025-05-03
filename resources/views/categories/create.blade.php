@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="btn-link">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
        </a>
    </div>
    
    <div class="card" data-aos="fade-up" data-aos-duration="800">
        <div class="card-header">
            <h2 class="card-title">Create New Category</h2>
            <p class="text-gray-400 mt-2">Organize your habits and goals with categories</p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name') }}" required placeholder="Enter category name">
                    <p class="form-helper">Choose a clear, concise name for your category</p>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="color_code" class="form-label">Color</label>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="color" id="color_code" name="color_code" 
                                   class="h-12 w-12 rounded-lg cursor-pointer border-2 border-dark-100/50 overflow-hidden" 
                                   value="{{ old('color_code', '#e5c5c1') }}">
                            <div class="absolute inset-0 rounded-lg pointer-events-none ring-2 ring-accent/10 border border-dark-100/50"></div>
                        </div>
                        <div>
                            <span class="text-white text-sm" id="color-value">#e5c5c1</span>
                            <p class="form-helper">Select a color to represent this category</p>
                        </div>
                    </div>
                    @error('color_code')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="icon" class="form-label">Icon</label>
                    <p class="form-helper mb-4">Choose an icon that represents this category</p>
                    
                    <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-12 gap-3 mb-4">
                        @php
                            $icons = [
                                'house', 'briefcase', 'book', 'heart', 'graph-up', 'music-note', 'camera', 'bicycle', 
                                'brush', 'cup-hot', 'bank', 'alarm', 'journal', 'trophy', 'basket', 'cpu',
                                'controller', 'globe', 'lightbulb', 'palette', 'pencil', 'people', 'stars', 'wrench'
                            ];
                        @endphp
                        
                        @foreach($icons as $icon)
                            <div class="icon-option group {{ old('icon') == $icon ? 'selected' : '' }}"
                                data-icon="{{ $icon }}"
                                onclick="selectIcon('{{ $icon }}')">
                                <div class="icon-inner">
                                    <i class="fas fa-{{ $icon }}"></i>
                                </div>
                                <div class="icon-tooltip">{{ $icon }}</div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="icon" name="icon" value="{{ old('icon', 'tag') }}">
                    @error('icon')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end mt-12 space-x-4">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-option {
        @apply flex flex-col items-center justify-center h-12 w-12 rounded-xl cursor-pointer border border-dark-100/50 transition-all relative;
        background: rgba(30, 34, 39, 0.7);
    }
    
    .icon-option:hover {
        @apply border-accent/50 bg-accent/5 transform scale-110;
    }
    
    .icon-option.selected {
        @apply border-accent bg-accent/10 text-white;
        box-shadow: 0 0 10px rgba(236, 72, 153, 0.3);
        transform: scale(1.1);
    }
    
    .icon-inner {
        @apply flex items-center justify-center h-full w-full;
    }
    
    .icon-tooltip {
        @apply absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-dark-300 text-xs px-2 py-1 rounded opacity-0 transition-opacity pointer-events-none whitespace-nowrap;
        z-index: 10;
    }
    
    .icon-option:hover .icon-tooltip {
        @apply opacity-100;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init();
        
        // Update color value display when color picker changes
        const colorPicker = document.getElementById('color_code');
        const colorValue = document.getElementById('color-value');
        
        colorPicker.addEventListener('input', function() {
            colorValue.textContent = this.value;
        });
        
        // Set initial color value
        colorValue.textContent = colorPicker.value;
        
        // Set initial selected icon on page load
        const initialIcon = document.getElementById('icon').value;
        if (initialIcon) {
            selectIcon(initialIcon);
        }
    });

    function selectIcon(icon) {
        // Clear previous selection
        document.querySelectorAll('.icon-option').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Mark selected icon
        document.querySelector(`.icon-option[data-icon="${icon}"]`).classList.add('selected');
        
        // Set hidden input value
        document.getElementById('icon').value = icon;
    }
</script>
@endpush
@endsection 