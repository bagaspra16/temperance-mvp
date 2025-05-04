@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="min-h-screen flex flex-col">
    <div class="container mx-auto px-4 flex-grow">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4" data-aos="fade-down" data-aos-duration="600">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-accent to-accent/50 bg-clip-text text-transparent">Categories</h2>
                <p class="text-gray-400 mt-1">Organize your goals and habits</p>
            </div>
            <a href="{{ route('categories.create') }}" 
               class="btn-create group inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                New Category
            </a>
        </div>
        
        @if ($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($categories as $category)
                    <div class="bg-dark-200 rounded-2xl border border-dark-100/20 p-6 hover:border-accent/30 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-accent/5"
                         data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 transform transition-transform group-hover:scale-110 shadow-lg" 
                                     style="background-color: {{ $category->color_code }}">
                                    <i class="fas fa-{{ $category->icon }} text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white">{{ $category->name }}</h3>
                                    <div class="flex items-center mt-1 space-x-3 text-sm">
                                        <span class="text-gray-400">
                                            <i class="fas fa-bullseye mr-1 text-accent/80"></i>
                                            {{ $category->goals->count() }} goals
                                        </span>
                                        <span class="text-gray-400">
                                            <i class="fas fa-tasks mr-1 text-accent/80"></i>
                                            {{ $category->dailyTasks->count() }} tasks
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="dropdown relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-dark-100/50 transition-colors">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-dark-300 rounded-xl shadow-xl border border-dark-100/20 py-2 z-10">
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-dark-100/50">
                                        <i class="fas fa-eye mr-2 text-accent/80"></i> View Details
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-dark-100/50">
                                        <i class="fas fa-edit mr-2 text-accent/80"></i> Edit Category
                                    </a>
                                    <button @click="if(confirm('Are you sure you want to delete this category?')) $refs.deleteForm{{ $category->id }}.submit()" 
                                            class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10">
                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                    </button>
                                    
                                    <form x-ref="deleteForm{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-dark-100/10">
                            <a href="{{ route('categories.show', $category) }}" 
                               class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
                                <span>View Details</span>
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-dark-200 rounded-2xl border border-dark-100/20 p-12 mb-8" data-aos="fade-up" data-aos-duration="800">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-accent/10 flex items-center justify-center">
                        <i class="fas fa-tags text-4xl text-accent"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Categories Yet</h3>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">
                        Categories help you organize your goals and habits. Create your first category to get started on your journey.
                    </p>
                    <a href="{{ route('categories.create') }}" 
                       class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 group">
                        <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                        Create Your First Category
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <footer class="mt-auto py-6 bg-dark-200/50 backdrop-blur-sm border-t border-dark-100/10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <p class="text-gray-400 text-sm">
                    <i class="fas fa-layer-group text-accent/80 mr-2"></i>
                    Total Categories: {{ $categories->count() }}
                </p>
            </div>
        </div>
    </footer>
</div>

@push('styles')
<style>
    .btn-create {
        box-shadow: 0 4px 20px -5px rgba(236, 72, 153, 0.3);
    }
    
    /* Ensure smooth transitions for grid items */
    .grid > div {
        transition: all 0.3s ease-in-out;
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
            once: true,
            offset: 50
        });
    });
</script>
@endpush
@endsection 