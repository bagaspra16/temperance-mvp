@extends('layouts.app')

@section('title', 'Habits')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Habits</h1>
        <a href="{{ route('habits.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg mr-1"></i> New Habit
        </a>
    </div>
    
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4">Active Habits</h2>
        
        @if($habits->where('active', true)->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($habits->where('active', true) as $habit)
                    <div class="card hover:border-secondary transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $habit->goal->category->color_code }};">
                                <i class="bi bi-{{ $habit->goal->category->icon }} text-white"></i>
                            </div>
                            <span class="text-sm text-gray-400">{{ $habit->goal->category->name }}</span>
                        </div>
                        
                        <h3 class="text-lg font-semibold mb-2">{{ $habit->title }}</h3>
                        
                        @if($habit->goal)
                            <div class="bg-gray-700 bg-opacity-50 rounded-lg p-2 mb-4">
                                <div class="text-sm">
                                    <span class="text-gray-400">Connected to:</span>
                                    <a href="{{ route('goals.show', $habit->goal) }}" class="text-secondary hover:text-opacity-80 ml-1">
                                        {{ $habit->goal->title }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <div class="flex space-x-1 mb-1">
                                @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $index => $day)
                                    @php $dayNumber = $index + 1; @endphp
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                                        {{ in_array($dayNumber, $habit->schedule) ? 'bg-secondary text-white' : 'bg-gray-700 text-gray-400' }}">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span>Completion Rate</span>
                                <span>{{ number_format($habit->getCompletionRate(), 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-secondary h-2 rounded-full" style="width: {{ $habit->getCompletionRate() }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <div class="badge badge-success">Active</div>
                            </div>
                            <a href="{{ route('habits.show', $habit) }}" class="text-secondary hover:text-opacity-80">
                                Details <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card py-12">
                <div class="text-center">
                    <i class="bi bi-calendar2-check text-5xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">No Active Habits</h3>
                    <p class="text-gray-400 mb-6">You don't have any active habits at the moment.</p>
                    <a href="{{ route('habits.create') }}" class="btn btn-primary">
                        Create Your First Habit
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    @if($habits->where('active', false)->count() > 0)
        <div>
            <h2 class="text-xl font-bold mb-4">Inactive Habits</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($habits->where('active', false) as $habit)
                    <div class="card border-gray-800 hover:border-gray-700 transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 opacity-50" style="background-color: {{ $habit->goal->category->color_code }};">
                                <i class="bi bi-{{ $habit->goal->category->icon }} text-white"></i>
                            </div>
                            <span class="text-sm text-gray-500">{{ $habit->goal->category->name }}</span>
                        </div>
                        
                        <h3 class="text-lg font-semibold mb-2 text-gray-400">{{ $habit->title }}</h3>
                        
                        <div class="mb-4">
                            <div class="flex space-x-1 mb-1 opacity-50">
                                @foreach(['M', 'T', 'W', 'T', 'F', 'S', 'S'] as $index => $day)
                                    @php $dayNumber = $index + 1; @endphp
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                                        {{ in_array($dayNumber, $habit->schedule) ? 'bg-secondary text-white' : 'bg-gray-700 text-gray-400' }}">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <div class="badge badge-secondary">Inactive</div>
                            </div>
                            <a href="{{ route('habits.show', $habit) }}" class="text-gray-400 hover:text-secondary">
                                Details <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 