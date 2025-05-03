<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the user's categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('created_by', Auth::id())
            ->orderBy('name')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'color_code' => 'required|string|size:7|regex:/^#[0-9A-F]{6}$/i',
            'icon' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('categories.create')
                ->withErrors($validator)
                ->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->color_code = $request->color_code;
        $category->icon = $request->icon;
        $category->created_by = Auth::id();
        $category->save();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'color_code' => 'required|string|size:7|regex:/^#[0-9A-F]{6}$/i',
            'icon' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('categories.edit', $category)
                ->withErrors($validator)
                ->withInput();
        }

        $category->name = $request->name;
        $category->color_code = $request->color_code;
        $category->icon = $request->icon;
        $category->updated_by = Auth::id();
        $category->updated_date = now();
        $category->save();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        
        // Check if the category has associated goals
        if ($category->goals()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Cannot delete category with associated goals.');
        }
        
        // Check if the category has associated daily tasks
        if ($category->dailyTasks()->count() > 0) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Cannot delete category with associated daily tasks.');
        }
        
        $category->delete();
        
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
} 