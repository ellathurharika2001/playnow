<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Vendor;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subcategory', 'vendor'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Step 1: Category and Subcategory selection
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.create-step1', compact('categories'));
    }

    // Get subcategories by category (AJAX endpoint)
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();
        return response()->json($subcategories);
    }

    // Step 2: Product details with image
    public function showStep2(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:subcategories,subcategory_id',
        ]);

        $vendors = Vendor::where('status', 'active')->get();
        
        return view('admin.products.create-step2', [
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'vendors' => $vendors,
        ]);
    }

    // Store product from step 2
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:subcategories,subcategory_id',
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle product image
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('products', 'public');
            $validated['product_image'] = Storage::url($path);
        }

        $validated['is_active'] = true;
        $product = Product::create($validated);

        return redirect()->route('products.variants.create', $product)
            ->with('success', 'Product created. Now add variants.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'vendors' => Vendor::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,category_id',
            'subcategory_id' => 'nullable|exists:subcategories,subcategory_id',
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'vendor_id' => 'nullable|exists:vendors,id',
            'base_price' => 'nullable|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle product image
        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            if ($product->product_image) {
                $imagePath = str_replace('/storage/', '', $product->product_image);
                Storage::disk('public')->delete($imagePath);
            }

            $path = $request->file('product_image')->store('products', 'public');
            $validated['product_image'] = Storage::url($path);
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->product_image) {
            $imagePath = str_replace('/storage/', '', $product->product_image);
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
    }
}
