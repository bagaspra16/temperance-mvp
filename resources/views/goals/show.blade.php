@extends('layouts.app')

@section('title', $goal->title)

@section('content')
<div class="pt-24 pb-12">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="mb-6" data-aos="fade-right" data-aos-duration="600">
            <a href="{{ route('goals.index') }}" class="inline-flex items-center text-accent hover:text-accent/80 transition-colors group">
                <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                <span>Back to Goals</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Goal Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Goal Card -->
                <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden" 
                     data-aos="fade-up" data-aos-duration="800">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-4">
                                    <a href="{{ route('categories.show', $goal->category) }}" 
                                       class="inline-flex items-center px-4 py-2 rounded-xl bg-dark-400/50 hover:bg-dark-400/70 transition-colors border border-dark-100/20 group">
                                        <i class="fas fa-{{ $goal->category->icon }} text-{{ $goal->category->color_code }} mr-2"></i>
                                        <span>{{ $goal->category->name }}</span>
                                    </a>
                                    <span class="px-4 py-2 rounded-xl bg-dark-400/50 border border-dark-100/20 capitalize">
                                        <i class="fas fa-clock text-accent/80 mr-2"></i>
                                        {{ $goal->type }}
                                    </span>
                                </div>
                                <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-white to-white/70 bg-clip-text text-transparent">
                                    {{ $goal->title }}
                                </h1>
                                <p class="text-gray-400 text-lg">{{ $goal->description }}</p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('goals.edit', $goal) }}" 
                                   class="inline-flex items-center px-5 py-2.5 rounded-xl bg-accent/10 text-accent hover:bg-accent/20 transition-all border border-accent/20">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </a>
                            </div>
                        </div>

                        <!-- Goal Progress -->
                        <div class="mt-8 p-6 bg-dark-300/50 rounded-xl border border-dark-100/10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line text-accent/80 text-xl"></i>
                                    <h3 class="text-xl font-semibold">Progress</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-white">
                                        {{ $goal->current_value }} / {{ $goal->target_value }}
                                        <span class="text-gray-400 text-lg">{{ $goal->unit }}</span>
                                    </div>
                                    <div class="text-sm text-gray-400">
                                        {{ number_format(($goal->current_value / $goal->target_value) * 100, 1) }}% Complete
                                    </div>
                                </div>
                            </div>
                            <div class="relative h-4 bg-dark-400/50 rounded-full overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-accent to-accent/80 rounded-full transition-all"
                                     style="width: {{ ($goal->current_value / $goal->target_value) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Goal Timeline -->
                        <div class="mt-8 grid grid-cols-2 gap-6">
                            <div class="p-4 bg-dark-300/50 rounded-xl border border-dark-100/10">
                                <div class="flex items-center space-x-2 mb-2">
                                    <i class="fas fa-calendar-plus text-accent/80"></i>
                                    <span class="text-gray-400">Start Date</span>
                                </div>
                                <div class="text-xl font-semibold">{{ $goal->start_date->format('M d, Y') }}</div>
                            </div>
                            <div class="p-4 bg-dark-300/50 rounded-xl border border-dark-100/10">
                                <div class="flex items-center space-x-2 mb-2">
                                    <i class="fas fa-calendar-check text-accent/80"></i>
                                    <span class="text-gray-400">End Date</span>
                                </div>
                                <div class="text-xl font-semibold">{{ $goal->end_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Updates -->
                <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden"
                     data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6 border-b border-dark-100/20">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold">Progress Updates</h2>
                            <button onclick="openUpdateModal()" 
                                    class="px-4 py-2 rounded-xl bg-accent/10 text-accent hover:bg-accent/20 transition-all border border-accent/20">
                                <i class="fas fa-plus mr-2"></i>
                                Add Update
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($goal->updates->count() > 0)
                            <div class="space-y-6">
                                @foreach($goal->updates->sortByDesc('created_at') as $update)
                                    <div class="bg-dark-300/50 rounded-xl p-4 border border-dark-100/10">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <div class="text-lg font-semibold">
                                                    +{{ $update->value }} {{ $goal->unit }}
                                                </div>
                                                <div class="text-gray-400">
                                                    {{ $update->created_at->format('M d, Y h:i A') }}
                                                </div>
                                            </div>
                                            <form action="{{ route('goals.updates.destroy', [$goal, $update]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this update?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @if($update->notes)
                                            <div class="mt-2 text-gray-400">
                                                {{ $update->notes }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-4">No progress updates yet</div>
                                <button onclick="openUpdateModal()" 
                                        class="px-6 py-3 rounded-xl bg-accent/10 text-accent hover:bg-accent/20 transition-all border border-accent/20">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Your First Update
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Goal Stats -->
                <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden"
                     data-aos="fade-left" data-aos-delay="100">
                    <div class="p-6 border-b border-dark-100/20">
                        <h2 class="text-2xl font-bold">Goal Stats</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-dark-300/50 rounded-xl p-4 border border-dark-100/10">
                                <div class="text-gray-400 mb-1">Total Updates</div>
                                <div class="text-2xl font-bold">{{ $goal->updates->count() }}</div>
                            </div>
                            <div class="bg-dark-300/50 rounded-xl p-4 border border-dark-100/10">
                                <div class="text-gray-400 mb-1">Days Left</div>
                                <div class="text-2xl font-bold">{{ now()->diffInDays($goal->end_date) }}</div>
                            </div>
                        </div>
                        <div class="bg-dark-300/50 rounded-xl p-4 border border-dark-100/10">
                            <div class="text-gray-400 mb-1">Daily Average Needed</div>
                            <div class="text-2xl font-bold">
                                {{ number_format(($goal->target_value - $goal->current_value) / max(1, now()->diffInDays($goal->end_date)), 1) }}
                                <span class="text-lg text-gray-400">{{ $goal->unit }}/day</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden"
                     data-aos="fade-left" data-aos-delay="200">
                    <div class="p-6 border-b border-dark-100/20">
                        <h2 class="text-2xl font-bold">Recent Activity</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($goal->updates->sortByDesc('created_at')->take(5) as $update)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center">
                                        <i class="fas fa-chart-line text-accent"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">Added {{ $update->value }} {{ $goal->unit }}</div>
                                        <div class="text-sm text-gray-400">{{ $update->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-400 py-4">
                                    No recent activity
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div id="updateModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
    <div class="bg-dark-200 rounded-2xl shadow-2xl border border-dark-100/20 w-full max-w-lg mx-4"
         data-aos="zoom-in" data-aos-duration="300">
        <div class="p-6 border-b border-dark-100/20">
            <h3 class="text-2xl font-bold">Add Progress Update</h3>
        </div>
        <form action="{{ route('goals.updates.store', $goal) }}" method="POST" id="updateForm">
            @csrf
            <div class="p-6 space-y-6">
                <div class="form-group">
                    <label for="value" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                        <i class="fas fa-plus-circle text-accent/80"></i>
                        <span>Progress Value</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="value" name="value" step="0.01" required
                               class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white text-lg backdrop-blur-sm shadow-inner"
                               placeholder="Enter progress value">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                            {{ $goal->unit }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="form-label inline-flex items-center space-x-2 text-lg mb-3">
                        <i class="fas fa-comment-alt text-accent/80"></i>
                        <span>Notes (Optional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                            class="w-full bg-dark-400/95 border border-dark-100/30 rounded-xl px-5 py-4 focus:ring-2 focus:ring-accent/30 focus:border-accent/50 transition-all text-white placeholder-gray-500 text-lg backdrop-blur-sm shadow-inner resize-none"
                            placeholder="Add any notes about this progress update"></textarea>
                </div>
            </div>
            <div class="p-6 border-t border-dark-100/20 flex justify-end space-x-4">
                <button type="button" onclick="closeUpdateModal()"
                        class="px-6 py-3 rounded-xl border border-dark-100/30 text-gray-400 hover:text-white hover:border-dark-100/50 transition-all">
                    Cancel
                </button>
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                    <i class="fas fa-save mr-2"></i>
                    Save Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Form focus states */
    .form-group:focus-within label {
        @apply text-accent;
    }

    /* Modal animation */
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    #updateModal > div {
        animation: modalFadeIn 0.2s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true
    });

    // Form submission animation
    const updateForm = document.getElementById('updateForm');
    updateForm.addEventListener('submit', function(e) {
        const submitBtn = updateForm.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        submitBtn.disabled = true;
    });
});

function openUpdateModal() {
    const modal = document.getElementById('updateModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('value').focus();
    }, 100);
}

function closeUpdateModal() {
    const modal = document.getElementById('updateModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modal on background click
document.getElementById('updateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUpdateModal();
    }
});
</script>
@endpush 