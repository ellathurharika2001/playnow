<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    // Show all variants for a vendor product
    public function index(Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        $variants = ProductVariant::where('product_id', $product->product_id)
            ->with('attributes')
            ->paginate(10);
        
        return view('vendor.products.variants.index', compact('product', 'variants'));
    }

    // Show create variant form
    public function create(Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        $attributes = Attribute::with('values')->get();
        return view('vendor.products.variants.create', compact('product', 'attributes'));
    }

    // Store new variant
    public function store(Request $request, Product $product)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'variant_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'nullable|boolean',
            'attribute_values' => 'nullable|array',
        ]);

        // Handle variant image
        if ($request->hasFile('variant_image')) {
            $path = $request->file('variant_image')->store('product_variants', 'public');
            $validated['variant_image'] = Storage::url($path);
        }

        $validated['product_id'] = $product->product_id;
        $validated['is_default'] = $request->has('is_default') ? true : false;

        $variant = ProductVariant::create($validated);

        // Attach attribute values
        // if ($request->has('attribute_values')) {
        //     $variant->attributes()->sync($request->attribute_values);
        // }

        return redirect()->route('vendor.products.variants.index', $product)
            ->with('success', 'Variant created successfully.');
    }

    // Show edit variant form
    public function edit(Product $product, ProductVariant $variant)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        if ($variant->product_id !== $product->product_id) {
            abort(403, 'Unauthorized');
        }

        $attributes = Attribute::where('status', 'active')->with('values')->get();
        return view('vendor.products.variants.edit', compact('product', 'variant', 'attributes'));
    }

    // Update variant
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        if ($variant->product_id !== $product->product_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->product_variant_id . ',product_variant_id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'variant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'nullable|boolean',
            'attribute_values' => 'nullable|array',
        ]);

        // Handle variant image
        if ($request->hasFile('variant_image')) {
            // Delete old image if exists
            if ($variant->variant_image) {
                $imagePath = str_replace('/storage/', '', $variant->variant_image);
                Storage::disk('public')->delete($imagePath);
            }

            $path = $request->file('variant_image')->store('product_variants', 'public');
            $validated['variant_image'] = Storage::url($path);
        }

        $validated['is_default'] = $request->has('is_default') ? true : false;

        $variant->update($validated);

        // Update attribute values
        if ($request->has('attribute_values')) {
            $variant->attributes()->sync($request->attribute_values);
        }

        return redirect()->route('vendor.products.variants.index', $product)
            ->with('success', 'Variant updated successfully.');
    }

    // Delete variant
    public function destroy(Product $product, ProductVariant $variant)
    {
        $vendor = Auth::guard('vendor')->user();
        
        // Check if this product belongs to the vendor
        if ($product->vendor_id !== $vendor->id) {
            abort(403, 'Unauthorized');
        }

        if ($variant->product_id !== $product->product_id) {
            abort(403, 'Unauthorized');
        }

        // Delete variant image if exists
        if ($variant->variant_image) {
            $imagePath = str_replace('/storage/', '', $variant->variant_image);
            Storage::disk('public')->delete($imagePath);
        }

        $variant->delete();

        return redirect()->route('vendor.products.variants.index', $product)
            ->with('success', 'Variant deleted successfully.');
    }
}
