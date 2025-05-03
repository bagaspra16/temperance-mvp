<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    /**
     * Display a listing of the user's goals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goals = Goal::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('end_date')
            ->get();
            
        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new goal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('created_by', Auth::id())
            ->orderBy('name')
            ->get();
            
        return view('goals.create', compact('categories'));
    }

    /**
     * Store a newly created goal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|uuid|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:daily,weekly,monthly,yearly',
            'target_value' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('goals.create')
                ->withErrors($validator)
                ->withInput();
        }

        $goal = new Goal();
        $goal->user_id = Auth::id();
        $goal->category_id = $request->category_id;
        $goal->title = $request->title;
        $goal->description = $request->description;
        $goal->type = $request->type;
        $goal->target_value = $request->target_value;
        $goal->unit = $request->unit;
        $goal->start_date = $request->start_date;
        $goal->end_date = $request->end_date;
        $goal->created_by = Auth::id();
        $goal->save();

        return redirect()
            ->route('goals.show', $goal)
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified goal.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        $this->authorize('view', $goal);
        
        $habits = $goal->habits()->orderBy('title')->get();
        $progressLogs = $goal->progressLogs()->orderBy('progress_date', 'desc')->get();
        $progress = $goal->calculateProgress();
        
        return view('goals.show', compact('goal', 'habits', 'progressLogs', 'progress'));
    }

    /**
     * Show the form for editing the specified goal.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function edit(Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $categories = Category::where('created_by', Auth::id())
            ->orderBy('name')
            ->get();
            
        return view('goals.edit', compact('goal', 'categories'));
    }

    /**
     * Update the specified goal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|uuid|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:daily,weekly,monthly,yearly',
            'target_value' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('goals.edit', $goal)
                ->withErrors($validator)
                ->withInput();
        }

        $goal->category_id = $request->category_id;
        $goal->title = $request->title;
        $goal->description = $request->description;
        $goal->type = $request->type;
        $goal->target_value = $request->target_value;
        $goal->unit = $request->unit;
        $goal->start_date = $request->start_date;
        $goal->end_date = $request->end_date;
        $goal->updated_by = Auth::id();
        $goal->updated_date = now();
        $goal->save();

        return redirect()
            ->route('goals.show', $goal)
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified goal from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        
        // First check if the goal has any habits
        if ($goal->habits()->count() > 0) {
            return redirect()
                ->route('goals.show', $goal)
                ->with('error', 'Cannot delete goal with associated habits.');
        }
        
        $goal->delete();
        
        return redirect()
            ->route('goals.index')
            ->with('success', 'Goal deleted successfully.');
    }
    
    /**
     * Display goals dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $activeGoals = Goal::with('category')
            ->where('user_id', Auth::id())
            ->where('end_date', '>=', now())
            ->orderBy('end_date')
            ->get();
            
        $completedGoals = Goal::with('category')
            ->where('user_id', Auth::id())
            ->where('end_date', '<', now())
            ->orderBy('end_date', 'desc')
            ->limit(5)
            ->get();
            
        $categories = Category::where('created_by', Auth::id())
            ->withCount('goals')
            ->orderBy('goals_count', 'desc')
            ->get();
            
        return view('goals.dashboard', compact('activeGoals', 'completedGoals', 'categories'));
    }
} 