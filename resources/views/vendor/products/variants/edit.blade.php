@extends('vendor.layouts.app')

@section('content')
<flux:main>
<link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Edit Variant</h1>
    </div>

    <div class="admin-card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.products.variants.update', [$product, $variant]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">SKU *</label>
                    <input type="text" name="sku" class="form-input"
                        value="{{ $variant->sku }}" required>
                    @error('sku')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Price *</label>
                    <input type="number" name="price" step="0.01" min="0" class="form-input"
                        value="{{ $variant->price }}" required>
                    @error('price')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" min="0" class="form-input"
                        value="{{ $variant->stock_quantity }}" required>
                    @error('stock_quantity')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Weight (kg)</label>
                    <input type="number" name="weight" step="0.01" min="0" class="form-input"
                        value="{{ $variant->weight }}">
                    @error('weight')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Variant Image</label>
                @if ($variant->variant_image)
                    <div class="mb-3">
                        <img src="{{ $variant->variant_image }}" alt="Variant" class="h-32 w-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="variant_image" accept="image/*" class="form-input">
                <small class="text-muted">JPG, PNG, GIF up to 2MB</small>
                @error('variant_image')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Attributes</label>
                @foreach ($attributes as $attribute)
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-2">{{ $attribute->name }}</label>
                        <div class="space-y-2">
                            @foreach ($attribute->values as $value)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="attribute_values[]" value="{{ $value->attribute_value_id }}" 
                                        class="rounded border-gray-300"
                                        {{ $variant->attributes->contains('attribute_value_id', $value->attribute_value_id) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $value->value }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group mt-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_default" value="1" class="rounded border-gray-300"
                        {{ $variant->is_default ? 'checked' : '' }}>
                    <span class="ml-2">Set as default variant</span>
                </label>
            </div>

            <div class="form-action mt-6">
                <button type="submit" class="btn btn-primary">
                    Update Variant
                </button>
                <a href="{{ route('vendor.products.variants.index', $product) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</flux:main>
@endsection
