<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\WeeklyEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $dayOfWeek = $today->dayOfWeekIso; // 1 (Monday) to 7 (Sunday)
        
        // Today's habits
        $todaysHabits = Habit::with(['category'])
            ->where('user_id', Auth::id())
            ->where('active', true)
            ->get()
            ->filter(function ($habit) use ($dayOfWeek) {
                return $habit->isScheduledForDay($dayOfWeek);
            });
        
        // Active habits count
        $activeHabits = Habit::where('user_id', Auth::id())
            ->where('active', true)
            ->count();
        
        // Active goals
        $goals = Goal::with('category')
            ->where('user_id', Auth::id())
            ->where('end_date', '>=', $today)
            ->orderBy('end_date')
            ->get();
            
        // Active goals count
        $activeGoals = $goals->count();
            
        // Get goals progress
        foreach ($goals as $goal) {
            $goal->progress = $goal->calculateProgress();
        }
        
        // Total completed goals
        $totalGoalsCompleted = Goal::where('user_id', Auth::id())
            ->where('completed', true)
            ->count();
        
        // Latest weekly review
        $latestReview = WeeklyEvaluation::where('user_id', Auth::id())
            ->orderBy('week_end', 'desc')
            ->first();
        
        return view('dashboard', compact(
            'todaysHabits',
            'activeHabits',
            'goals',
            'activeGoals',
            'totalGoalsCompleted',
            'latestReview',
            'today'
        ));
    }
} 