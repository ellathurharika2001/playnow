{{-- resources/views/admin/blog-categories/index.blade.php --}}

<x-layouts.app.sidebar :title="'Blog Categories'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Blog Categories
                </h1>

                <a href="{{ route('admin.blog-categories.create') }}"
                   class="btn btn-primary">
                    Add Category
                </a>

            </div>

            <div class="admin-card">

                <table class="w-full table table-hover">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                            <tr>

                                <td>{{ $category->id }}</td>

                                <td>{{ $category->name }}</td>

                                <td>{{ $category->slug }}</td>

                                <td>

                                    <span class="{{ $category->is_active ? 'text-green-600' : 'text-red-600' }}">

                                        {{ $category->is_active ? 'Active' : 'Inactive' }}

                                    </span>

                                </td>

                                <td>

                                    <div class="flex gap-3">

                                        <a href="{{ route('admin.blog-categories.edit', $category) }}">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.blog-categories.destroy', $category) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-4">
                                    No categories found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>