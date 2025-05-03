@extends('layouts.app')

@section('title', 'Create Goal')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('goals.index') }}" class="btn-link">
            <i class="fas fa-arrow-left mr-2"></i> Back to Goals
        </a>
    </div>
    
    <div class="card" data-aos="fade-up" data-aos-duration="800">
        <div class="card-header">
            <h2 class="card-title">Create New Goal</h2>
            <p class="text-gray-400 mt-2">Define clear objectives to track your progress</p>
        </div>
        
        <div class="card-body">
            <form action="{{ route('goals.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="form-group mb-0">
                        <label for="title" class="form-label">Goal Title</label>
                        <input type="text" id="title" name="title" class="form-input" 
                               value="{{ old('title') }}" required placeholder="What do you want to achieve?">
                        <p class="form-helper">Choose a clear, actionable title for your goal</p>
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="category_id" class="form-label">Category</label>
                        <div class="relative">
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ (old('category_id') == $category->id || request('category_id') == $category->id) ? 'selected' : '' }}
                                        data-color="{{ $category->color_code }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="category-color-indicator" class="absolute right-14 top-1/2 transform -translate-y-1/2 w-6 h-6 rounded-full hidden"></div>
                        </div>
                        <div class="flex justify-end mt-3">
                            <a href="{{ route('categories.create') }}" class="btn-link text-sm">
                                <i class="fas fa-plus-circle mr-1"></i> Create new category
                            </a>
                        </div>
                        @error('category_id')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea id="description" name="description" class="form-textarea" rows="3" 
                              placeholder="Describe your goal in more detail">{{ old('description') }}</textarea>
                    <p class="form-helper">Add some context or more information about this goal</p>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Goal Type</label>
                    <p class="form-helper mb-4">Choose how you'll track progress toward this goal</p>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="goal-type-option {{ old('type', 'binary') === 'binary' ? 'selected' : '' }}" 
                             onclick="selectGoalType('binary')">
                            <div class="option-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="option-content">
                                <span class="option-title">Binary</span>
                                <span class="option-desc">Complete or Incomplete</span>
                            </div>
                            <input type="radio" id="type_binary" name="type" value="binary" class="hidden" 
                                   {{ old('type', 'binary') === 'binary' ? 'checked' : '' }}>
                        </div>
                        
                        <div class="goal-type-option {{ old('type') === 'numeric' ? 'selected' : '' }}"
                             onclick="selectGoalType('numeric')">
                            <div class="option-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="option-content">
                                <span class="option-title">Numeric</span>
                                <span class="option-desc">Track specific values</span>
                            </div>
                            <input type="radio" id="type_numeric" name="type" value="numeric" class="hidden" 
                                   {{ old('type') === 'numeric' ? 'checked' : '' }}>
                        </div>
                    </div>
                    
                    @error('type')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div id="numeric-fields" class="form-group {{ old('type') === 'numeric' ? '' : 'hidden' }}" data-aos="fade-in">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="form-group mb-0">
                            <label for="target_value" class="form-label">Target Value</label>
                            <div class="relative">
                                <input type="number" id="target_value" name="target_value" class="form-input" 
                                       value="{{ old('target_value') }}" min="1" placeholder="e.g. 10">
                                <div class="absolute right-0 top-0 bottom-0 flex items-center px-4 pointer-events-none">
                                    <span id="unit-label" class="text-gray-400 text-sm"></span>
                                </div>
                            </div>
                            <p class="form-helper">Set a specific target to reach</p>
                            @error('target_value')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-0">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" id="unit" name="unit" class="form-input" 
                                   value="{{ old('unit') }}" placeholder="e.g. miles, books, pounds">
                            <p class="form-helper">Specify a unit of measurement</p>
                            @error('unit')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="form-group mb-0">
                        <label for="start_date" class="form-label">Start Date</label>
                        <div class="relative">
                            <input type="date" id="start_date" name="start_date" class="form-input" 
                                   value="{{ old('start_date', now()->format('Y-m-d')) }}">
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        @error('start_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="end_date" class="form-label">End Date</label>
                        <div class="relative">
                            <input type="date" id="end_date" name="end_date" class="form-input" 
                                   value="{{ old('end_date', now()->addMonths(3)->format('Y-m-d')) }}">
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        <p id="duration-display" class="form-helper"></p>
                        @error('end_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('goals.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Create Goal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .goal-type-option {
        @apply flex items-center cursor-pointer border border-dark-100/50 rounded-xl p-4 transition-all w-full md:w-auto md:flex-1;
        background: rgba(30, 34, 39, 0.7);
    }
    
    .goal-type-option:hover {
        @apply border-accent/50 bg-accent/5;
    }
    
    .goal-type-option.selected {
        @apply border-accent bg-accent/10;
        box-shadow: 0 0 15px rgba(236, 72, 153, 0.2);
    }
    
    .option-icon {
        @apply flex items-center justify-center h-10 w-10 rounded-full bg-dark-100 mr-4 transition-all;
    }
    
    .goal-type-option.selected .option-icon {
        @apply bg-accent/40;
    }
    
    .option-content {
        @apply flex flex-col;
    }
    
    .option-title {
        @apply font-medium;
    }
    
    .option-desc {
        @apply text-sm text-gray-400;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animations
        AOS.init();
        
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const numericFields = document.getElementById('numeric-fields');
        const unitField = document.getElementById('unit');
        const unitLabel = document.getElementById('unit-label');
        const categorySelect = document.getElementById('category_id');
        const colorIndicator = document.getElementById('category-color-indicator');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const durationDisplay = document.getElementById('duration-display');
        
        // Initialize unit label
        unitField.addEventListener('input', function() {
            unitLabel.textContent = this.value;
        });
        
        // Initialize category color indicator
        updateCategoryColorIndicator();
        categorySelect.addEventListener('change', updateCategoryColorIndicator);
        
        function updateCategoryColorIndicator() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            if(selectedOption && selectedOption.value) {
                const color = selectedOption.getAttribute('data-color');
                colorIndicator.style.backgroundColor = color;
                colorIndicator.classList.remove('hidden');
            } else {
                colorIndicator.classList.add('hidden');
            }
        }
        
        // Update duration display
        function updateDurationDisplay() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            if(startDate && endDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if(diffDays > 0) {
                    durationDisplay.textContent = `Duration: ${diffDays} days`;
                    
                    if(diffDays > 30) {
                        const months = Math.floor(diffDays / 30);
                        const remainingDays = diffDays % 30;
                        durationDisplay.textContent = `Duration: ${months} month${months > 1 ? 's' : ''}${remainingDays > 0 ? `, ${remainingDays} day${remainingDays > 1 ? 's' : ''}` : ''}`;
                    }
                } else {
                    durationDisplay.textContent = "End date must be after start date";
                }
            }
        }
        
        startDateInput.addEventListener('change', updateDurationDisplay);
        endDateInput.addEventListener('change', updateDurationDisplay);
        updateDurationDisplay(); // Initial calculation
    });

    function selectGoalType(type) {
        const numericFields = document.getElementById('numeric-fields');
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const typeOptions = document.querySelectorAll('.goal-type-option');
        
        // Update radio button value
        typeRadios.forEach(radio => {
            if(radio.value === type) {
                radio.checked = true;
            }
        });
        
        // Update visual selection
        typeOptions.forEach(option => {
            option.classList.remove('selected');
            if(option.querySelector(`input[value="${type}"]`)) {
                option.classList.add('selected');
            }
        });
        
        // Show/hide numeric fields
        if(type === 'numeric') {
            numericFields.classList.remove('hidden');
        } else {
            numericFields.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection 