<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalProgressLogController;
use App\Http\Controllers\WeeklyEvaluationController;
use App\Http\Controllers\ScheduleTemplateController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\DailyTaskController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Auth::routes();

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Goals
    Route::get('/goals/dashboard', [GoalController::class, 'dashboard'])->name('goals.dashboard');
    Route::resource('goals', GoalController::class);
    Route::post('/goals/{goal}/updates', [GoalProgressLogController::class, 'store'])->name('goals.updates.store');
    Route::delete('/goals/{goal}/updates/{update}', [GoalProgressLogController::class, 'destroy'])->name('goals.updates.destroy');
    
    // Daily Tasks
    Route::resource('dailyTasks', DailyTaskController::class);
    
    // Habits
    Route::get('/habits/dashboard', [HabitController::class, 'dashboard'])->name('habits.dashboard');
    Route::post('/habits/{habit}/log', [HabitController::class, 'log'])->name('habits.log');
    Route::post('/habits/{habit}/ajax-log', [HabitController::class, 'ajaxLog'])->name('habits.ajax-log');
    Route::resource('habits', HabitController::class);
    
    // Goal Progress Logs
    Route::resource('goalProgressLogs', GoalProgressLogController::class);
    
    // Weekly Evaluations
    Route::resource('weekly-evaluations', WeeklyEvaluationController::class);
    
    // Schedule Templates
    Route::resource('schedule-templates', ScheduleTemplateController::class);
    
    // User Preferences
    Route::get('/preferences', [UserPreferenceController::class, 'edit'])->name('preferences.edit');
    Route::put('/preferences', [UserPreferenceController::class, 'update'])->name('preferences.update');
});

// Fallback for SPA
Route::fallback(function () {
    return view('app');
});
