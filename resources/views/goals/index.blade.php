@extends('layouts.app')

@section('title', 'Goals')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Goals</h1>
        <a href="{{ route('goals.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg mr-1"></i> New Goal
        </a>
    </div>

    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Active Goals</h2>
            <div class="flex space-x-2">
                <button class="btn btn-sm btn-secondary active" data-view="grid" id="grid-view-btn">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button class="btn btn-sm btn-secondary" data-view="list" id="list-view-btn">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>
        </div>

        @if($goals->where('end_date', '>=', now())->count() > 0)
            <div id="grid-view" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($goals->where('end_date', '>=', now()) as $goal)
                    <div class="card hover:border-secondary transition-colors">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $goal->category->color_code }};">
                                <i class="bi bi-{{ $goal->category->icon }} text-white"></i>
                            </div>
                            <span class="text-sm text-gray-400">{{ $goal->category->name }}</span>
                        </div>
                        
                        <h3 class="text-lg font-semibold mb-2">{{ $goal->title }}</h3>
                        
                        @if($goal->description)
                            <p class="text-gray-400 text-sm mb-4">{{ Str::limit($goal->description, 120) }}</p>
                        @endif
                        
                        <div class="flex justify-between items-center mb-3">
                            <div class="badge badge-{{ $goal->type }}">{{ ucfirst($goal->type) }}</div>
                            <span class="text-sm text-gray-400">{{ $goal->start_date->format('M d') }} - {{ $goal->end_date->format('M d, Y') }}</span>
                        </div>
                        
                        @if($goal->type === 'numeric')
                            <div class="mb-3">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Progress</span>
                                    <span>{{ $goal->progressLogs->sum('progress_value') }}/{{ $goal->target_value }} {{ $goal->unit }}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-secondary h-2 rounded-full" style="width: {{ min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100) }}%"></div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                @if($goal->habits->count() > 0)
                                    <span class="text-xs text-gray-400">{{ $goal->habits->count() }} habits</span>
                                @endif
                            </div>
                            <a href="{{ route('goals.show', $goal) }}" class="text-secondary hover:text-opacity-80">
                                Details <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div id="list-view" class="hidden space-y-4">
                @foreach($goals->where('end_date', '>=', now()) as $goal)
                    <div class="card p-4 hover:border-secondary transition-colors">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4" style="background-color: {{ $goal->category->color_code }};">
                                <i class="bi bi-{{ $goal->category->icon }} text-white"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $goal->title }}</h3>
                                        <div class="text-sm text-gray-400 mb-2">{{ $goal->category->name }} · {{ $goal->start_date->format('M d') }} - {{ $goal->end_date->format('M d, Y') }}</div>
                                    </div>
                                    <div class="badge badge-{{ $goal->type }}">{{ ucfirst($goal->type) }}</div>
                                </div>
                                
                                @if($goal->description)
                                    <p class="text-gray-400 text-sm mb-3">{{ Str::limit($goal->description, 200) }}</p>
                                @endif
                                
                                @if($goal->type === 'numeric')
                                    <div class="mb-3">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Progress</span>
                                            <span>{{ $goal->progressLogs->sum('progress_value') }}/{{ $goal->target_value }} {{ $goal->unit }}</span>
                                        </div>
                                        <div class="w-full bg-gray-700 rounded-full h-2">
                                            <div class="bg-secondary h-2 rounded-full" style="width: {{ min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center mt-3">
                                    <div>
                                        @if($goal->habits->count() > 0)
                                            <span class="text-xs text-gray-400">{{ $goal->habits->count() }} habits connected</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('goals.show', $goal) }}" class="text-secondary hover:text-opacity-80">
                                        View Details <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card py-12">
                <div class="text-center">
                    <i class="bi bi-trophy text-5xl text-gray-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">No Active Goals</h3>
                    <p class="text-gray-400 mb-6">You don't have any active goals at the moment.</p>
                    <a href="{{ route('goals.create') }}" class="btn btn-primary">
                        Create Your First Goal
                    </a>
                </div>
            </div>
        @endif
    </div>

    @if($goals->where('end_date', '<', now())->count() > 0)
        <div>
            <h2 class="text-xl font-bold mb-4">Completed Goals</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach($goals->where('end_date', '<', now()) as $goal)
                    <div class="card border-gray-800 hover:border-gray-700 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $goal->category->color_code }};">
                                    <i class="bi bi-{{ $goal->category->icon }} text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ $goal->title }}</h3>
                                    <div class="text-xs text-gray-400">{{ $goal->start_date->format('M d') }} - {{ $goal->end_date->format('M d, Y') }}</div>
                                </div>
                            </div>
                            
                            @if($goal->type === 'numeric')
                                <div class="text-right">
                                    <div class="badge badge-{{ ($goal->progressLogs->sum('progress_value') >= $goal->target_value) ? 'success' : 'danger' }}">
                                        {{ ($goal->progressLogs->sum('progress_value') >= $goal->target_value) ? 'Achieved' : 'Not Achieved' }}
                                    </div>
                                    <div class="text-sm mt-1">
                                        {{ $goal->progressLogs->sum('progress_value') }}/{{ $goal->target_value }} {{ $goal->unit }}
                                    </div>
                                </div>
                            @else
                                <div class="badge badge-secondary">Completed</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridBtn = document.getElementById('grid-view-btn');
        const listBtn = document.getElementById('list-view-btn');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        
        gridBtn.addEventListener('click', function() {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        });
        
        listBtn.addEventListener('click', function() {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');
            gridBtn.classList.remove('active');
            listBtn.classList.add('active');
        });
    });
</script>
@endpush
@endsection 