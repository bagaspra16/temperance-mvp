@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto max-w-7xl px-4">
    <div class="mb-8" data-aos="fade-right" data-aos-duration="600">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
            <span>Back to Categories</span>
        </a>
    </div>
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6" data-aos="fade-up" data-aos-duration="800">
        <div class="flex items-center">
            <div class="w-20 h-20 rounded-2xl flex items-center justify-center mr-6 shadow-lg transform transition-all hover:scale-105 hover:rotate-3" 
                 style="background-color: {{ $category->color_code }};">
                <i class="fas fa-{{ $category->icon }} text-4xl text-white"></i>
            </div>
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">
                    {{ $category->name }}
                </h1>
                <p class="text-gray-400 mt-2 text-lg">Category Overview</p>
            </div>
        </div>
        
        <div class="flex space-x-4">
            <a href="{{ route('categories.edit', $category) }}" 
               class="btn-action group inline-flex items-center px-6 py-3 rounded-xl border border-dark-100/30 text-gray-300 hover:text-white hover:border-dark-100/50 transition-all text-lg">
                <i class="fas fa-edit mr-2 text-accent/80 group-hover:rotate-12 transition-transform"></i>
                Edit
            </a>
            <button type="button" 
                    onclick="confirmDelete()"
                    class="btn-action group inline-flex items-center px-6 py-3 rounded-xl border-2 border-red-500/30 text-red-400 hover:text-red-300 hover:border-red-500/50 hover:bg-red-500/5 transition-all text-lg">
                <i class="fas fa-trash-alt mr-2 group-hover:rotate-12 transition-transform"></i>
                Delete
            </button>
            
            <form id="delete-form" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Goals Section -->
        <div class="bg-dark-200 rounded-2xl border border-dark-100/20 backdrop-blur-sm shadow-xl" data-aos="fade-up" data-aos-delay="100">
            <div class="p-6 border-b border-dark-100/10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-white">Goals</h2>
                        <p class="text-gray-400 text-sm mt-1">Track your progress</p>
                    </div>
                    <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" 
                       class="btn-create group inline-flex items-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50">
                        <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                        New Goal
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @if($category->goals->count() > 0)
                    <div class="space-y-5">
                        @foreach($category->goals as $goal)
                            <div class="bg-dark-300 rounded-xl p-6 border border-dark-100/10 hover:border-accent/30 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold text-white">{{ $goal->title }}</h3>
                                        <div class="flex items-center mt-3 text-sm text-gray-400">
                                            <i class="fas fa-calendar-alt text-accent/80 mr-2"></i>
                                            {{ $goal->start_date->format('M d, Y') }} - {{ $goal->end_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-4 py-1.5 rounded-full text-sm font-medium
                                            @if($goal->type === 'numeric') bg-blue-500/20 text-blue-400
                                            @else bg-green-500/20 text-green-400 @endif">
                                            {{ ucfirst($goal->type) }}
                                        </span>
                                        @if($goal->type === 'numeric')
                                            <div class="mt-3 text-base font-medium text-gray-300">
                                                {{ $goal->progressLogs->sum('progress_value') }}/{{ $goal->target_value }}
                                                <span class="text-gray-400">{{ $goal->unit }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($goal->type === 'numeric')
                                    <div class="mt-5">
                                        <div class="w-full bg-dark-100/50 rounded-full h-3 overflow-hidden">
                                            <div class="bg-accent h-3 rounded-full transition-all duration-500 relative" 
                                                 style="width: {{ min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100) }}%">
                                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mt-5 flex justify-end">
                                    <a href="{{ route('goals.show', $goal) }}" 
                                       class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
                                        <span>View Details</span>
                                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-accent/10 flex items-center justify-center transform transition-transform hover:scale-110 hover:bg-accent/20">
                            <i class="fas fa-bullseye text-3xl text-accent"></i>
                        </div>
                        <p class="text-gray-400 mb-5 text-lg">No goals in this category yet.</p>
                        <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" 
                           class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group text-lg">
                            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
                            Create your first goal
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Tasks Section -->
        <div class="bg-dark-200 rounded-2xl border border-dark-100/20 backdrop-blur-sm shadow-xl" data-aos="fade-up" data-aos-delay="200">
            <div class="p-6 border-b border-dark-100/10">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-white">Daily Tasks</h2>
                        <p class="text-gray-400 text-sm mt-1">Manage your daily activities</p>
                    </div>
                    <a href="{{ route('dailyTasks.create', ['category_id' => $category->id]) }}" 
                       class="btn-create group inline-flex items-center px-5 py-2.5 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50">
                        <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                        New Task
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @if($category->dailyTasks->count() > 0)
                    <div class="space-y-4">
                        @foreach($category->dailyTasks as $task)
                            <div class="group bg-dark-300 rounded-xl p-5 border border-dark-100/10 hover:border-accent/30 transition-all duration-300 flex items-center justify-between hover:shadow-lg transform hover:-translate-y-0.5">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-white group-hover:text-accent transition-colors">{{ $task->title }}</h3>
                                    @if($task->description)
                                        <p class="text-sm text-gray-400 mt-2">{{ Str::limit($task->description, 60) }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('dailyTasks.edit', $task) }}" 
                                       class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-accent hover:bg-dark-100/50 transition-all group">
                                        <i class="fas fa-edit group-hover:rotate-12 transition-transform"></i>
                                    </a>
                                    <form action="{{ route('dailyTasks.destroy', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirmTaskDelete(event)"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-400 hover:bg-red-500/10 transition-all group">
                                            <i class="fas fa-trash-alt group-hover:rotate-12 transition-transform"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-accent/10 flex items-center justify-center transform transition-transform hover:scale-110 hover:bg-accent/20">
                            <i class="fas fa-tasks text-3xl text-accent"></i>
                        </div>
                        <p class="text-gray-400 mb-5 text-lg">No tasks in this category yet.</p>
                        <a href="{{ route('dailyTasks.create', ['category_id' => $category->id]) }}" 
                           class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group text-lg">
                            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
                            Create your first task
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-create {
        box-shadow: 0 8px 25px -5px rgba(236, 72, 153, 0.4);
    }
    
    .btn-create:hover {
        box-shadow: 0 12px 30px -5px rgba(236, 72, 153, 0.5);
    }
    
    .btn-action {
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.3);
    }
    
    .btn-action:hover {
        box-shadow: 0 8px 20px -3px rgba(0, 0, 0, 0.4);
    }
    
    @keyframes pulse-border {
        0% { border-color: rgba(236, 72, 153, 0.3); }
        50% { border-color: rgba(236, 72, 153, 0.5); }
        100% { border-color: rgba(236, 72, 153, 0.3); }
    }
    
    .animate-pulse-border {
        animation: pulse-border 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
            const deleteBtn = document.querySelector('button[onclick="confirmDelete()"]');
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
            deleteBtn.disabled = true;
            document.getElementById('delete-form').submit();
        }
    }
    
    function confirmTaskDelete(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
            const form = event.target.closest('form');
            const btn = event.target.closest('button');
            const icon = btn.querySelector('i');
            icon.className = 'fas fa-spinner fa-spin';
            btn.disabled = true;
            form.submit();
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS with custom settings
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
        
        // Add hover effect to category icon
        const categoryIcon = document.querySelector('.w-20.h-20');
        categoryIcon.addEventListener('mouseover', function() {
            const icon = this.querySelector('i');
            icon.classList.add('animate-bounce');
            setTimeout(() => icon.classList.remove('animate-bounce'), 1000);
        });
    });
</script>
@endpush
@endsection 