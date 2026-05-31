@extends('vendor.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor-style.css') }}">

<div class="admin-container">
    <div class="admin-header">
        <h1 class="admin-title">{{ $product->name }} - Variants</h1>
        <a href="{{ route('vendor.products.variants.create', $product) }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Add Variant
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="admin-card">
        @if ($variants->count() > 0)
            <table class="table table-hover align-middle">
                <thead class="bg-gray-50">
                    <tr>
                        <th>Image</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Attributes</th>
                        <th>Default</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variants as $variant)
                        <tr>
                            <td>
                                @if ($variant->variant_image)
                                    <img src="{{ $variant->variant_image }}" alt="Variant" class="h-10 w-10 rounded object-cover">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No image</span>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $variant->sku }}</td>
                            <td>₹{{ number_format($variant->price, 2) }}</td>
                            <td>{{ $variant->stock_quantity }}</td>
                            <td>
                                @if ($variant->attributes->count() > 0)
                                    <div class="text-xs">
                                        @foreach ($variant->attributes as $attr)
                                            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $attr->value }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($variant->is_default)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex space-x-2">
                                    <a href="{{ route('vendor.products.variants.edit', [$product, $variant]) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('vendor.products.variants.destroy', [$product, $variant]) }}" method="POST" onsubmit="return confirm('Delete this variant?')" class="inline">
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
                {{ $variants->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 mb-4">No variants yet.</p>
                <a href="{{ route('vendor.products.variants.create', $product) }}" class="text-blue-600 hover:underline">Create your first variant</a>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('vendor.products.index') }}" class="text-blue-600 hover:underline">← Back to Products</a>
    </div>
</div>
@endsection
