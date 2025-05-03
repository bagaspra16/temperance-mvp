@extends('layouts.app')

@section('title', 'Edit Habit')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('habits.show', $habit) }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Habit Details
        </a>
    </div>
    
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">Edit Habit</h2>
        
        <form action="{{ route('habits.update', $habit) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="title" class="block mb-2">Habit Title</label>
                <input type="text" id="title" name="title" class="input w-full" 
                       value="{{ old('title', $habit->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="goal_id" class="block mb-2">Connected Goal (Optional)</label>
                <select id="goal_id" name="goal_id" class="input w-full">
                    <option value="">None - Independent Habit</option>
                    @foreach($goals as $goal)
                        <option value="{{ $goal->id }}" 
                            {{ (old('goal_id', $habit->goal_id) == $goal->id) ? 'selected' : '' }}>
                            {{ $goal->title }} ({{ $goal->category->name }})
                        </option>
                    @endforeach
                </select>
                @error('goal_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block mb-2">Schedule</label>
                <p class="text-sm text-gray-400 mb-3">Select the days of the week when you want to perform this habit</p>
                
                <div class="flex flex-wrap gap-3">
                    @php
                        $days = [
                            1 => 'Monday',
                            2 => 'Tuesday',
                            3 => 'Wednesday',
                            4 => 'Thursday',
                            5 => 'Friday',
                            6 => 'Saturday',
                            7 => 'Sunday'
                        ];
                        $schedule = old('schedule', $habit->schedule ?? []);
                        if (!is_array($schedule)) {
                            $schedule = [];
                        }
                    @endphp
                    
                    @foreach($days as $value => $day)
                        <div class="day-selector {{ in_array($value, $schedule) ? 'selected' : '' }}"
                             data-day="{{ $value }}" onclick="toggleDay(this)">
                            <span>{{ $day }}</span>
                        </div>
                        <input type="checkbox" name="schedule[]" value="{{ $value }}" 
                               {{ in_array($value, $schedule) ? 'checked' : '' }} 
                               class="hidden" id="day-{{ $value }}">
                    @endforeach
                </div>
                @error('schedule')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block mb-2">Status</label>
                <div class="flex items-center">
                    <input type="checkbox" id="active" name="active" value="1" class="toggle-switch"
                           {{ old('active', $habit->active) ? 'checked' : '' }}>
                    <label for="active" class="ml-2">Active</label>
                </div>
                <p class="text-sm text-gray-400 mt-1">Toggle off if you want to pause this habit</p>
                @error('active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block mb-2">Reminders</label>
                <div class="reminder-container">
                    @if($habit->reminders->count() > 0)
                        @foreach($habit->reminders as $index => $reminder)
                            <div class="reminder-item mb-3 flex items-center space-x-2">
                                <input type="time" name="reminder_times[]" class="input" 
                                       value="{{ \Carbon\Carbon::parse($reminder->time)->format('H:i') }}">
                                <button type="button" class="text-red-500 hover:text-red-700 {{ $habit->reminders->count() === 1 ? 'hidden' : '' }} remove-reminder">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="reminder-item mb-3 flex items-center space-x-2">
                            <input type="time" name="reminder_times[]" class="input">
                            <button type="button" class="text-red-500 hover:text-red-700 hidden remove-reminder">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" class="text-secondary hover:text-opacity-80 text-sm" id="add-reminder">
                    <i class="bi bi-plus-circle mr-1"></i> Add another reminder
                </button>
            </div>
            
            <div class="flex justify-between">
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                    Delete Habit
                </button>
                <button type="submit" class="btn btn-primary">Update Habit</button>
            </div>
        </form>
        
        <form id="delete-form" action="{{ route('habits.destroy', $habit) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('styles')
<style>
    .day-selector {
        @apply px-4 py-2 rounded-lg border border-gray-700 cursor-pointer transition-colors;
    }
    
    .day-selector.selected {
        @apply border-secondary bg-secondary bg-opacity-20;
    }
    
    .toggle-switch {
        @apply relative appearance-none w-11 h-6 rounded-full bg-gray-700 transition-colors
               focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50 cursor-pointer;
    }
    
    .toggle-switch:checked {
        @apply bg-secondary;
    }
    
    .toggle-switch:before {
        content: '';
        @apply absolute left-1 top-1 bg-white rounded-full w-4 h-4 transition-transform;
    }
    
    .toggle-switch:checked:before {
        @apply transform translate-x-5;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleDay(element) {
        const dayValue = element.getAttribute('data-day');
        const checkbox = document.getElementById('day-' + dayValue);
        
        element.classList.toggle('selected');
        checkbox.checked = element.classList.contains('selected');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const addReminderBtn = document.getElementById('add-reminder');
        const reminderContainer = document.querySelector('.reminder-container');
        
        addReminderBtn.addEventListener('click', function() {
            const reminderItems = document.querySelectorAll('.reminder-item');
            
            // Show remove buttons if we're adding more than one reminder
            if (reminderItems.length >= 1) {
                reminderItems.forEach(item => {
                    item.querySelector('.remove-reminder').classList.remove('hidden');
                });
            }
            
            const newItem = document.createElement('div');
            newItem.className = 'reminder-item mb-3 flex items-center space-x-2';
            newItem.innerHTML = `
                <input type="time" name="reminder_times[]" class="input">
                <button type="button" class="text-red-500 hover:text-red-700 remove-reminder">
                    <i class="bi bi-x-circle"></i>
                </button>
            `;
            
            reminderContainer.appendChild(newItem);
            
            // Add event listener to the remove button
            newItem.querySelector('.remove-reminder').addEventListener('click', function() {
                reminderContainer.removeChild(newItem);
                
                // If only one reminder left, hide its remove button
                const remainingItems = document.querySelectorAll('.reminder-item');
                if (remainingItems.length === 1) {
                    remainingItems[0].querySelector('.remove-reminder').classList.add('hidden');
                }
            });
        });
        
        // Initialize remove buttons for any existing reminders
        document.querySelectorAll('.reminder-item .remove-reminder').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.reminder-item');
                reminderContainer.removeChild(item);
                
                const remainingItems = document.querySelectorAll('.reminder-item');
                if (remainingItems.length === 1) {
                    remainingItems[0].querySelector('.remove-reminder').classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
@endsection 