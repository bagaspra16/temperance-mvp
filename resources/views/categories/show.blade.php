@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Categories
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $category->color_code }};">
                <i class="bi bi-{{ $category->icon }} text-lg text-white"></i>
            </div>
            <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                <i class="bi bi-trash mr-1"></i> Delete
            </button>
            
            <form id="delete-form" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Goals Section -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Goals</h2>
                <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> New Goal
                </a>
            </div>
            
            @if($category->goals->count() > 0)
                <div class="space-y-4">
                    @foreach($category->goals as $goal)
                        <div class="border border-gray-700 rounded-lg p-4 hover:border-secondary transition-colors">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="font-medium">{{ $goal->title }}</h3>
                                    <div class="text-sm text-gray-400">
                                        {{ $goal->start_date->format('M d, Y') }} - {{ $goal->end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="badge badge-{{ $goal->type }}">{{ ucfirst($goal->type) }}</div>
                                    <div class="mt-1">
                                        @if($goal->type === 'numeric')
                                            <span class="text-sm">{{ $goal->progressLogs->sum('progress_value') }}/{{ $goal->target_value }} {{ $goal->unit }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if($goal->type === 'numeric')
                                <div class="mt-3">
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-secondary h-2 rounded-full" style="width: {{ min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100) }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-3 flex justify-end">
                                <a href="{{ route('goals.show', $goal) }}" class="text-secondary hover:text-opacity-80 text-sm">
                                    View Details <i class="bi bi-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-4 text-center text-gray-400">
                    <p>No goals in this category yet.</p>
                    <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="text-secondary hover:text-opacity-80 inline-block mt-2">
                        Create your first goal
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Tasks Section -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Daily Tasks</h2>
                <a href="{{ route('dailyTasks.create', ['category_id' => $category->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> New Task
                </a>
            </div>
            
            @if($category->dailyTasks->count() > 0)
                <div class="space-y-3">
                    @foreach($category->dailyTasks as $task)
                        <div class="flex items-center border border-gray-700 rounded-lg p-3 hover:border-secondary transition-colors">
                            <div class="flex-1">
                                <div class="font-medium">{{ $task->title }}</div>
                                @if($task->description)
                                    <div class="text-sm text-gray-400">{{ Str::limit($task->description, 60) }}</div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('dailyTasks.edit', $task) }}" class="text-gray-400 hover:text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('dailyTasks.destroy', $task) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this task?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-4 text-center text-gray-400">
                    <p>No tasks in this category yet.</p>
                    <a href="{{ route('dailyTasks.create', ['category_id' => $category->id]) }}" class="text-secondary hover:text-opacity-80 inline-block mt-2">
                        Create your first task
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 