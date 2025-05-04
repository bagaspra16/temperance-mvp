<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\Category;
use Illuminate\Http\Request;

class DailyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new daily task.
     */
    public function create(Request $request)
    {
        $category = null;
        if ($request->has('category_id')) {
            $category = Category::findOrFail($request->category_id);
        }
        
        return view('daily-tasks.create', compact('category'));
    }

    /**
     * Store a newly created daily task in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $task = DailyTask::create($validated);

        return redirect()
            ->route('categories.show', $task->category_id)
            ->with('success', 'Daily task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified daily task.
     */
    public function edit(DailyTask $dailyTask)
    {
        return view('daily-tasks.edit', compact('dailyTask'));
    }

    /**
     * Update the specified daily task in storage.
     */
    public function update(Request $request, DailyTask $dailyTask)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dailyTask->update($validated);

        return redirect()
            ->route('categories.show', $dailyTask->category_id)
            ->with('success', 'Daily task updated successfully.');
    }

    /**
     * Remove the specified daily task from storage.
     */
    public function destroy(DailyTask $dailyTask)
    {
        $categoryId = $dailyTask->category_id;
        $dailyTask->delete();

        return redirect()
            ->route('categories.show', $categoryId)
            ->with('success', 'Daily task deleted successfully.');
    }
}
