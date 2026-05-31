<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    // Show all subcategories
    public function index(Category $category)
    {
        $subcategories = $category->subcategories()
            ->orderBy('priority', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.subcategory.index', compact('subcategories', 'category'));
    }

    // Show create form
    public function create(Category $category)
    {
        return view('admin.subcategory.form', compact('category'));
    }

    // Store new subcategory
    public function store(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'priority' => 'required|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('subcategories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        SubCategory::create($validated);

        return redirect()->route('category.subcategory.index', $category)
            ->with('success', 'SubCategory created successfully.');
    }

    // Show edit form
    public function edit(Category $category, SubCategory $subcategory)
    {
        return view('admin.subcategory.form', compact('subcategory', 'category'));
    }

    // Update subcategory
    public function update(Request $request, Category $category, SubCategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
            'priority' => 'required|integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image_url) {
                $oldImage = str_replace('/storage/', '', $subcategory->image_url);
                Storage::disk('public')->delete($oldImage);
            }
            
            $path = $request->file('image')->store('subcategories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $subcategory->update($validated);

        return redirect()->route('category.subcategory.index', $category)
            ->with('success', 'SubCategory updated successfully.');
    }

    // Delete subcategory
    public function destroy(Category $category, SubCategory $subcategory)
    {
        // Delete image if exists
        if ($subcategory->image_url) {
            $oldImage = str_replace('/storage/', '', $subcategory->image_url);
            Storage::disk('public')->delete($oldImage);
        }

        $subcategory->delete();

        return redirect()->route('category.subcategory.index', $category)
            ->with('success', 'SubCategory deleted successfully.');
    }

    // Toggle status
    public function toggleStatus(Category $category, SubCategory $subcategory)
    {
        $subcategory->status = $subcategory->status === 'active' ? 'inactive' : 'active';
        $subcategory->save();

        return back()->with('success', 'Status updated successfully.');
    }
}
