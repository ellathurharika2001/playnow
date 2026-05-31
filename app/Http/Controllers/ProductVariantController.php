<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()->paginate(10);
        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        $attributes = Attribute::where('is_variant_attribute', true)
            ->with('values')
            ->get();

        return view('admin.products.variants.create', compact('product', 'attributes'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric',
            'variant_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'sometimes|boolean',
            'attribute_values' => 'nullable|array',
        ]);

        // Handle variant image
        if ($request->hasFile('variant_image')) {
            $path = $request->file('variant_image')->store('variants', 'public');
            $validated['variant_image'] = Storage::url($path);
        }

        $validated['product_id'] = $product->product_id;
        $validated['is_default'] = $request->has('is_default');

        $variant = ProductVariant::create($validated);

        // Attach attribute values if provided
        $attributeValues = array_filter($validated['attribute_values'] ?? []);
        if (!empty($attributeValues)) {
            $variant->attributes()->attach($attributeValues);
        }

        return redirect()->route('products.variants.index', $product)
            ->with('success', 'Variant added successfully.');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        $attributes = Attribute::where('is_variant_attribute', true)
            ->with('values')
            ->get();
        return view('admin.products.variants.edit', compact('product', 'variant', 'attributes'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:product_variants,sku,' . $variant->variant_id . ',variant_id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric',
            'variant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'sometimes|boolean',
            'attribute_values' => 'nullable|array',
        ]);

        // Handle variant image
        if ($request->hasFile('variant_image')) {
            // Delete old image if exists
            if ($variant->variant_image) {
                $imagePath = str_replace('/storage/', '', $variant->variant_image);
                Storage::disk('public')->delete($imagePath);
            }

            $path = $request->file('variant_image')->store('variants', 'public');
            $validated['variant_image'] = Storage::url($path);
        }

        $validated['is_default'] = $request->has('is_default');

        $variant->update($validated);

        // Update attribute values if provided
        $attributeValues = array_filter($validated['attribute_values'] ?? []);
        $variant->attributes()->sync($attributeValues);

        return redirect()->route('products.variants.index', $product)
            ->with('success', 'Variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        // Delete variant image if exists
        if ($variant->variant_image) {
            $imagePath = str_replace('/storage/', '', $variant->variant_image);
            Storage::disk('public')->delete($imagePath);
        }

        $variant->delete();

        return redirect()->route('products.variants.index', $product)
            ->with('success', 'Variant deleted successfully.');
    }
}
