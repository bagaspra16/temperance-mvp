<?php

namespace App\Providers;

use App\Services\HabitTrackingService;
use App\Services\GoalTrackingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register HabitTrackingService
        $this->app->singleton(HabitTrackingService::class, function ($app) {
            return new HabitTrackingService();
        });
        
        // Register GoalTrackingService
        $this->app->singleton(GoalTrackingService::class, function ($app) {
            return new GoalTrackingService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
