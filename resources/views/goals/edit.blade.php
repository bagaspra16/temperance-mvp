@extends('layouts.app')

@section('title', 'Edit Goal')

@section('content')
<div class="container mx-auto max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('goals.show', $goal) }}" class="text-secondary hover:text-opacity-80">
            <i class="bi bi-arrow-left mr-1"></i> Back to Goal Details
        </a>
    </div>
    
    <div class="card">
        <h2 class="text-2xl font-bold mb-6">Edit Goal</h2>
        
        <form action="{{ route('goals.update', $goal) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="title" class="block mb-2">Goal Title</label>
                    <input type="text" id="title" name="title" class="input w-full" 
                           value="{{ old('title', $goal->title) }}" required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category_id" class="block mb-2">Category</label>
                    <select id="category_id" name="category_id" class="input w-full">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ (old('category_id', $goal->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block mb-2">Description (Optional)</label>
                <textarea id="description" name="description" class="input w-full" rows="3">{{ old('description', $goal->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block mb-2">Goal Type</label>
                <div class="flex space-x-4">
                    <div class="flex items-center">
                        <input type="radio" id="type_binary" name="type" value="binary" class="mr-2" 
                               {{ old('type', $goal->type) === 'binary' ? 'checked' : '' }}>
                        <label for="type_binary">Binary (Complete/Incomplete)</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="type_numeric" name="type" value="numeric" class="mr-2" 
                               {{ old('type', $goal->type) === 'numeric' ? 'checked' : '' }}>
                        <label for="type_numeric">Numeric (Track specific value)</label>
                    </div>
                </div>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div id="numeric-fields" class="mb-6 {{ old('type', $goal->type) === 'numeric' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_value" class="block mb-2">Target Value</label>
                        <input type="number" id="target_value" name="target_value" class="input w-full" 
                               value="{{ old('target_value', $goal->target_value) }}" min="1">
                        @error('target_value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="unit" class="block mb-2">Unit</label>
                        <input type="text" id="unit" name="unit" class="input w-full" 
                               value="{{ old('unit', $goal->unit) }}">
                        @error('unit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_date" class="block mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="input w-full" 
                           value="{{ old('start_date', $goal->start_date->format('Y-m-d')) }}">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="input w-full" 
                           value="{{ old('end_date', $goal->end_date->format('Y-m-d')) }}">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex justify-between">
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit()">
                    Delete Goal
                </button>
                <button type="submit" class="btn btn-primary">Update Goal</button>
            </div>
        </form>
        
        <form id="delete-form" action="{{ route('goals.destroy', $goal) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const numericFields = document.getElementById('numeric-fields');
        
        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'numeric') {
                    numericFields.classList.remove('hidden');
                } else {
                    numericFields.classList.add('hidden');
                }
            });
        });
    });
</script>
@endpush
@endsection 