@extends('vendor.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor-style.css') }}">

<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">Products</h1>
        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Add Product
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="admin-card">
        @if ($products->count() > 0)
            <table class="table table-hover align-middle">
                <thead class="bg-gray-50">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category / SubCategory</th>
                        <th>Price</th>
                        <th>Variants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                @if ($product->product_image)
                                    <img src="{{ $product->product_image }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No image</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <div>
                                    <span class="font-medium">{{ $product->category->name ?? '—' }}</span>
                                    @if ($product->subcategory)
                                        <div class="text-sm text-gray-600">{{ $product->subcategory->name }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>₹{{ number_format($product->base_price, 2) }}</td>
                            <td>
                                <a href="{{ route('vendor.products.variants.index', $product) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Variants
                                </a>
                            </td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('vendor.products.edit', $product->product_id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('vendor.products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Delete this product?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <tr>
                <td colspan="5" class="text-center py-4">
                    No products found. <a href="{{ route('vendor.products.create') }}" class="text-blue-600 hover:underline">Create one</a>
                </td>
            </tr>
        @endif
    </div>
</div>
@endsection
