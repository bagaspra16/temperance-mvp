@extends('layouts.app')

@section('title', $habit->title)

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <a href="{{ route('habits.index') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Habits
        </a>
    </div>
    
    <!-- Habit Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            @if($habit->goal)
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $habit->goal->category->color_code }};">
                        <i class="bi bi-{{ $habit->goal->category->icon }} text-white"></i>
                    </div>
                    <div>
                        <span class="text-gray-400">
                            {{ $habit->goal->category->name }} /
                            <a href="{{ route('goals.show', $habit->goal) }}" class="text-secondary hover:text-opacity-80">
                                {{ $habit->goal->title }}
                            </a>
                        </span>
                    </div>
                </div>
            @endif
            <h1 class="text-3xl font-bold mb-2">{{ $habit->title }}</h1>
            <div class="flex items-center space-x-4">
                <div class="badge {{ $habit->active ? 'badge-success' : 'badge-secondary' }}">
                    {{ $habit->active ? 'Active' : 'Inactive' }}
                </div>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('habits.edit', $habit) }}" class="btn btn-secondary">
                <i class="bi bi-pencil mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                <i class="bi bi-trash mr-1"></i> Delete
            </button>
            
            <form id="delete-form" action="{{ route('habits.destroy', $habit) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Habit Info & Tracking -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Schedule</h3>
                    <div class="flex justify-between">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $index => $day)
                            @php $dayNumber = $index + 1; @endphp
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mb-1
                                    {{ in_array($dayNumber, $habit->schedule) ? 'bg-secondary text-white' : 'bg-gray-700 text-gray-400' }}">
                                    {{ substr($day, 0, 1) }}
                                </div>
                                <span class="text-xs text-gray-400">{{ substr($day, 0, 3) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                @if($habit->reminders->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Reminders</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($habit->reminders as $reminder)
                                <div class="px-3 py-1 rounded-full bg-gray-700 text-sm">
                                    <i class="bi bi-bell mr-1"></i>
                                    {{ \Carbon\Carbon::parse($reminder->time)->format('g:i A') }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-semibold">Completion Rate</h3>
                        <span>{{ number_format($habit->getCompletionRate(), 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-3 mb-2">
                        <div class="bg-secondary h-3 rounded-full" style="width: {{ $habit->getCompletionRate() }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Tracking</h3>
                        <button type="button" class="btn btn-sm btn-primary" id="log-completion-btn">
                            <i class="bi bi-check-circle mr-1"></i> Log Completion
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            <div class="h-80 overflow-y-auto pr-2">
                                @if($habit->logs->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($habit->logs->sortByDesc('completed_date') as $log)
                                            <div class="flex justify-between items-center p-3 border border-gray-700 rounded-lg">
                                                <div>
                                                    <div class="font-medium">
                                                        {{ $log->completed_date->format('l, M d, Y') }}
                                                    </div>
                                                    @if($log->notes)
                                                        <div class="text-sm text-gray-400">
                                                            {{ $log->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <form action="{{ route('habitLogs.destroy', $log) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-400 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this log?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-8 text-center text-gray-400">
                                        <p>No completion logs yet.</p>
                                        <button type="button" class="text-secondary hover:text-opacity-80 inline-block mt-2" id="empty-log-btn">
                                            Log your first completion
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Habit Stats & Calendar -->
        <div class="lg:col-span-1">
            <div class="card mb-6">
                <h3 class="text-lg font-semibold mb-4">Stats</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-800 rounded-lg">
                        <div class="text-gray-400">Current Streak</div>
                        <div class="text-xl font-bold">{{ $currentStreak }} days</div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-800 rounded-lg">
                        <div class="text-gray-400">Longest Streak</div>
                        <div class="text-xl font-bold">{{ $longestStreak }} days</div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-800 rounded-lg">
                        <div class="text-gray-400">Total Completions</div>
                        <div class="text-xl font-bold">{{ $habit->logs->count() }}</div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-gray-800 rounded-lg">
                        <div class="text-gray-400">This Month</div>
                        <div class="text-xl font-bold">{{ $habit->logs->where('completed_date', '>=', now()->startOfMonth())->count() }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h3 class="text-lg font-semibold mb-4">Last 30 Days</h3>
                
                <div class="grid grid-cols-7 gap-1">
                    @php
                        $today = \Carbon\Carbon::now();
                        $startDate = \Carbon\Carbon::now()->subDays(29);
                        $dates = [];
                        $completedDates = $habit->logs->pluck('completed_date')->map(function($date) {
                            return $date->format('Y-m-d');
                        })->toArray();
                        
                        for ($i = 0; $i < 30; $i++) {
                            $currentDate = $startDate->copy()->addDays($i);
                            $dates[] = $currentDate;
                        }
                    @endphp
                    
                    @foreach($dates as $date)
                        @php
                            $isToday = $date->isToday();
                            $isCompleted = in_array($date->format('Y-m-d'), $completedDates);
                            $isScheduled = in_array($date->dayOfWeek === 0 ? 7 : $date->dayOfWeek, $habit->schedule);
                            
                            $classes = 'w-8 h-8 rounded-full flex items-center justify-center text-xs ';
                            
                            if ($isCompleted) {
                                $classes .= 'bg-secondary text-white';
                            } elseif ($isToday) {
                                $classes .= 'border-2 border-dashed border-secondary text-white';
                            } elseif ($isScheduled) {
                                $classes .= 'bg-gray-700 text-gray-300';
                            } else {
                                $classes .= 'bg-gray-800 text-gray-500';
                            }
                        @endphp
                        
                        <div class="flex flex-col items-center">
                            <div class="{{ $classes }}" title="{{ $date->format('M d, Y') }}">
                                {{ $date->format('d') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ substr($date->format('D'), 0, 1) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Completion Modal -->
<div id="log-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-900 rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Log Habit Completion</h3>
            <button type="button" class="text-gray-400 hover:text-white" onclick="toggleLogModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <form action="{{ route('habitLogs.store') }}" method="POST">
            @csrf
            <input type="hidden" name="habit_id" value="{{ $habit->id }}">
            
            <div class="mb-4">
                <label for="completed_date" class="block mb-2">Date</label>
                <input type="date" id="completed_date" name="completed_date" class="input w-full" 
                       value="{{ now()->format('Y-m-d') }}" required>
            </div>
            
            <div class="mb-4">
                <label for="notes" class="block mb-2">Notes (Optional)</label>
                <textarea id="notes" name="notes" class="input w-full" rows="2" placeholder="How did it go?"></textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="button" class="btn btn-secondary mr-2" onclick="toggleLogModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleLogModal() {
        const modal = document.getElementById('log-modal');
        modal.classList.toggle('hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('log-completion-btn').addEventListener('click', toggleLogModal);
        
        const emptyLogBtn = document.getElementById('empty-log-btn');
        if (emptyLogBtn) {
            emptyLogBtn.addEventListener('click', toggleLogModal);
        }
    });
</script>
@endpush
@endsection 