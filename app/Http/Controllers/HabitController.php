<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Goal;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HabitController extends Controller
{
    /**
     * Display a listing of the user's habits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habits = Habit::with(['goal', 'goal.category'])
            ->where('user_id', Auth::id())
            ->where('active', true)
            ->orderBy('title')
            ->get();
            
        return view('habits.index', compact('habits'));
    }

    /**
     * Show the form for creating a new habit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $goals = Goal::where('user_id', Auth::id())
            ->where('end_date', '>=', now())
            ->orderBy('title')
            ->get();
            
        // Pre-select goal if provided
        $goalId = $request->query('goal_id');
        
        return view('habits.create', compact('goals', 'goalId'));
    }

    /**
     * Store a newly created habit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'goal_id' => 'nullable|uuid|exists:goals,id',
            'days' => 'required|array',
            'days.*' => 'integer|between:1,7',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('habits.create')
                ->withErrors($validator)
                ->withInput();
        }

        $habit = new Habit();
        $habit->user_id = Auth::id();
        $habit->goal_id = $request->goal_id;
        $habit->title = $request->title;
        $habit->schedule = ['days' => $request->days];
        $habit->active = true;
        $habit->created_by = Auth::id();
        $habit->save();

        if ($request->goal_id) {
            return redirect()
                ->route('goals.show', $request->goal_id)
                ->with('success', 'Habit created successfully.');
        }

        return redirect()
            ->route('habits.show', $habit)
            ->with('success', 'Habit created successfully.');
    }

    /**
     * Display the specified habit.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function show(Habit $habit)
    {
        $this->authorize('view', $habit);
        
        // Get recent logs
        $recentLogs = $habit->logs()
            ->orderBy('log_date', 'desc')
            ->limit(30)
            ->get();
            
        // Calculate statistics
        $completionRate = $habit->getCompletionRate();
        $longestStreak = $this->calculateLongestStreak($habit);
        $currentStreak = $this->calculateCurrentStreak($habit);
        
        return view('habits.show', compact('habit', 'recentLogs', 'completionRate', 'longestStreak', 'currentStreak'));
    }

    /**
     * Show the form for editing the specified habit.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function edit(Habit $habit)
    {
        $this->authorize('update', $habit);
        
        $goals = Goal::where('user_id', Auth::id())
            ->where('end_date', '>=', now())
            ->orderBy('title')
            ->get();
            
        return view('habits.edit', compact('habit', 'goals'));
    }

    /**
     * Update the specified habit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'goal_id' => 'nullable|uuid|exists:goals,id',
            'days' => 'required|array',
            'days.*' => 'integer|between:1,7',
            'active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('habits.edit', $habit)
                ->withErrors($validator)
                ->withInput();
        }

        $habit->goal_id = $request->goal_id;
        $habit->title = $request->title;
        $habit->schedule = ['days' => $request->days];
        $habit->active = $request->has('active');
        $habit->updated_by = Auth::id();
        $habit->updated_date = now();
        $habit->save();

        return redirect()
            ->route('habits.show', $habit)
            ->with('success', 'Habit updated successfully.');
    }

    /**
     * Remove the specified habit from storage.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);
        
        $habit->delete();
        
        return redirect()
            ->route('habits.index')
            ->with('success', 'Habit deleted successfully.');
    }
    
    /**
     * Log a habit completion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit);
        
        $validator = Validator::make($request->all(), [
            'log_date' => 'required|date',
            'status' => 'required|boolean',
            'note' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if log already exists for this date
        $existingLog = HabitLog::where('habit_id', $habit->id)
            ->where('log_date', $request->log_date)
            ->first();
            
        if ($existingLog) {
            $existingLog->status = $request->status;
            $existingLog->note = $request->note;
            $existingLog->updated_by = Auth::id();
            $existingLog->updated_date = now();
            $existingLog->save();
        } else {
            $log = new HabitLog();
            $log->habit_id = $habit->id;
            $log->user_id = Auth::id();
            $log->log_date = $request->log_date;
            $log->status = $request->status;
            $log->note = $request->note;
            $log->created_by = Auth::id();
            $log->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Habit logged successfully.');
    }
    
    /**
     * Log a habit completion via AJAX.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxLog(Habit $habit)
    {
        $this->authorize('update', $habit);
        
        try {
            // Log the habit for today
            $today = now()->toDateString();
            
            // Check if log already exists for today
            $existingLog = HabitLog::where('habit_id', $habit->id)
                ->where('log_date', $today)
                ->first();
                
            if ($existingLog) {
                $existingLog->status = true;
                $existingLog->updated_by = Auth::id();
                $existingLog->updated_date = now();
                $existingLog->save();
            } else {
                $log = new HabitLog();
                $log->habit_id = $habit->id;
                $log->user_id = Auth::id();
                $log->log_date = $today;
                $log->status = true;
                $log->created_by = Auth::id();
                $log->save();
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Display habits dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $today = Carbon::today();
        $dayOfWeek = $today->dayOfWeekIso; // 1 (Monday) to 7 (Sunday)
        
        // Get habits scheduled for today
        $todayHabits = Habit::with(['goal', 'goal.category'])
            ->where('user_id', Auth::id())
            ->where('active', true)
            ->get()
            ->filter(function ($habit) use ($dayOfWeek) {
                return $habit->isScheduledForDay($dayOfWeek);
            });
            
        // Get today's logs
        $todayLogs = HabitLog::where('user_id', Auth::id())
            ->where('log_date', $today->toDateString())
            ->pluck('status', 'habit_id')
            ->toArray();
            
        // Weekly stats
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();
        
        $weekLogs = HabitLog::where('user_id', Auth::id())
            ->whereBetween('log_date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get();
            
        $weeklyStats = [
            'total' => $weekLogs->count(),
            'completed' => $weekLogs->where('status', true)->count(),
        ];
        
        return view('habits.dashboard', compact('todayHabits', 'todayLogs', 'weeklyStats', 'today'));
    }
    
    /**
     * Calculate the longest streak of habit completion.
     *
     * @param  \App\Models\Habit  $habit
     * @return int
     */
    private function calculateLongestStreak(Habit $habit)
    {
        $logs = $habit->logs()
            ->where('status', true)
            ->orderBy('log_date')
            ->get()
            ->pluck('log_date')
            ->map(function ($date) {
                return Carbon::parse($date);
            });
            
        if ($logs->isEmpty()) {
            return 0;
        }
        
        $longestStreak = 1;
        $currentStreak = 1;
        
        for ($i = 1; $i < $logs->count(); $i++) {
            $prevDate = $logs[$i-1];
            $currDate = $logs[$i];
            
            if ($prevDate->addDay()->isSameDay($currDate)) {
                $currentStreak++;
            } else {
                $longestStreak = max($longestStreak, $currentStreak);
                $currentStreak = 1;
            }
        }
        
        return max($longestStreak, $currentStreak);
    }
    
    /**
     * Calculate the current streak of habit completion.
     *
     * @param  \App\Models\Habit  $habit
     * @return int
     */
    private function calculateCurrentStreak(Habit $habit)
    {
        $logs = $habit->logs()
            ->where('status', true)
            ->orderBy('log_date', 'desc')
            ->get()
            ->pluck('log_date')
            ->map(function ($date) {
                return Carbon::parse($date);
            });
            
        if ($logs->isEmpty()) {
            return 0;
        }
        
        $today = Carbon::today();
        
        // Check if most recent log is today or yesterday
        if (!$logs[0]->isSameDay($today) && !$logs[0]->isSameDay($today->copy()->subDay())) {
            return 0;
        }
        
        $currentStreak = 1;
        
        for ($i = 1; $i < $logs->count(); $i++) {
            $prevDate = $logs[$i-1];
            $currDate = $logs[$i];
            
            if ($prevDate->subDay()->isSameDay($currDate)) {
                $currentStreak++;
            } else {
                break;
            }
        }
        
        return $currentStreak;
    }
} 