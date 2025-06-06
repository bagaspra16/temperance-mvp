@extends('layouts.app')

@section('title', 'Edit Goal')

@section('content')
<div class="pt-24 pb-12">
    <div class="container mx-auto max-w-6xl px-4">
        <div class="mb-6" data-aos="fade-right" data-aos-duration="600">
            <a href="{{ route('goals.show', $goal) }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                <span>Back to Goal Details</span>
            </a>
        </div>

        <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden" 
             data-aos="fade-up" data-aos-duration="800">
            <div class="p-8 border-b border-dark-100/20">
                <h2 class="text-3xl font-bold text-white mb-2 bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">
                    Edit Goal
                </h2>
                <p class="text-gray-400">Update your goal settings and preferences</p>
            </div>

            <div class="p-8">
                <form action="{{ route('goals.update', $goal) }}" method="POST" id="goalForm">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-10">
                        <!-- Left Column -->
                        <div class="space-y-8">
                            <!-- Goal Title -->
                            <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                                <label for="title" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                    <i class="fas fa-bullseye text-accent/80"></i>
                                    <span>Goal Title</span>
                                </label>
                                <input type="text" id="title" name="title" 
                                       class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                                       value="{{ old('title', $goal->title) }}" required 
                                       placeholder="What do you want to achieve?">
                                @error('title')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Goal Description -->
                            <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                                <label for="description" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                    <i class="fas fa-align-left text-accent/80"></i>
                                    <span>Description</span>
                                </label>
                                <textarea id="description" name="description" rows="4" required
                                        class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner resize-none"
                                        placeholder="Describe your goal in detail">{{ old('description', $goal->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category Selection -->
                            <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                                <label for="category_id" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                    <i class="fas fa-folder text-accent/80"></i>
                                    <span>Category</span>
                                </label>
                                <select id="category_id" name="category_id" required
                                        class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white text-lg backdrop-blur-sm shadow-inner appearance-none custom-select">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                data-color="{{ $category->color_code }}"
                                                data-icon="{{ $category->icon }}"
                                                {{ old('category_id', $goal->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Goal Type -->
                            <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                                <label class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                    <i class="fas fa-clock text-accent/80"></i>
                                    <span>Goal Type</span>
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    @foreach(['daily', 'weekly', 'monthly', 'yearly'] as $type)
                                        <label class="goal-type-option">
                                            <input type="radio" name="type" value="{{ $type }}" 
                                                   class="hidden" {{ old('type', $goal->type) == $type ? 'checked' : '' }}>
                                            <div class="cursor-pointer bg-dark-400/95 border-2 border-dark-100/30 rounded-xl p-4 text-center transition-all hover:border-accent/50 hover:bg-dark-300/50">
                                                <i class="fas fa-{{ $type == 'daily' ? 'calendar-day' : ($type == 'weekly' ? 'calendar-week' : ($type == 'monthly' ? 'calendar-alt' : 'calendar')) }} mb-2 text-xl"></i>
                                                <p class="capitalize">{{ $type }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Target Value & Unit -->
                            <div class="grid grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="form-group">
                                    <label for="target_value" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                        <i class="fas fa-flag text-accent/80"></i>
                                        <span>Target Value</span>
                                    </label>
                                    <input type="number" id="target_value" name="target_value" 
                                           class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                                           value="{{ old('target_value', $goal->target_value) }}" required min="1"
                                           placeholder="e.g., 10">
                                    @error('target_value')
                                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="unit" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                        <i class="fas fa-ruler text-accent/80"></i>
                                        <span>Unit</span>
                                    </label>
                                    <input type="text" id="unit" name="unit" 
                                           class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                                           value="{{ old('unit', $goal->unit) }}" required
                                           placeholder="e.g., hours, books">
                                    @error('unit')
                                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date Range -->
                            <div class="grid grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="600">
                                <div class="form-group">
                                    <label for="start_date" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                        <i class="fas fa-calendar-plus text-accent/80"></i>
                                        <span>Start Date</span>
                                    </label>
                                    <input type="date" id="start_date" name="start_date" 
                                           class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white text-lg backdrop-blur-sm shadow-inner" 
                                           value="{{ old('start_date', $goal->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_date" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                                        <i class="fas fa-calendar-check text-accent/80"></i>
                                        <span>End Date</span>
                                    </label>
                                    <input type="date" id="end_date" name="end_date" 
                                           class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white text-lg backdrop-blur-sm shadow-inner" 
                                           value="{{ old('end_date', $goal->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between mt-12 pt-6 border-t border-dark-100/20" data-aos="fade-up" data-aos-delay="700">
                        <button type="button" 
                                onclick="confirmDelete()"
                                class="px-8 py-3 rounded-xl border-2 border-red-500/30 text-red-400 hover:text-red-300 hover:border-red-500/50 hover:bg-red-500/5 transition-all focus:ring-2 focus:ring-red-500/20 text-lg">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Delete Goal
                        </button>

                        <div class="flex space-x-4">
                            <a href="{{ route('goals.show', $goal) }}" 
                               class="px-6 py-3 rounded-xl border border-dark-100/30 text-gray-400 hover:text-white hover:border-dark-100/50 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                                <i class="fas fa-save mr-2"></i>
                                Update Goal
                            </button>
                        </div>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('goals.destroy', $goal) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Custom select styling */
    .custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    /* Goal type radio styling */
    .goal-type-option input:checked + div {
        @apply border-accent bg-accent/10 text-white;
        box-shadow: 0 0 20px rgba(236, 72, 153, 0.2);
    }

    /* Form focus states */
    .form-group:focus-within label {
        @apply text-accent;
    }

    /* Date input styling */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        opacity: 0.5;
        cursor: pointer;
    }

    input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 0.8;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true
    });

    // Category select enhancement
    const categorySelect = document.getElementById('category_id');
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const color = selectedOption.getAttribute('data-color');
        const icon = selectedOption.getAttribute('data-icon');
        
        if (color) {
            this.style.borderColor = color + '50';
            this.style.boxShadow = `0 0 0 1px ${color}30`;
        }
    });

    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });

    // Form submission animation
    const form = document.getElementById('goalForm');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
        submitBtn.disabled = true;
    });
});

function confirmDelete() {
    if (confirm('Are you sure you want to delete this goal? This action cannot be undone.')) {
        const deleteBtn = document.querySelector('button[onclick="confirmDelete()"]');
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
        deleteBtn.disabled = true;
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
@endsection 