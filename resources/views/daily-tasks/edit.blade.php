@extends('layouts.app')

@section('title', 'Edit Daily Task')

@section('content')
<div class="container mx-auto max-w-4xl px-4">
    <div class="mb-6" data-aos="fade-right" data-aos-duration="600">
        <a href="{{ route('categories.show', $dailyTask->category_id) }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
            <span>Back to Category</span>
        </a>
    </div>
    
    <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm" 
         data-aos="fade-up" data-aos-duration="800">
        <div class="p-8 border-b border-dark-100/20">
            <h2 class="text-3xl font-bold text-white mb-2 bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">
                Edit Daily Task
            </h2>
            <p class="text-gray-400">Update your daily task details</p>
        </div>
        
        <div class="p-8">
            <form action="{{ route('dailyTasks.update', $dailyTask) }}" method="POST" id="taskForm">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Task Title -->
                    <div class="form-group" data-aos="fade-up" data-aos-delay="100">
                        <label for="title" class="form-label inline-flex items-center space-x-2 text-lg">
                            <i class="fas fa-tasks text-accent/80"></i>
                            <span>Task Title</span>
                        </label>
                        <input type="text" id="title" name="title" 
                               class="mt-3 w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-black placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner" 
                               value="{{ old('title', $dailyTask->title) }}" required 
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
                                  placeholder="Enter task description">{{ old('description', $dailyTask->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-between mt-12" data-aos="fade-up" data-aos-delay="300">
                    <button type="button" 
                            onclick="confirmDelete()"
                            class="px-8 py-3 rounded-xl border-2 border-red-500/30 text-red-400 hover:text-red-300 hover:border-red-500/50 hover:bg-red-500/5 transition-all focus:ring-2 focus:ring-red-500/20 text-lg">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete Task
                    </button>

                    <div class="flex space-x-4">
                        <a href="{{ route('categories.show', $dailyTask->category_id) }}" 
                           class="px-6 py-3 rounded-xl border border-dark-100/30 text-gray-400 hover:text-white hover:border-dark-100/50 transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                            <i class="fas fa-save mr-2"></i>
                            Update Task
                        </button>
                    </div>
                </div>
            </form>
            
            <form id="delete-form" action="{{ route('dailyTasks.destroy', $dailyTask) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
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
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            submitBtn.disabled = true;
        });
    });
    
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            const deleteBtn = document.querySelector('button[onclick="confirmDelete()"]');
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
            deleteBtn.disabled = true;
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endpush
@endsection 