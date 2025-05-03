@extends('layouts.app')

@section('title', $goal->title)

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <a href="{{ route('goals.index') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Goals
        </a>
    </div>
    
    <!-- Goal Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <div class="flex items-center mb-2">
                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $goal->category->color_code }};">
                    <i class="bi bi-{{ $goal->category->icon }} text-white"></i>
                </div>
                <a href="{{ route('categories.show', $goal->category) }}" class="text-gray-400 hover:text-secondary">
                    {{ $goal->category->name }}
                </a>
            </div>
            <h1 class="text-3xl font-bold mb-2">{{ $goal->title }}</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-400">
                <span><i class="bi bi-calendar-range mr-1"></i> {{ $goal->start_date->format('M d, Y') }} - {{ $goal->end_date->format('M d, Y') }}</span>
                <span class="badge badge-{{ $goal->type }}">{{ ucfirst($goal->type) }}</span>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('goals.edit', $goal) }}" class="btn btn-secondary">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                <i class="bi bi-trash mr-1"></i> Delete
            </button>
            
            <form id="delete-form" action="{{ route('goals.destroy', $goal) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Goal Info -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                @if($goal->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-300">{{ $goal->description }}</p>
                    </div>
                @endif
                
                @if($goal->type === 'numeric')
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold">Progress</h3>
                            <span>{{ $goal->progressLogs->sum('progress_value') }} / {{ $goal->target_value }} {{ $goal->unit }}</span>
                        </div>
                        
                        <div class="w-full bg-gray-700 rounded-full h-3 mb-2">
                            <div class="bg-secondary h-3 rounded-full" style="width: {{ min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100) }}%"></div>
                        </div>
                        
                        <div class="text-right text-sm text-gray-400">
                            {{ number_format(min(100, ($goal->progressLogs->sum('progress_value') / $goal->target_value) * 100), 1) }}% complete
                        </div>
                    </div>
                @endif
                
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-semibold">Progress Log</h3>
                        <button type="button" class="btn btn-sm btn-primary" onclick="toggleProgressModal()">
                            <i class="bi bi-plus-lg mr-1"></i> Add Progress
                        </button>
                    </div>
                    
                    @if($goal->progressLogs->count() > 0)
                        <div class="space-y-3">
                            @foreach($goal->progressLogs->sortByDesc('created_date') as $log)
                                <div class="flex justify-between items-center p-3 border border-gray-700 rounded-lg">
                                    <div>
                                        <div class="font-medium">
                                            @if($goal->type === 'numeric')
                                                +{{ $log->progress_value }} {{ $goal->unit }}
                                            @else
                                                {{ $log->notes ? Str::limit($log->notes, 50) : 'Progress update' }}
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            {{ $log->created_date->format('M d, Y - g:i A') }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('goalProgressLogs.destroy', $log) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this progress entry?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-4 text-center text-gray-400">
                            <p>No progress entries yet.</p>
                            <button type="button" class="text-secondary hover:text-opacity-80 inline-block mt-2" onclick="toggleProgressModal()">
                                Add your first progress update
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Related Habits -->
        <div class="lg:col-span-1">
            <div class="card mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Linked Habits</h3>
                    <a href="{{ route('habits.create', ['goal_id' => $goal->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg mr-1"></i> New Habit
                    </a>
                </div>
                
                @if($goal->habits->count() > 0)
                    <div class="space-y-3">
                        @foreach($goal->habits as $habit)
                            <div class="p-3 border border-gray-700 rounded-lg hover:border-secondary transition-colors">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-medium">{{ $habit->title }}</h4>
                                    <div class="badge {{ $habit->active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $habit->active ? 'Active' : 'Inactive' }}
                                    </div>
                                </div>
                                
                                <div class="mt-2 text-sm">
                                    <div class="flex space-x-1">
                                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $index => $day)
                                            @php $dayNumber = $index + 1; @endphp
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs
                                                {{ in_array($dayNumber, $habit->schedule) ? 'bg-secondary text-white' : 'bg-gray-700 text-gray-400' }}">
                                                {{ substr($day, 0, 1) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex justify-end">
                                    <a href="{{ route('habits.show', $habit) }}" class="text-secondary hover:text-opacity-80 text-sm">
                                        Details <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4 text-center text-gray-400">
                        <p>No habits linked to this goal yet.</p>
                        <a href="{{ route('habits.create', ['goal_id' => $goal->id]) }}" class="text-secondary hover:text-opacity-80 inline-block mt-2">
                            Create a habit to support this goal
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div id="progress-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-900 rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Add Progress</h3>
            <button type="button" class="text-gray-400 hover:text-white" onclick="toggleProgressModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <form action="{{ route('goalProgressLogs.store') }}" method="POST">
            @csrf
            <input type="hidden" name="goal_id" value="{{ $goal->id }}">
            
            @if($goal->type === 'numeric')
                <div class="mb-4">
                    <label for="progress_value" class="block mb-2">Progress Value</label>
                    <div class="flex items-center">
                        <input type="number" id="progress_value" name="progress_value" class="input w-full" required min="1">
                        <span class="ml-2">{{ $goal->unit }}</span>
                    </div>
                </div>
            @endif
            
            <div class="mb-4">
                <label for="notes" class="block mb-2">Notes (Optional)</label>
                <textarea id="notes" name="notes" class="input w-full" rows="3"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="btn btn-secondary mr-2" onclick="toggleProgressModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Progress</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleProgressModal() {
        const modal = document.getElementById('progress-modal');
        modal.classList.toggle('hidden');
    }
</script>
@endpush
@endsection 