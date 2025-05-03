@extends('layouts.app')

@section('title', 'User Preferences')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Dashboard
        </a>
    </div>
    
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">User Preferences</h2>
        
        @if(session('success'))
            <div class="bg-green-900 text-green-100 p-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('preferences.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Theme Settings -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Theme Settings</h3>
                
                <div class="mb-4">
                    <label class="block mb-2">App Theme</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="theme-option {{ $userPreferences->theme === 'dark' ? 'selected' : '' }}" data-theme="dark" onclick="selectTheme('dark')">
                            <div class="theme-preview dark-theme">
                                <div class="header"></div>
                                <div class="sidebar"></div>
                                <div class="content"></div>
                            </div>
                            <div class="theme-name">Dark (Default)</div>
                        </div>
                        
                        <div class="theme-option {{ $userPreferences->theme === 'light' ? 'selected' : '' }}" data-theme="light" onclick="selectTheme('light')">
                            <div class="theme-preview light-theme">
                                <div class="header"></div>
                                <div class="sidebar"></div>
                                <div class="content"></div>
                            </div>
                            <div class="theme-name">Light</div>
                        </div>
                    </div>
                    <input type="hidden" name="theme" id="theme" value="{{ $userPreferences->theme }}">
                </div>
                
                <div class="mb-4">
                    <label for="accent_color" class="block mb-2">Accent Color</label>
                    <div class="flex items-center space-x-4">
                        <input type="color" id="accent_color" name="accent_color" value="{{ $userPreferences->accent_color }}" class="h-10 w-10 rounded">
                        <span class="text-sm text-gray-400">Select your preferred accent color for buttons and highlights</span>
                    </div>
                </div>
            </div>
            
            <!-- Notification Settings -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Notification Settings</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="email_notifications" class="block font-medium">Email Notifications</label>
                            <p class="text-sm text-gray-400">Receive weekly summaries and important updates via email</p>
                        </div>
                        <div>
                            <input type="checkbox" id="email_notifications" name="email_notifications" value="1" class="toggle-switch"
                                   {{ $userPreferences->email_notifications ? 'checked' : '' }}>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="push_notifications" class="block font-medium">Push Notifications</label>
                            <p class="text-sm text-gray-400">Receive real-time reminders for habits and goals</p>
                        </div>
                        <div>
                            <input type="checkbox" id="push_notifications" name="push_notifications" value="1" class="toggle-switch"
                                   {{ $userPreferences->push_notifications ? 'checked' : '' }}>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="weekly_summary" class="block font-medium">Weekly Summary</label>
                            <p class="text-sm text-gray-400">Receive a summary of your progress each week</p>
                        </div>
                        <div>
                            <input type="checkbox" id="weekly_summary" name="weekly_summary" value="1" class="toggle-switch"
                                   {{ $userPreferences->weekly_summary ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Display Settings -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Display Settings</h3>
                
                <div class="mb-4">
                    <label for="default_view" class="block mb-2">Default Dashboard View</label>
                    <select id="default_view" name="default_view" class="input w-full">
                        <option value="day" {{ $userPreferences->default_view === 'day' ? 'selected' : '' }}>Day View</option>
                        <option value="week" {{ $userPreferences->default_view === 'week' ? 'selected' : '' }}>Week View</option>
                        <option value="month" {{ $userPreferences->default_view === 'month' ? 'selected' : '' }}>Month View</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="start_day" class="block mb-2">Week Starts On</label>
                    <select id="start_day" name="start_day" class="input w-full">
                        <option value="monday" {{ $userPreferences->start_day === 'monday' ? 'selected' : '' }}>Monday</option>
                        <option value="sunday" {{ $userPreferences->start_day === 'sunday' ? 'selected' : '' }}>Sunday</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="date_format" class="block mb-2">Date Format</label>
                    <select id="date_format" name="date_format" class="input w-full">
                        <option value="MM/DD/YYYY" {{ $userPreferences->date_format === 'MM/DD/YYYY' ? 'selected' : '' }}>MM/DD/YYYY</option>
                        <option value="DD/MM/YYYY" {{ $userPreferences->date_format === 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="YYYY-MM-DD" {{ $userPreferences->date_format === 'YYYY-MM-DD' ? 'selected' : '' }}>YYYY-MM-DD</option>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <label for="show_completed" class="block font-medium">Show Completed Items</label>
                        <p class="text-sm text-gray-400">Display completed habits and goals in your dashboard</p>
                    </div>
                    <div>
                        <input type="checkbox" id="show_completed" name="show_completed" value="1" class="toggle-switch"
                               {{ $userPreferences->show_completed ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Save Preferences</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
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
    
    .theme-option {
        @apply border border-gray-700 rounded-lg p-4 cursor-pointer transition-colors;
    }
    
    .theme-option.selected {
        @apply border-secondary;
    }
    
    .theme-preview {
        @apply rounded-lg h-32 mb-2 relative overflow-hidden;
    }
    
    .dark-theme {
        @apply bg-gray-800;
    }
    
    .dark-theme .header {
        @apply bg-gray-900 h-6;
    }
    
    .dark-theme .sidebar {
        @apply bg-gray-900 w-1/4 h-full absolute left-0 top-6;
    }
    
    .dark-theme .content {
        @apply bg-gray-800 w-3/4 h-full absolute right-0 top-6;
    }
    
    .light-theme {
        @apply bg-gray-200;
    }
    
    .light-theme .header {
        @apply bg-white h-6;
    }
    
    .light-theme .sidebar {
        @apply bg-white w-1/4 h-full absolute left-0 top-6;
    }
    
    .light-theme .content {
        @apply bg-gray-200 w-3/4 h-full absolute right-0 top-6;
    }
    
    .theme-name {
        @apply text-center font-medium;
    }
</style>
@endpush

@push('scripts')
<script>
    function selectTheme(theme) {
        document.querySelectorAll('.theme-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`.theme-option[data-theme="${theme}"]`).classList.add('selected');
        document.getElementById('theme').value = theme;
    }
</script>
@endpush
@endsection 