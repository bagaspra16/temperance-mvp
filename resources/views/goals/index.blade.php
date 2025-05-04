@extends('layouts.app')

@section('title', 'Goals')

@section('content')
<div class="pt-24 pb-12">
    <div class="container mx-auto max-w-7xl px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-bold mb-2 bg-gradient-to-r from-white to-white/70 bg-clip-text text-transparent" 
                    data-aos="fade-right" data-aos-duration="600">
                    Your Goals
                </h1>
                <p class="text-gray-400" data-aos="fade-right" data-aos-delay="100">
                    Track and manage your personal goals
                </p>
            </div>
            <div class="flex items-center space-x-4" data-aos="fade-left" data-aos-delay="200">
                <a href="{{ route('goals.create') }}" 
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                    <i class="fas fa-plus mr-2"></i>
                    New Goal
                </a>
            </div>
        </div>

        <!-- Goals Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($goals as $goal)
                <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm overflow-hidden hover:border-accent/30 transition-all transform hover:-translate-y-1" 
                     data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="p-6">
                        <!-- Goal Header -->
                        <div class="flex items-start justify-between mb-4">
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

                        <!-- Goal Title & Description -->
                        <h3 class="text-2xl font-bold mb-2 line-clamp-1">
                            <a href="{{ route('goals.show', $goal) }}" class="hover:text-accent transition-colors">
                                {{ $goal->title }}
                            </a>
                        </h3>
                        <p class="text-gray-400 mb-6 line-clamp-2">{{ $goal->description }}</p>

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between items-baseline mb-2">
                                <div class="text-sm text-gray-400">Progress</div>
                                <div class="text-right">
                                    <span class="font-semibold">{{ $goal->current_value }}</span>
                                    <span class="text-gray-400">/{{ $goal->target_value }} {{ $goal->unit }}</span>
                                </div>
                            </div>
                            <div class="relative h-2 bg-dark-400/50 rounded-full overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-accent to-accent/80 rounded-full transition-all"
                                     style="width: {{ ($goal->current_value / $goal->target_value) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Goal Footer -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="text-sm">
                                    <div class="text-gray-400">Start</div>
                                    <div>{{ $goal->start_date->format('M d, Y') }}</div>
                                </div>
                                <div class="text-sm">
                                    <div class="text-gray-400">End</div>
                                    <div>{{ $goal->end_date->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <a href="{{ route('goals.show', $goal) }}" 
                               class="inline-flex items-center text-accent hover:text-accent/80 transition-colors">
                                Details
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-3">
                    <div class="bg-dark-200 rounded-2xl shadow-xl border border-dark-100/20 backdrop-blur-sm p-12 text-center"
                         data-aos="fade-up">
                        <div class="w-20 h-20 rounded-full bg-accent/10 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-flag text-3xl text-accent"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">No Goals Yet</h3>
                        <p class="text-gray-400 mb-8">Start tracking your progress by creating your first goal</p>
                        <a href="{{ route('goals.create') }}" 
                           class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-accent to-accent/80 text-white hover:from-accent/90 hover:to-accent/70 transform hover:scale-105 transition-all focus:ring-2 focus:ring-accent/50 text-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Create Your First Goal
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($goals instanceof \Illuminate\Pagination\LengthAwarePaginator && $goals->hasPages())
            <div class="mt-8" data-aos="fade-up">
                {{ $goals->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Card hover effect */
    .goal-card:hover {
        box-shadow: 0 0 30px rgba(236, 72, 153, 0.1);
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
});
</script>
@endpush
@endsection 