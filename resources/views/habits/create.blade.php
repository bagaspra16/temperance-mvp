@extends('layouts.app')

@section('title', 'Create Habit')

@section('content')
<div class="container mx-auto max-w-3xl px-4">
    <div class="mb-6">
        <a href="{{ route('habits.index') }}" class="btn-link">
            <i class="fas fa-arrow-left mr-2"></i> Back to Habits
        </a>
    </div>
    
    <div class="card" data-aos="fade-up" data-aos-duration="800">
        <div class="card-header">
            <h2 class="card-title">Create New Habit</h2>
            <p class="text-gray-400 mt-2">Build consistency with regular habits</p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('habits.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group md:col-span-2">
                        <label for="title" class="form-label">Habit Title</label>
                        <input type="text" id="title" name="title" class="form-input" 
                            value="{{ old('title') }}" required placeholder="What habit do you want to build?">
                        <p class="form-helper">Choose a clear and actionable title for your habit</p>
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="goal_id" class="form-label">Connected Goal (Optional)</label>
                        <div class="relative">
                            <select id="goal_id" name="goal_id" class="form-select">
                                <option value="">None - Independent Habit</option>
                                @foreach($goals as $goal)
                                    <option value="{{ $goal->id }}" 
                                        {{ (old('goal_id') == $goal->id || request('goal_id') == $goal->id) ? 'selected' : '' }}>
                                        {{ $goal->title }} ({{ $goal->category->name }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                                <i class="fas fa-link"></i>
                            </div>
                        </div>
                        <p class="form-helper">Connect this habit to a specific goal</p>
                        <div class="flex justify-end mt-3">
                            <a href="{{ route('goals.create') }}" class="btn-link text-sm">
                                <i class="fas fa-plus-circle mr-1"></i> Create new goal
                            </a>
                        </div>
                        @error('goal_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="flex items-center space-x-3 mt-4">
                            <div class="switch-wrapper">
                                <input type="checkbox" id="active" name="active" value="1" class="toggle-switch"
                                    {{ old('active', '1') ? 'checked' : '' }}>
                                <label for="active" class="switch-label"></label>
                            </div>
                            <label for="active" class="cursor-pointer font-medium">Active</label>
                        </div>
                        <p class="form-helper mt-2">Toggle off if you want to create the habit but activate it later</p>
                        @error('active')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Schedule</label>
                        <p class="form-helper mb-4">Select the days of the week when you want to perform this habit</p>
                        
                        <div class="days-of-week">
                            @php
                                $days = [
                                    1 => ['name' => 'Monday', 'short' => 'M'],
                                    2 => ['name' => 'Tuesday', 'short' => 'T'],
                                    3 => ['name' => 'Wednesday', 'short' => 'W'],
                                    4 => ['name' => 'Thursday', 'short' => 'T'],
                                    5 => ['name' => 'Friday', 'short' => 'F'],
                                    6 => ['name' => 'Saturday', 'short' => 'S'],
                                    7 => ['name' => 'Sunday', 'short' => 'S']
                                ];
                                $oldSchedule = old('days', []);
                                if (!is_array($oldSchedule)) {
                                    $oldSchedule = [];
                                }
                            @endphp
                            
                            @foreach($days as $value => $day)
                                <div class="day-item {{ in_array($value, $oldSchedule) ? 'selected' : '' }}"
                                    data-day="{{ $value }}" onclick="toggleDay(this)">
                                    <span class="day-short">{{ $day['short'] }}</span>
                                    <span class="day-name">{{ $day['name'] }}</span>
                                </div>
                                <input type="checkbox" name="days[]" value="{{ $value }}" 
                                    {{ in_array($value, $oldSchedule) ? 'checked' : '' }} 
                                    class="hidden" id="day-{{ $value }}">
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn-link text-sm" id="select-weekdays">
                                <i class="fas fa-briefcase mr-1"></i> Weekdays
                            </button>
                            <button type="button" class="btn-link text-sm" id="select-weekend">
                                <i class="fas fa-umbrella-beach mr-1"></i> Weekend
                            </button>
                            <button type="button" class="btn-link text-sm" id="select-all-days">
                                <i class="fas fa-calendar-check mr-1"></i> Everyday
                            </button>
                            <button type="button" class="btn-link text-sm" id="clear-days">
                                <i class="fas fa-times-circle mr-1"></i> Clear
                            </button>
                        </div>
                        
                        @error('days')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Reminders (Optional)</label>
                        <p class="form-helper mb-4">Add times to be reminded of your habit</p>
                        
                        <div class="reminder-container space-y-4">
                            <div class="reminder-item flex items-center space-x-3" data-id="1">
                                <div class="flex-1 relative">
                                    <input type="time" name="reminder_times[]" class="form-input">
                                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <button type="button" class="text-red-400 hover:text-red-500 hidden remove-reminder p-2 transition-all">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-outline btn-sm mt-4" id="add-reminder">
                            <i class="fas fa-plus-circle mr-1"></i> Add another reminder
                        </button>
                    </div>
                </div>
                
                <div class="flex justify-end mt-12 space-x-4">
                    <a href="{{ route('habits.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Create Habit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Days of week selector */
    .days-of-week {
        @apply grid grid-cols-7 gap-2;
    }
    
    .day-item {
        @apply flex flex-col items-center justify-center py-3 px-1 rounded-xl cursor-pointer transition-all relative overflow-hidden;
        background: rgba(30, 34, 39, 0.7);
        border: 1px solid rgba(55, 65, 81, 0.5);
    }
    
    .day-item:hover {
        @apply border-accent/50 bg-accent/5;
    }
    
    .day-item.selected {
        @apply border-accent bg-accent/10;
        box-shadow: 0 0 10px rgba(236, 72, 153, 0.2);
    }
    
    .day-short {
        @apply text-lg font-medium;
    }
    
    .day-name {
        @apply text-xs text-gray-400 mt-1;
    }
    
    /* Switch style */
    .switch-wrapper {
        @apply relative inline-block;
        width: 52px;
        height: 28px;
    }
    
    .toggle-switch {
        @apply absolute opacity-0 w-0 h-0;
    }
    
    .switch-label {
        @apply absolute inset-0 cursor-pointer rounded-full transition-all;
        background: rgba(55, 65, 81, 0.5);
    }
    
    .switch-label:before {
        content: '';
        @apply absolute left-1 bottom-1 bg-white rounded-full transition-transform;
        height: 20px;
        width: 20px;
    }
    
    .toggle-switch:checked + .switch-label {
        background: linear-gradient(90deg, var(--color-accent), var(--color-accent-light));
    }
    
    .toggle-switch:checked + .switch-label:before {
        transform: translateX(24px);
    }
    
    /* Reminder item animations */
    .reminder-item {
        @apply transition-all;
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .remove-reminder {
        @apply rounded-full h-10 w-10 flex items-center justify-center;
    }
    
    .remove-reminder:hover {
        @apply bg-red-500/10;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init();
        
        // Reminder functionality
        const addReminderBtn = document.getElementById('add-reminder');
        const reminderContainer = document.querySelector('.reminder-container');
        
        addReminderBtn.addEventListener('click', function() {
            const reminderItems = document.querySelectorAll('.reminder-item');
            const newId = reminderItems.length + 1;
            
            // Show remove buttons if we're adding more than one reminder
            if (reminderItems.length >= 1) {
                reminderItems.forEach(item => {
                    item.querySelector('.remove-reminder').classList.remove('hidden');
                });
            }
            
            const newItem = document.createElement('div');
            newItem.className = 'reminder-item flex items-center space-x-3';
            newItem.dataset.id = newId;
            newItem.innerHTML = `
                <div class="flex-1 relative">
                    <input type="time" name="reminder_times[]" class="form-input">
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <button type="button" class="text-red-400 hover:text-red-500 remove-reminder p-2 transition-all">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            
            reminderContainer.appendChild(newItem);
            
            // Add event listener to the remove button
            newItem.querySelector('.remove-reminder').addEventListener('click', function() {
                newItem.style.opacity = '0';
                newItem.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    reminderContainer.removeChild(newItem);
                    
                    // If only one reminder left, hide its remove button
                    const remainingItems = document.querySelectorAll('.reminder-item');
                    if (remainingItems.length === 1) {
                        remainingItems[0].querySelector('.remove-reminder').classList.add('hidden');
                    }
                }, 300);
            });
        });
        
        // Initialize remove buttons for any existing reminders
        document.querySelectorAll('.reminder-item .remove-reminder').forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.reminder-item');
                item.style.opacity = '0';
                item.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    reminderContainer.removeChild(item);
                    
                    const remainingItems = document.querySelectorAll('.reminder-item');
                    if (remainingItems.length === 1) {
                        remainingItems[0].querySelector('.remove-reminder').classList.add('hidden');
                    }
                }, 300);
            });
        });
        
        // Day selection helpers
        document.getElementById('select-weekdays').addEventListener('click', function() {
            selectDays([1, 2, 3, 4, 5]);
        });
        
        document.getElementById('select-weekend').addEventListener('click', function() {
            selectDays([6, 7]);
        });
        
        document.getElementById('select-all-days').addEventListener('click', function() {
            selectDays([1, 2, 3, 4, 5, 6, 7]);
        });
        
        document.getElementById('clear-days').addEventListener('click', function() {
            selectDays([]);
        });
    });

    function toggleDay(element) {
        const dayValue = element.getAttribute('data-day');
        const checkbox = document.getElementById('day-' + dayValue);
        
        element.classList.toggle('selected');
        checkbox.checked = element.classList.contains('selected');
    }
    
    function selectDays(daysArray) {
        // Clear all first
        document.querySelectorAll('.day-item').forEach(day => {
            day.classList.remove('selected');
            const dayValue = day.getAttribute('data-day');
            const checkbox = document.getElementById('day-' + dayValue);
            checkbox.checked = false;
        });
        
        // Select the specified days
        daysArray.forEach(dayValue => {
            const dayElement = document.querySelector(`.day-item[data-day="${dayValue}"]`);
            if (dayElement) {
                dayElement.classList.add('selected');
                const checkbox = document.getElementById('day-' + dayValue);
                checkbox.checked = true;
            }
        });
    }
</script>
@endpush
@endsection 