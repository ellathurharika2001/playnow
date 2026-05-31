<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show all vendor products
    public function index()
    {
        $vendor = Auth::guard('vendor')->user();
        $products = Product::where('vendor_id', $vendor->id)
            ->with(['category', 'subcategory'])
            ->paginate(10);
        
        return view('vendor.products.index', compact('products'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('vendor.products.form', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:subcategories,subcategory_id',
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

        $validated['vendor_id'] = $vendor->id;
        $validated['is_active'] = true;

        Product::create($validated);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::where('status', 'active')->get();
        return view('vendor.products.form', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'required|exists:subcategories,subcategory_id',
            'name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
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

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        // Delete product image if exists
        if ($product->product_image) {
            $imagePath = str_replace('/storage/', '', $product->product_image);
            Storage::disk('public')->delete($imagePath);
        }

        // Delete all variants and their images
        foreach ($product->variants as $variant) {
            if ($variant->variant_image) {
                $variantImagePath = str_replace('/storage/', '', $variant->variant_image);
                Storage::disk('public')->delete($variantImagePath);
            }
            $variant->delete();
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    // Get subcategories via AJAX
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->get();
        return response()->json($subcategories);
    }
}
