@extends('layouts.app')

@section('title', 'Create Daily Task')

@section('content')
<div class="container mx-auto max-w-4xl px-4">
    <div class="mb-6" data-aos="fade-right" data-aos-duration="600">
        <a href="{{ route('categories.show', $category->id) }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
            <span>Back to Category</span>
        </a>
    </div>
    
    <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm" 
         data-aos="fade-up" data-aos-duration="800">
        <div class="p-8 border-b border-dark-100/20">
            <h2 class="text-3xl font-bold text-white mb-2 bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">
                Create New Daily Task
            </h2>
            <p class="text-gray-400">Add a new daily task to your category</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('dailyTasks.store') }}" method="POST" id="taskForm">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                
                <div class="space-y-8">
                    <!-- Task Title -->
                    <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                        <label for="title" class="form-label inline-flex items-center space-x-2 text-lg">
                            <i class="fas fa-tasks text-accent/80"></i>
                            <span>Task Title</span>
                        </label>
                        <input type="text" id="title" name="title" 
                               class="mt-3 w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-black placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                               value="{{ old('title') }}" required 
                               placeholder="Enter task title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Task Description -->
                    <div class="form-group" data-aos="fade-up" data-aos-delay="200">
                        <label for="description" class="form-label inline-flex items-center space-x-2 text-lg">
                            <i class="fas fa-align-left text-accent/80"></i>
                            <span>Description</span>
                            <span class="text-gray-400 text-sm">(Optional)</span>
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="mt-3 w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-black placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner"
                                  placeholder="Enter task description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end mt-12 space-x-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('categories.show', $category->id) }}" 
                       class="px-6 py-3 rounded-xl border border-dark-100/30 text-gray-400 hover:text-white hover:border-dark-100/50 transition-all">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                        <i class="fas fa-save mr-2"></i>
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
        
        // Form submission animation
        const form = document.getElementById('taskForm');
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
            submitBtn.disabled = true;
        });
    });
</script>
@endpush
@endsection 