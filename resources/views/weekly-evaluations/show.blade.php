@extends('layouts.app')

@section('title', 'Weekly Review Details')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <a href="{{ route('weeklyEvaluations.index') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Weekly Reviews
        </a>
    </div>
    
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                Weekly Review: {{ $weeklyEvaluation->week_start_date->format('M d') }} - {{ $weeklyEvaluation->week_end_date->format('M d, Y') }}
            </h1>
            <p class="text-gray-400">Week {{ $weeklyEvaluation->week_number }} of {{ $weeklyEvaluation->week_start_date->format('Y') }}</p>
        </div>
        
        <div class="flex space-x-3">
            <form action="{{ route('weeklyEvaluations.destroy', $weeklyEvaluation) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this weekly review?')">
                    <i class="bi bi-trash mr-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Reflections -->
            <div class="card mb-6">
                <h2 class="text-xl font-semibold mb-4">Reflections</h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg mb-2 text-gray-300">Wins</h3>
                        <div class="whitespace-pre-line text-gray-200">{{ $weeklyEvaluation->wins ?: 'No wins recorded' }}</div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg mb-2 text-gray-300">Challenges</h3>
                        <div class="whitespace-pre-line text-gray-200">{{ $weeklyEvaluation->challenges ?: 'No challenges recorded' }}</div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg mb-2 text-gray-300">Insights</h3>
                        <div class="whitespace-pre-line text-gray-200">{{ $weeklyEvaluation->insights ?: 'No insights recorded' }}</div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg mb-2 text-gray-300">Priorities for Next Week</h3>
                        <div class="whitespace-pre-line text-gray-200">{{ $weeklyEvaluation->next_week ?: 'No priorities recorded' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Habit Performance -->
            <div class="card mb-6">
                <h2 class="text-xl font-semibold mb-4">Habit Performance</h2>
                
                @if(count($habitStats) > 0)
                    <div class="space-y-4">
                        @foreach($habitStats as $habit)
                            <div class="p-4 rounded-lg bg-gray-800">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <h3 class="font-medium">{{ $habit['title'] }}</h3>
                                        <p class="text-sm text-gray-400">{{ $habit['completed'] }}/{{ $habit['scheduled'] }} days completed</p>
                                    </div>
                                    <div class="text-lg font-bold">{{ $habit['percentage'] }}%</div>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2">
                                    <div class="bg-secondary h-2 rounded-full" style="width: {{ $habit['percentage'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4 text-center text-gray-400">
                        <p>No habit data available for this week.</p>
                    </div>
                @endif
            </div>
            
            <!-- Goal Progress -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-4">Goal Progress</h2>
                
                @if(count($goalProgress) > 0)
                    <div class="space-y-4">
                        @foreach($goalProgress as $goal)
                            <div class="p-4 rounded-lg bg-gray-800">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium">{{ $goal['title'] }}</h3>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <div class="badge badge-{{ $goal['type'] }}">{{ ucfirst($goal['type']) }}</div>
                                            <div class="text-sm text-gray-400">
                                                {{ $goal['daysLeft'] }} days remaining
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($goal['type'] === 'numeric')
                                            <div class="text-lg font-bold">{{ $goal['percentage'] }}%</div>
                                            <div class="text-sm text-gray-400">
                                                {{ $goal['current'] }}/{{ $goal['target'] }} {{ $goal['unit'] }}
                                            </div>
                                        @else
                                            <div class="badge {{ $goal['complete'] ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $goal['complete'] ? 'Complete' : 'In Progress' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($goal['type'] === 'numeric')
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-700 rounded-full h-2">
                                            <div class="bg-secondary h-2 rounded-full" style="width: {{ $goal['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4 text-center text-gray-400">
                        <p>No goal data available for this week.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar - Overview & Scores -->
        <div class="lg:col-span-1">
            <!-- Week Overview -->
            <div class="card mb-6">
                <h2 class="text-xl font-semibold mb-4">Week Overview</h2>
                
                <!-- Mood -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm text-gray-400">Overall Mood</h3>
                        @php
                            $moodEmoji = '';
                            $moodLabel = '';
                            switch ($weeklyEvaluation->mood_score) {
                                case 1: $moodEmoji = '😞'; $moodLabel = 'Challenging'; break;
                                case 2: $moodEmoji = '😕'; $moodLabel = 'Difficult'; break;
                                case 3: $moodEmoji = '😐'; $moodLabel = 'Neutral'; break;
                                case 4: $moodEmoji = '🙂'; $moodLabel = 'Good'; break;
                                case 5: $moodEmoji = '😄'; $moodLabel = 'Great'; break;
                            }
                        @endphp
                        <div class="text-3xl">{{ $moodEmoji }}</div>
                    </div>
                    <div class="text-right text-sm text-gray-400">{{ $moodLabel }} ({{ $weeklyEvaluation->mood_score }}/5)</div>
                </div>
                
                <!-- Productivity -->
                <div class="mb-6">
                    <h3 class="text-sm text-gray-400 mb-2">Productivity</h3>
                    <div class="w-full bg-gray-700 rounded-full h-3 mb-1">
                        <div class="bg-secondary h-3 rounded-full" style="width: {{ $weeklyEvaluation->productivity_score * 10 }}%"></div>
                    </div>
                    <div class="text-right text-sm">{{ $weeklyEvaluation->productivity_score }}/10</div>
                </div>
                
                <!-- Energy -->
                <div class="mb-6">
                    <h3 class="text-sm text-gray-400 mb-2">Energy Level</h3>
                    <div class="w-full bg-gray-700 rounded-full h-3 mb-1">
                        <div class="bg-secondary h-3 rounded-full" style="width: {{ $weeklyEvaluation->energy_level * 10 }}%"></div>
                    </div>
                    <div class="text-right text-sm">{{ $weeklyEvaluation->energy_level }}/10</div>
                </div>
                
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-400">Created</span>
                        <span class="text-sm">{{ $weeklyEvaluation->created_date->format('M d, Y - g:i A') }}</span>
                    </div>
                    
                    @if($weeklyEvaluation->updated_date && $weeklyEvaluation->updated_date->ne($weeklyEvaluation->created_date))
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-400">Updated</span>
                            <span class="text-sm">{{ $weeklyEvaluation->updated_date->format('M d, Y - g:i A') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Week Calendar -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-4">Week Calendar</h2>
                
                <div class="space-y-2">
                    @php
                        $startDate = $weeklyEvaluation->week_start_date->copy();
                    @endphp
                    
                    @for($i = 0; $i < 7; $i++)
                        @php
                            $currentDate = $startDate->copy()->addDays($i);
                            $isToday = $currentDate->isToday();
                            
                            // Count completed habits for this day
                            $completedHabits = 0;
                            $scheduledHabits = 0;
                            
                            foreach($habitStats as $habit) {
                                // Check if this habit was scheduled for this day
                                $dayOfWeek = $currentDate->dayOfWeek == 0 ? 7 : $currentDate->dayOfWeek;
                                $isScheduled = in_array($dayOfWeek, $habit['schedule']);
                                
                                if ($isScheduled) {
                                    $scheduledHabits++;
                                    
                                    // Check if it was completed
                                    $dateStr = $currentDate->format('Y-m-d');
                                    if (in_array($dateStr, $habit['completedDates'])) {
                                        $completedHabits++;
                                    }
                                }
                            }
                        @endphp
                        
                        <div class="flex items-center p-3 rounded-lg {{ $isToday ? 'bg-gray-700' : 'bg-gray-800' }}">
                            <div class="w-10 text-center font-bold {{ $isToday ? 'text-secondary' : '' }}">
                                {{ $currentDate->format('D') }}
                            </div>
                            <div class="flex-1 ml-3">
                                <div class="font-medium {{ $isToday ? 'text-secondary' : '' }}">
                                    {{ $currentDate->format('M d, Y') }}
                                    @if($isToday)<span class="text-xs ml-2">(Today)</span>@endif
                                </div>
                                
                                @if($scheduledHabits > 0)
                                    <div class="text-xs text-gray-400">
                                        {{ $completedHabits }}/{{ $scheduledHabits }} habits completed
                                    </div>
                                @endif
                            </div>
                            
                            @if($scheduledHabits > 0)
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold
                                    {{ $completedHabits == $scheduledHabits && $scheduledHabits > 0 ? 'bg-green-900 text-green-200' : 
                                        ($completedHabits > 0 ? 'bg-blue-900 text-blue-200' : 'bg-gray-700 text-gray-400') }}">
                                    {{ $completedHabits }}/{{ $scheduledHabits }}
                                </div>
                            @else
                                <div class="w-12 text-right text-gray-500">-</div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 