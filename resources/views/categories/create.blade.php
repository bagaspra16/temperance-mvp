@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto max-w-6xl px-4">
    <div class="mb-6" data-aos="fade-right" data-aos-duration="600">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
            <span>Back to Categories</span>
        </a>
    </div>
    
    <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm" 
         data-aos="fade-up" data-aos-duration="800">
        <div class="p-8 border-b border-dark-100/20">
            <h2 class="text-3xl font-bold text-white mb-2 bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">
                Create New Category
            </h2>
            <p class="text-gray-400">Organize your habits and goals with custom categories</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-10">
                    <div class="space-y-10">
                        <!-- Category Name Input -->
                        <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                            <label for="name" class="form-label inline-flex items-center space-x-2 text-lg">
                                <i class="fas fa-tag text-accent/80"></i>
                                <span>Category Name</span>
                            </label>
                            <input type="text" id="name" name="name" 
                                   class="mt-3 w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-black placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                                   value="{{ old('name') }}" required 
                                   placeholder="Enter a descriptive name">
                            <p class="text-gray-400 text-sm mt-2">Choose a clear, concise name for your category</p>
                            @error('name')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color Picker -->
                        <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                            <label for="color_code" class="form-label inline-flex items-center space-x-2 text-lg">
                                <i class="fas fa-palette text-accent/80"></i>
                                <span>Category Color</span>
                            </label>
                            <div class="mt-4 flex items-center space-x-8">
                                <div class="relative group">
                                    <input type="color" id="color_code" name="color_code" 
                                           class="h-28 w-28 rounded-2xl cursor-pointer border-2 border-dark-100/50 overflow-hidden transform transition-transform hover:scale-105" 
                                           value="{{ old('color_code', '#e5c5c1') }}">
                                    <div class="absolute inset-0 rounded-2xl pointer-events-none ring-2 ring-accent/20 group-hover:ring-accent/40 transition-all"></div>
                                </div>
                                <div class="flex flex-col p-4 bg-dark-400/95 rounded-xl border border-dark-100/30 backdrop-blur-sm shadow-inner">
                                    <span class="text-white text-xl font-mono tracking-wider" id="color-value">#e5c5c1</span>
                                    <div class="flex items-center mt-3 space-x-3">
                                        <span class="w-10 h-10 rounded-full shadow-lg" id="color-preview" style="background-color: #e5c5c1"></span>
                                        <p class="text-gray-400">Preview</p>
                                    </div>
                                </div>
                            </div>
                            @error('color_code')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Icon Selector -->
                    <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex justify-between items-center mb-4">
                            <label class="form-label inline-flex items-center space-x-2 text-lg">
                                <i class="fas fa-icons text-accent/80"></i>
                                <span>Category Icon</span>
                            </label>
                        </div>
                        
                        <div class="bg-dark-300/50 rounded-xl border border-dark-100/10 p-6">
                            <div class="grid grid-cols-6 sm:grid-cols-8 gap-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                @php
                                    $iconCategories = [
                                        'Essential' => [
                                            'home' => 'Home',
                                            'briefcase' => 'Work',
                                            'book' => 'Book',
                                            'heart' => 'Health',
                                            'chart-line' => 'Progress',
                                            'music' => 'Music',
                                            'camera' => 'Photography',
                                            'bicycle' => 'Exercise',
                                            'palette' => 'Art',
                                            'coffee' => 'Lifestyle',
                                            'university' => 'Education',
                                            'clock' => 'Time',
                                            'book-open' => 'Reading',
                                            'trophy' => 'Achievement',
                                            'shopping-basket' => 'Shopping',
                                            'microchip' => 'Technology'
                                        ],
                                        'Activities' => [
                                            'dumbbell' => 'Fitness',
                                            'running' => 'Running',
                                            'hiking' => 'Hiking',
                                            'swimmer' => 'Swimming',
                                            'basketball-ball' => 'Basketball',
                                            'football-ball' => 'Football',
                                            'gamepad' => 'Gaming',
                                            'paint-brush' => 'Painting'
                                        ],
                                        'Technology' => [
                                            'laptop-code' => 'Programming',
                                            'code' => 'Coding',
                                            'terminal' => 'Development',
                                            'microchip' => 'Hardware',
                                            'globe' => 'Internet',
                                            'server' => 'Server'
                                        ],
                                        'Finance' => [
                                            'money-bill' => 'Money',
                                            'piggy-bank' => 'Savings',
                                            'wallet' => 'Wallet',
                                            'credit-card' => 'Payment',
                                            'chart-bar' => 'Statistics',
                                            'chart-pie' => 'Analytics'
                                        ],
                                        'Food & Drink' => [
                                            'utensils' => 'Dining',
                                            'hamburger' => 'Fast Food',
                                            'wine-glass' => 'Drinks',
                                            'pizza-slice' => 'Pizza',
                                            'carrot' => 'Vegetables',
                                            'apple-alt' => 'Fruits'
                                        ],
                                        'Travel' => [
                                            'plane' => 'Flight',
                                            'car' => 'Driving',
                                            'train' => 'Train',
                                            'ship' => 'Ship',
                                            'motorcycle' => 'Motorcycle',
                                            'map-marker-alt' => 'Location'
                                        ],
                                        'Nature' => [
                                            'sun' => 'Sun',
                                            'moon' => 'Moon',
                                            'cloud' => 'Weather',
                                            'snowflake' => 'Winter',
                                            'umbrella' => 'Rain',
                                            'leaf' => 'Nature'
                                        ],
                                        'Others' => [
                                            'star' => 'Favorite',
                                            'heart' => 'Love',
                                            'lightbulb' => 'Ideas',
                                            'users' => 'Social',
                                            'tools' => 'Tools',
                                            'cog' => 'Settings'
                                        ]
                                    ];
                                @endphp
                                
                                @foreach($iconCategories as $category => $icons)
                                    <div class="col-span-full">
                                        <h3 class="category-header">{{ $category }}</h3>
                                        <div class="icon-grid">
                                            @foreach($icons as $icon => $label)
                                                <div class="icon-option group {{ old('icon') == $icon ? 'selected' : '' }}"
                                                    data-icon="{{ $icon }}"
                                                    data-category="{{ $category }}"
                                                    data-label="{{ $label }}"
                                                    onclick="selectIcon('{{ $icon }}')">
                                                    <div class="icon-inner">
                                                        <i class="fas fa-{{ $icon }}"></i>
                                                    </div>
                                                    <div class="text-sm text-gray-400 mt-2">{{ $label }}</div>
                                                    <div class="icon-tooltip">
                                                        <div class="font-medium text-base">{{ $label }}</div>
                                                        <div class="text-xs text-gray-400 mt-1">{{ $category }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" id="icon" name="icon" value="{{ old('icon', 'tag') }}">
                        @error('icon')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end mt-12 space-x-4" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('categories.index') }}" 
                       class="px-6 py-3 rounded-xl border border-dark-100/30 text-gray-400 hover:text-white hover:border-dark-100/50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                        <i class="fas fa-save mr-2"></i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .icon-option {
        @apply flex flex-col items-center justify-center h-32 w-40 rounded-xl cursor-pointer border-2 border-dark-100/30 transition-all relative;
        background: rgba(24, 27, 32, 0.95);
    }
    
    .icon-option:hover {
        @apply border-accent/50 bg-accent/5 transform scale-105;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
    
    .icon-option.selected {
        @apply border-accent bg-accent/10 text-white;
        box-shadow: 0 0 30px rgba(236, 72, 153, 0.3);
        transform: scale(1.08);
    }
    
    .icon-inner {
        @apply flex items-center justify-center h-full w-full text-4xl;
    }
    
    .icon-tooltip {
        @apply absolute -bottom-24 left-1/2 transform -translate-x-1/2 bg-dark-400/95 backdrop-blur-sm text-center px-4 py-2.5 rounded-xl opacity-0 transition-all pointer-events-none whitespace-nowrap border border-dark-100/20 shadow-lg;
        z-index: 10;
        min-width: 140px;
    }
    
    .icon-option:hover .icon-tooltip {
        @apply opacity-100 -bottom-28;
    }

    .icon-option.hidden-icon {
        @apply hidden;
    }

    /* Form focus states */
    .form-group:focus-within label {
        @apply text-accent;
    }

    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        @apply bg-dark-100/20 rounded-full;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        @apply bg-accent/20 rounded-full hover:bg-accent/30 transition-colors;
    }

    /* Category headers */
    .category-header {
        @apply text-sm font-medium text-accent/80 mb-4 pl-2 border-l-2 border-accent/30 bg-dark-400/50 py-2 rounded-r-lg;
    }

    /* Icon grid layout */
    .icon-grid {
        @apply grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8 mb-8;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS with custom settings
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
        
        const colorPicker = document.getElementById('color_code');
        const colorValue = document.getElementById('color-value');
        const colorPreview = document.getElementById('color-preview');
        
        function updateColorDisplay(color) {
            colorValue.textContent = color;
            colorPreview.style.backgroundColor = color;
        }
        
        colorPicker.addEventListener('input', function(e) {
            updateColorDisplay(e.target.value);
        });
        
        // Set initial color value
        updateColorDisplay(colorPicker.value);
        
        // Set initial selected icon
        const initialIcon = document.getElementById('icon').value;
        if (initialIcon) {
            selectIcon(initialIcon);
        }

        // Icon search functionality
        const iconSearch = document.getElementById('icon-search');
        const iconOptions = document.querySelectorAll('.icon-option');

        iconSearch.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            iconOptions.forEach(option => {
                const iconName = option.getAttribute('data-icon').toLowerCase();
                const iconLabel = option.getAttribute('data-label').toLowerCase();
                const iconCategory = option.getAttribute('data-category').toLowerCase();
                
                if (iconName.includes(searchTerm) || 
                    iconLabel.includes(searchTerm) || 
                    iconCategory.includes(searchTerm)) {
                    option.classList.remove('hidden-icon');
                    option.closest('.col-span-full').style.display = 'block';
                } else {
                    option.classList.add('hidden-icon');
                }
            });

            // Hide empty categories
            document.querySelectorAll('.col-span-full').forEach(category => {
                const visibleIcons = category.querySelectorAll('.icon-option:not(.hidden-icon)');
                if (visibleIcons.length === 0) {
                    category.style.display = 'none';
                }
            });
        });

        // Form submission animation
        const form = document.getElementById('categoryForm');
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
            submitBtn.disabled = true;
        });
    });

    function selectIcon(icon) {
        const options = document.querySelectorAll('.icon-option');
        options.forEach(el => {
            el.classList.remove('selected');
            el.style.transitionDelay = '0s';
        });
        
        const selected = document.querySelector(`.icon-option[data-icon="${icon}"]`);
        selected.classList.add('selected');
        document.getElementById('icon').value = icon;
        
        // Add ripple effect
        const ripple = document.createElement('div');
        ripple.className = 'absolute inset-0 bg-accent/20 rounded-xl animate-ping';
        selected.appendChild(ripple);
        setTimeout(() => ripple.remove(), 500);

        // Scroll selected icon into view if needed
        selected.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
</script>
@endpush
@endsection 