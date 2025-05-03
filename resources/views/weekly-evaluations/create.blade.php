@extends('layouts.app')

@section('title', 'Weekly Review')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="btn-link">
            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
        </a>
    </div>
    
    <div class="card" data-aos="fade-up" data-aos-duration="800">
        <div class="card-header">
            <h2 class="card-title">Weekly Review</h2>
            <p class="text-gray-400 mt-2">
                {{ $startDate->format('M d') }} - {{ $endDate->format('M d, Y') }}
            </p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('weeklyEvaluations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="week_start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="week_end_date" value="{{ $endDate->format('Y-m-d') }}">
                
                <!-- Week Overview Section -->
                <div class="form-group">
                    <h3 class="text-xl font-semibold mb-6">Week Overview</h3>
                    
                    <!-- Mood Selection -->
                    <div class="mb-8">
                        <label class="form-label">How was your week overall?</label>
                        <div class="flex justify-between items-center mt-4">
                            <div class="mood-option group" data-value="1" onclick="selectMood(1)">
                                <div class="mood-emoji">😞</div>
                                <div class="mood-label">Challenging</div>
                                <div class="mood-indicator"></div>
                            </div>
                            <div class="mood-option group" data-value="2" onclick="selectMood(2)">
                                <div class="mood-emoji">😕</div>
                                <div class="mood-label">Difficult</div>
                                <div class="mood-indicator"></div>
                            </div>
                            <div class="mood-option group" data-value="3" onclick="selectMood(3)">
                                <div class="mood-emoji">😐</div>
                                <div class="mood-label">Neutral</div>
                                <div class="mood-indicator"></div>
                            </div>
                            <div class="mood-option group" data-value="4" onclick="selectMood(4)">
                                <div class="mood-emoji">🙂</div>
                                <div class="mood-label">Good</div>
                                <div class="mood-indicator"></div>
                            </div>
                            <div class="mood-option group" data-value="5" onclick="selectMood(5)">
                                <div class="mood-emoji">😄</div>
                                <div class="mood-label">Great</div>
                                <div class="mood-indicator"></div>
                            </div>
                        </div>
                        <input type="hidden" name="mood_score" id="mood_score" value="3">
                        @error('mood_score')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Productivity Score -->
                    <div class="mb-8">
                        <label class="form-label">Rate your productivity this week:</label>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs text-gray-400">Low</span>
                            <span class="text-xs text-gray-400">High</span>
                        </div>
                        <div class="slider-container">
                            <div class="slider-track"></div>
                            <div class="slider-thumb" id="productivity-thumb"></div>
                            <div class="slider-options">
                                @for($i = 1; $i <= 10; $i++)
                                    <div class="slider-option productivity-option" 
                                         data-value="{{ $i }}" onclick="selectProductivity({{ $i }})">
                                        <span>{{ $i }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <input type="hidden" name="productivity_score" id="productivity_score" value="5">
                        @error('productivity_score')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Energy Level -->
                    <div class="mb-8">
                        <label class="form-label">Your energy level this week:</label>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs text-gray-400">Depleted</span>
                            <span class="text-xs text-gray-400">Energized</span>
                        </div>
                        <div class="slider-container">
                            <div class="slider-track"></div>
                            <div class="slider-thumb" id="energy-thumb"></div>
                            <div class="slider-options">
                                @for($i = 1; $i <= 10; $i++)
                                    <div class="slider-option energy-option" 
                                         data-value="{{ $i }}" onclick="selectEnergy({{ $i }})">
                                        <span>{{ $i }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <input type="hidden" name="energy_level" id="energy_level" value="5">
                        @error('energy_level')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Reflection Questions -->
                <div class="form-group">
                    <h3 class="text-xl font-semibold mb-6">Reflection</h3>
                    
                    <div class="space-y-6">
                        <div class="form-group mb-0">
                            <label for="wins" class="form-label">What were your wins this week?</label>
                            <textarea id="wins" name="wins" class="form-textarea" rows="3" 
                                      placeholder="List your achievements, progress, and positive experiences">{{ old('wins') }}</textarea>
                            <p class="form-helper">Celebrate your accomplishments, no matter how small</p>
                            @error('wins')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <label for="challenges" class="form-label">What challenges did you face?</label>
                            <textarea id="challenges" name="challenges" class="form-textarea" rows="3" 
                                      placeholder="Describe obstacles or difficulties you encountered">{{ old('challenges') }}</textarea>
                            <p class="form-helper">Reflect on what was difficult and what you learned</p>
                            @error('challenges')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <label for="insights" class="form-label">What insights did you gain?</label>
                            <textarea id="insights" name="insights" class="form-textarea" rows="3" 
                                      placeholder="Share any realizations or lessons learned">{{ old('insights') }}</textarea>
                            <p class="form-helper">What did you learn about yourself or your habits?</p>
                            @error('insights')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <label for="next_week" class="form-label">What are your priorities for next week?</label>
                            <textarea id="next_week" name="next_week" class="form-textarea" rows="3" 
                                      placeholder="Outline your focus areas for the coming week">{{ old('next_week') }}</textarea>
                            <p class="form-helper">Set clear intentions for the week ahead</p>
                            @error('next_week')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Habit Completion Overview -->
                <div class="form-group">
                    <h3 class="text-xl font-semibold mb-6">Habit Performance</h3>
                    
                    @if(count($habitStats) > 0)
                        <div class="space-y-4">
                            @foreach($habitStats as $habit)
                                <div class="performance-card">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="font-medium">{{ $habit['title'] }}</div>
                                        <div class="text-sm {{ $habit['percentage'] >= 80 ? 'text-green-400' : ($habit['percentage'] >= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                            {{ $habit['completed'] }}/{{ $habit['scheduled'] }} days
                                        </div>
                                    </div>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: {{ $habit['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-calendar-xmark"></i>
                            </div>
                            <p>No active habits for this week.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Goal Progress Overview -->
                <div class="form-group">
                    <h3 class="text-xl font-semibold mb-6">Goal Progress</h3>
                    
                    @if(count($goalProgress) > 0)
                        <div class="space-y-4">
                            @foreach($goalProgress as $goal)
                                <div class="performance-card">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="font-medium">{{ $goal['title'] }}</div>
                                        <div class="badge badge-{{ $goal['type'] }}">{{ ucfirst($goal['type']) }}</div>
                                    </div>
                                    
                                    @if($goal['type'] === 'numeric')
                                        <div class="flex justify-between items-center text-sm mb-1">
                                            <span>Progress</span>
                                            <span class="{{ $goal['percentage'] >= 80 ? 'text-green-400' : ($goal['percentage'] >= 50 ? 'text-yellow-400' : 'text-gray-400') }}">
                                                {{ $goal['current'] }}/{{ $goal['target'] }} {{ $goal['unit'] }}
                                            </span>
                                        </div>
                                        <div class="progress-container">
                                            <div class="progress-bar" style="width: {{ $goal['percentage'] }}%"></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <p>No active goals for this week.</p>
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-end mt-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Save Weekly Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Mood selection */
    .mood-option {
        @apply flex flex-col items-center justify-center cursor-pointer transition-all rounded-xl py-2 px-4 relative;
    }
    
    .mood-emoji {
        @apply text-3xl mb-1 transition-transform;
    }
    
    .mood-label {
        @apply text-xs text-gray-400;
    }
    
    .mood-indicator {
        @apply absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-accent rounded-full transition-all;
    }
    
    .mood-option:hover .mood-emoji {
        @apply transform scale-110;
    }
    
    .mood-option.selected .mood-indicator {
        @apply w-3/4;
    }
    
    .mood-option.selected .mood-emoji {
        @apply transform scale-110;
    }
    
    /* Slider component */
    .slider-container {
        @apply relative h-14 mt-2 mb-6;
    }
    
    .slider-track {
        @apply absolute top-1/2 left-0 right-0 h-2 -translate-y-1/2 rounded-full;
        background: rgba(55, 65, 81, 0.5);
    }
    
    .slider-thumb {
        @apply absolute top-1/2 w-6 h-6 bg-accent rounded-full -translate-y-1/2 transition-all;
        box-shadow: 0 0 10px rgba(236, 72, 153, 0.4);
        z-index: 10;
    }
    
    .slider-options {
        @apply absolute left-0 right-0 top-0 bottom-0 flex justify-between items-center;
    }
    
    .slider-option {
        @apply flex items-center justify-center w-10 h-10 rounded-full cursor-pointer transition-all;
        z-index: 5;
    }
    
    .slider-option.selected {
        @apply text-white font-medium;
    }
    
    /* Performance Cards */
    .performance-card {
        @apply p-4 rounded-xl transition-all;
        background: rgba(30, 34, 39, 0.7);
        border: 1px solid rgba(55, 65, 81, 0.3);
    }
    
    .performance-card:hover {
        @apply border-accent/30;
        box-shadow: 0 0 15px rgba(236, 72, 153, 0.1);
    }
    
    .progress-container {
        @apply w-full h-2 bg-dark-200 rounded-full overflow-hidden;
    }
    
    .progress-bar {
        @apply h-full transition-all rounded-full;
        background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent));
    }
    
    /* Empty state */
    .empty-state {
        @apply flex flex-col items-center justify-center py-10 text-center text-gray-400 rounded-xl;
        background: rgba(30, 34, 39, 0.3);
        border: 1px dashed rgba(55, 65, 81, 0.3);
    }
    
    .empty-icon {
        @apply text-2xl mb-2 text-gray-500;
    }
    
    /* Badges */
    .badge-binary {
        @apply bg-indigo-500/30 text-indigo-300;
    }
    
    .badge-numeric {
        @apply bg-cyan-500/30 text-cyan-300;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init();
        
        // Set default selections
        selectMood(3);
        selectProductivity(5);
        selectEnergy(5);
        
        // Add animation to performance cards
        const cards = document.querySelectorAll('.performance-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease-in-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });
        
        // Focus first textarea when section is visible
        const textareas = document.querySelectorAll('textarea');
        let observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.target.tagName === 'TEXTAREA' && !entry.target.dataset.focused) {
                    entry.target.dataset.focused = 'true';
                    entry.target.focus();
                }
            });
        }, { threshold: 0.8 });
        
        textareas.forEach(textarea => {
            observer.observe(textarea);
        });
    });

    function selectMood(value) {
        document.querySelectorAll('.mood-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`.mood-option[data-value="${value}"]`).classList.add('selected');
        document.getElementById('mood_score').value = value;
    }
    
    function selectProductivity(value) {
        document.querySelectorAll('.productivity-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`.productivity-option[data-value="${value}"]`).classList.add('selected');
        document.getElementById('productivity_score').value = value;
        
        // Update thumb position
        const thumbElement = document.getElementById('productivity-thumb');
        const percentage = ((value - 1) / 9) * 100;
        thumbElement.style.left = `calc(${percentage}%)`;
    }
    
    function selectEnergy(value) {
        document.querySelectorAll('.energy-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`.energy-option[data-value="${value}"]`).classList.add('selected');
        document.getElementById('energy_level').value = value;
        
        // Update thumb position
        const thumbElement = document.getElementById('energy-thumb');
        const percentage = ((value - 1) / 9) * 100;
        thumbElement.style.left = `calc(${percentage}%)`;
    }
</script>
@endpush
@endsection 