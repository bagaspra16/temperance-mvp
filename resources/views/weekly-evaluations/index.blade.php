@extends('layouts.app')

@section('title', 'Weekly Reviews')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Weekly Reviews</h1>
        <a href="{{ route('weeklyEvaluations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg mr-1"></i> New Review
        </a>
    </div>
    
    @if($weeklyEvaluations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($weeklyEvaluations as $evaluation)
                <div class="card hover:border-secondary transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $evaluation->week_start_date->format('M d') }} - {{ $evaluation->week_end_date->format('M d, Y') }}</h3>
                            <p class="text-sm text-gray-400">Week {{ $evaluation->week_number }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php
                                $moodEmoji = '';
                                switch ($evaluation->mood_score) {
                                    case 1: $moodEmoji = '😞'; break;
                                    case 2: $moodEmoji = '😕'; break;
                                    case 3: $moodEmoji = '😐'; break;
                                    case 4: $moodEmoji = '🙂'; break;
                                    case 5: $moodEmoji = '😄'; break;
                                }
                            @endphp
                            <div class="text-2xl" title="Mood: {{ $evaluation->mood_score }}/5">{{ $moodEmoji }}</div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-3 bg-gray-800 rounded-lg">
                            <div class="text-xs text-gray-400 mb-1">Productivity</div>
                            <div class="flex items-center">
                                <div class="h-2 bg-secondary rounded-full mr-2" style="width: {{ $evaluation->productivity_score * 10 }}%"></div>
                                <span class="text-sm">{{ $evaluation->productivity_score }}/10</span>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-gray-800 rounded-lg">
                            <div class="text-xs text-gray-400 mb-1">Energy</div>
                            <div class="flex items-center">
                                <div class="h-2 bg-secondary rounded-full mr-2" style="width: {{ $evaluation->energy_level * 10 }}%"></div>
                                <span class="text-sm">{{ $evaluation->energy_level }}/10</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-sm font-medium mb-1">Wins</h4>
                        <p class="text-gray-400 text-sm line-clamp-2">{{ $evaluation->wins ?: 'No wins recorded' }}</p>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('weeklyEvaluations.show', $evaluation) }}" class="text-secondary hover:text-opacity-80">
                            View Details <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $weeklyEvaluations->links() }}
        </div>
    @else
        <div class="card py-12">
            <div class="text-center">
                <i class="bi bi-calendar-week text-5xl text-gray-600 mb-4"></i>
                <h3 class="text-xl font-semibold mb-2">No Weekly Reviews Yet</h3>
                <p class="text-gray-400 mb-6">Regular reflection helps you stay on track with your goals and habits.</p>
                <a href="{{ route('weeklyEvaluations.create') }}" class="btn btn-primary">
                    Create Your First Weekly Review
                </a>
            </div>
        </div>
    @endif
    
    @if($weeklyEvaluations->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-6">Your Progress Over Time</h2>
            
            <div class="card">
                <div class="overflow-x-auto">
                    <canvas id="weeklyStatsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    @endif
</div>

@if($weeklyEvaluations->count() > 0)
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyStatsChart').getContext('2d');
            
            const labels = @json($chartData['labels']);
            const moodData = @json($chartData['mood']);
            const productivityData = @json($chartData['productivity']);
            const energyData = @json($chartData['energy']);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Mood (0-5)',
                            data: moodData,
                            borderColor: '#ff9f1c',
                            backgroundColor: 'rgba(255, 159, 28, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y-mood'
                        },
                        {
                            label: 'Productivity (0-10)',
                            data: productivityData,
                            borderColor: '#2ec4b6',
                            backgroundColor: 'rgba(46, 196, 182, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Energy (0-10)',
                            data: energyData,
                            borderColor: '#e71d36',
                            backgroundColor: 'rgba(231, 29, 54, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        'y-mood': {
                            beginAtZero: true,
                            max: 5,
                            position: 'right',
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                font: {
                                    family: 'Inter, sans-serif'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endif
@endsection 