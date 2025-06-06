<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalProgressLog;
use App\Services\GoalTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GoalProgressLogController extends Controller
{
    /**
     * The goal tracking service.
     *
     * @var GoalTrackingService
     */
    protected $goalTrackingService;
    
    /**
     * Create a new controller instance.
     *
     * @param GoalTrackingService $goalTrackingService
     * @return void
     */
    public function __construct(GoalTrackingService $goalTrackingService)
    {
        $this->goalTrackingService = $goalTrackingService;
    }
    
    /**
     * Display a listing of the goal progress logs.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function index(Goal $goal)
    {
        $this->authorize('view', $goal);
        
        $logs = $goal->progressLogs()
            ->orderBy('progress_date', 'desc')
            ->get();
            
        $stats = $this->goalTrackingService->getGoalStats($goal);
        
        return view('goals.progress.index', compact('goal', 'logs', 'stats'));
    }

    /**
     * Show the form for creating a new progress log.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function create(Goal $goal)
    {
        $this->authorize('update', $goal);
        
        return view('goals.progress.create', compact('goal'));
    }

    /**
     * Store a newly created progress log in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('goals.show', $goal)
                ->withErrors($validator)
                ->withInput();
        }

        $update = new GoalProgressLog();
        $update->goal_id = $goal->id;
        $update->user_id = Auth::id();
        $update->progress_value = $request->value;
        $update->progress_date = now();
        $update->note = $request->notes;
        $update->created_by = Auth::id();
        $update->save();

        return redirect()
            ->route('goals.show', $goal)
            ->with('success', 'Progress update added successfully.');
    }

    /**
     * Display the specified progress log.
     *
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return \Illuminate\Http\Response
     */
    public function show(GoalProgressLog $progressLog)
    {
        $this->authorize('view', $progressLog);
        
        $goal = $progressLog->goal;
        
        return view('goals.progress.show', compact('progressLog', 'goal'));
    }

    /**
     * Show the form for editing the specified progress log.
     *
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return \Illuminate\Http\Response
     */
    public function edit(GoalProgressLog $progressLog)
    {
        $this->authorize('update', $progressLog);
        
        $goal = $progressLog->goal;
        
        return view('goals.progress.edit', compact('progressLog', 'goal'));
    }

    /**
     * Update the specified progress log in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoalProgressLog $progressLog)
    {
        $this->authorize('update', $progressLog);
        
        $validator = Validator::make($request->all(), [
            'progress_value' => 'required|integer|min:1',
            'progress_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('goals.progress.edit', $progressLog)
                ->withErrors($validator)
                ->withInput();
        }

        $progressLog->progress_value = $request->progress_value;
        $progressLog->progress_date = $request->progress_date;
        $progressLog->note = $request->note;
        $progressLog->updated_by = Auth::id();
        $progressLog->updated_date = now();
        $progressLog->save();

        return redirect()
            ->route('goals.show', $progressLog->goal)
            ->with('success', 'Progress log updated successfully.');
    }

    /**
     * Remove the specified progress log from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @param  \App\Models\GoalProgressLog  $update
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal, GoalProgressLog $update)
    {
        $this->authorize('delete', $goal);
        
        if ($update->goal_id !== $goal->id) {
            abort(404);
        }
        
        $update->delete();
        
        return redirect()
            ->route('goals.show', $goal)
            ->with('success', 'Progress update deleted successfully.');
    }
} 