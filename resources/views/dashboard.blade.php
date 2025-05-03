@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-8">
    <!-- Welcome Panel -->
    <div class="welcome-panel" data-aos="fade-up" data-aos-duration="800">
        <div class="welcome-content px-6">
            <h1 class="welcome-title text-3xl md:text-4xl">Welcome back, <span class="gradient-text">{{ Auth::user()->name }}</span></h1>
            <p class="welcome-date text-lg">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="welcome-decoration">
            <div class="decoration-circle"></div>
            <div class="decoration-circle secondary"></div>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="stats-grid" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
        <div class="stat-tile p-6 md:p-8">
            <div class="stat-icon-wrapper">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="stat-details">
                <span class="stat-value">{{ $activeHabits }}</span>
                <span class="stat-label">Active Habits</span>
            </div>
            <div class="stat-decoration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                    <path class="decoration-shape" d="M43.5,83.1c17.8-21.1,45.8-27.3,67.2-14c23.3,14.4,35,53.5,19.1,79.8c-10.2,16.9-29.1,16.9-48.9,14.3
                    c-18.1-2.4-38.8-7.5-45.9-23.2C28.5,123.4,29.7,99.7,43.5,83.1z"></path>
                </svg>
            </div>
        </div>
        
        <div class="stat-tile p-6 md:p-8">
            <div class="stat-icon-wrapper">
                <i class="fas fa-bullseye"></i>
            </div>
            <div class="stat-details">
                <span class="stat-value">{{ $activeGoals }}</span>
                <span class="stat-label">Active Goals</span>
            </div>
            <div class="stat-decoration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                    <path class="decoration-shape" d="M143.5,119.6c-15.8,23.8-44.3,33-68.3,22.3c-26-11.7-42.9-49.6-30.6-77.9c7.9-18.1,26.9-20.6,47.1-20.6
                    c18.4,0,39.5,1.7,49.2,16.3C151.5,76.4,155.8,100.6,143.5,119.6z"></path>
                </svg>
            </div>
        </div>
        
        <div class="stat-tile p-6 md:p-8">
            <div class="stat-icon-wrapper">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-details">
                <span class="stat-value">{{ $totalGoalsCompleted }}</span>
                <span class="stat-label">Goals Completed</span>
            </div>
            <div class="stat-decoration">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
                    <path class="decoration-shape" d="M94.5,55.1c25.8-11.6,57.5-2.5,71.9,20.7c15.6,25.1,7.8,67.9-19.9,87.4c-17.7,12.5-36.8,5.5-53.9-4.9
                    c-15.6-9.4-31.5-22.7-33.2-41.2C57.4,98.1,74.4,64.4,94.5,55.1z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Main Dashboard -->
    <div class="dashboard-grid" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
        <!-- Today's Habits Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Today's Habits</h3>
                </div>
                <a href="{{ route('habits.index') }}" class="header-action">
                    <span>View All</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if(count($todaysHabits) > 0)
                <div class="card-list">
                    @foreach($todaysHabits as $habit)
                    <div class="list-item">
                        <div class="item-content">
                            <div class="item-marker">
                                <span class="color-dot" style="background-color: {{ $habit->category ? $habit->category->color : '#9ca3af' }};"></span>
                            </div>
                            <span class="item-title">{{ $habit->name }}</span>
                        </div>
                        <div class="item-actions">
                            @if($habit->completedToday())
                            <div class="status-indicator completed">
                                <i class="fas fa-check"></i>
                                <span>Done</span>
                            </div>
                            @else
                            <button class="action-button logHabit" data-habit-id="{{ $habit->id }}">
                                <i class="fas fa-check"></i>
                                <span>Log</span>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-container">
                    <div class="empty-illustration">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="empty-title">No habits for today</h4>
                    <p class="empty-subtitle">You don't have any habits scheduled for today.</p>
                    <a href="{{ route('habits.create') }}" class="empty-action">
                        <i class="fas fa-plus"></i>
                        <span>Create a Habit</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Active Goals Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Active Goals</h3>
                </div>
                <a href="{{ route('goals.index') }}" class="header-action">
                    <span>View All</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @if(count($goals) > 0)
                <div class="card-list">
                    @foreach($goals as $goal)
                    <div class="list-item goal-item">
                        <div class="goal-info">
                            <div class="goal-header">
                                <div class="item-marker">
                                    <span class="color-dot" style="background-color: {{ $goal->category ? $goal->category->color : '#9ca3af' }};"></span>
                                </div>
                                <span class="item-title">{{ $goal->name }}</span>
                                <span class="goal-percentage">{{ $goal->progress }}%</span>
                            </div>
                            <div class="progress-container">
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: {{ $goal->progress }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-container">
                    <div class="empty-illustration">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="empty-title">No active goals</h4>
                    <p class="empty-subtitle">You don't have any active goals yet.</p>
                    <a href="{{ route('goals.create') }}" class="empty-action">
                        <i class="fas fa-plus"></i>
                        <span>Create a Goal</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Weekly Review Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Weekly Overview</h3>
                </div>
                <a href="{{ route('weekly-evaluations.create') }}" class="header-action">
                    <span>New Review</span>
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-body">
                @if($latestReview)
                <div class="review-content">
                    <div class="review-header">
                        <div class="review-date">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Week of {{ \Carbon\Carbon::parse($latestReview->week_start)->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="review-section">
                        <h4 class="review-section-title">How was your week?</h4>
                        <div class="rating-display">
                            <div class="rating-meter">
                                <div class="rating-track">
                                    <div class="rating-fill" style="width: {{ ($latestReview->rating / 10) * 100 }}%;"></div>
                                </div>
                            </div>
                            <div class="rating-value">
                                {{ $latestReview->rating }}<span>/10</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="review-section">
                        <h4 class="review-section-title">What went well</h4>
                        <p class="review-text">{{ $latestReview->went_well }}</p>
                    </div>
                    
                    <a href="{{ route('weekly-evaluations.show', $latestReview->id) }}" class="review-action">
                        View Complete Review
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @else
                <div class="empty-container">
                    <div class="empty-illustration">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="empty-title">No weekly reviews</h4>
                    <p class="empty-subtitle">You haven't created any weekly reviews yet.</p>
                    <a href="{{ route('weekly-evaluations.create') }}" class="empty-action">
                        <i class="fas fa-plus"></i>
                        <span>Create Review</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions-container" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </h2>
        </div>
        <div class="quick-actions-grid">
            <a href="{{ route('habits.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span class="quick-action-title">New Habit</span>
            </a>
            
            <a href="{{ route('goals.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <span class="quick-action-title">New Goal</span>
            </a>
            
            <a href="{{ route('categories.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <span class="quick-action-title">Categories</span>
            </a>
            
            <a href="{{ route('weekly-evaluations.create') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span class="quick-action-title">Weekly Review</span>
            </a>
        </div>
    </div>
    
    <!-- Calendar Overview -->
    <div class="calendar-container" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-calendar-alt"></i>
                This Week
            </h2>
        </div>
        <div class="calendar-card">
            <div class="calendar-grid">
                @php
                    $startOfWeek = now()->startOfWeek();
                    $today = now()->startOfDay();
                @endphp
                
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $index => $day)
                    @php
                        $currentDay = $startOfWeek->copy()->addDays($index);
                        $isToday = $currentDay->isSameDay($today);
                    @endphp
                    <div class="day-column">
                        <div class="day-header">{{ $day }}</div>
                        <div class="day-circle {{ $isToday ? 'today' : '' }}">
                            {{ $currentDay->format('d') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out'
        });
        
        // Log Habit Functionality
        document.querySelectorAll('.logHabit').forEach(button => {
            button.addEventListener('click', function() {
                const habitId = this.getAttribute('data-habit-id');
                
                // Create a loading state
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.classList.add('loading');
                
                fetch(`/habits/${habitId}/ajax-log`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Replace button with completed status
                        const statusIndicator = document.createElement('div');
                        statusIndicator.className = 'status-indicator completed';
                        statusIndicator.innerHTML = '<i class="fas fa-check"></i><span>Done</span>';
                        
                        this.parentNode.replaceChild(statusIndicator, this);
                    } else {
                        // Restore button if error
                        this.innerHTML = originalContent;
                        this.classList.remove('loading');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = originalContent;
                    this.classList.remove('loading');
                });
            });
        });
    });
</script>
@endpush 