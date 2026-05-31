@extends('vendor.layouts.app.sidebar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor-style.css') }}">

<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h1>
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

        <form action="{{ isset($product) ? route('vendor.products.update', $product->product_id) : route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select id="category_id" name="category_id" class="form-input" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}" 
                                {{ (isset($product) && $product->category_id == $category->category_id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sub Category *</label>
                    <select id="subcategory_id" name="subcategory_id" class="form-input" required>
                        <option value="">Select Sub Category</option>
                        @if (isset($product) && $product->subcategory)
                            <option value="{{ $product->subcategory->subcategory_id }}" selected>
                                {{ $product->subcategory->name }}
                            </option>
                        @endif
                    </select>
                    @error('subcategory_id')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" id="name" name="name" class="form-input" 
                        value="{{ isset($product) ? $product->name : old('name') }}" required>
                    @error('name')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Base Price *</label>
                    <input type="number" id="base_price" name="base_price" step="0.01" class="form-input" 
                        value="{{ isset($product) ? $product->base_price : old('base_price') }}" required>
                    @error('base_price')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Description</label>
                <textarea id="description" name="description" rows="3" class="form-input">{{ isset($product) ? $product->description : old('description') }}</textarea>
                @error('description')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Product Image {{ !isset($product) ? '*' : '' }}</label>
                @if (isset($product) && $product->product_image)
                    <div class="mb-3">
                        <img src="{{ $product->product_image }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" id="product_image" name="product_image" accept="image/*" class="form-input" {{ !isset($product) ? 'required' : '' }}>
                <small class="text-muted">JPG, PNG, GIF up to 2MB</small>
                @error('product_image')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-action mt-6">
                <button type="submit" class="btn btn-primary">
                    {{ isset($product) ? 'Update Product' : 'Create Product' }}
                </button>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('category_id').addEventListener('change', async (e) => {
        const categoryId = e.target.value;
        if (!categoryId) {
            document.getElementById('subcategory_id').innerHTML = '<option value="">Select Sub Category</option>';
            return;
        }

        try {
            const response = await fetch(`{{ url('vendor/products/get-subcategories') }}/${categoryId}`);
            const subcategories = await response.json();
            
            let options = '<option value="">Select Sub Category</option>';
            subcategories.forEach(sub => {
                options += `<option value="${sub.subcategory_id}">${sub.name}</option>`;
            });
            
            document.getElementById('subcategory_id').innerHTML = options;
        } catch (error) {
            console.error('Error fetching subcategories:', error);
        }
    });
</script>
@endsection
