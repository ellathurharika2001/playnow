<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::with('subcategories')
            ->orderBy('priority', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.category.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        return view('admin.category.form');
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'priority' => 'required|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        Category::create($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    // Show edit form
    public function edit(Category $category)
    {
        return view('admin.category.form', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->category_id . ',category_id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'priority' => 'required|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image_url) {
                $oldImage = str_replace('/storage/', '', $category->image_url);
                Storage::disk('public')->delete($oldImage);
            }
            
            $path = $request->file('image')->store('categories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $category->update($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy(Category $category)
    {
        // Delete image if exists
        if ($category->image_url) {
            $oldImage = str_replace('/storage/', '', $category->image_url);
            Storage::disk('public')->delete($oldImage);
        }

        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully.');
    }

    // Toggle status
    public function toggleStatus(Category $category)
    {
        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return back()->with('success', 'Status updated successfully.');
    }
}