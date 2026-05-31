{{-- resources/views/admin/blogs/index.blade.php --}}

<x-layouts.app.sidebar :title="'Blogs'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Blogs
                </h1>

                <a href="{{ route('admin.blogs.create') }}"
                   class="btn btn-primary">
                    Add Blog
                </a>

            </div>

            <div class="admin-card">

                <table class="w-full table table-hover">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($blogs as $blog)

                            <tr>

                                <td>{{ $blog->id }}</td>

                                <td>

                                    @if($blog->image)

                                        <img src="{{ asset($blog->image) }}"
                                             class="h-12 w-20 rounded object-cover">

                                    @endif

                                </td>

                                <td>

                                    <strong>
                                        {{ $blog->title }}
                                    </strong>

                                </td>

                                <td>
                                    {{ $blog->category->name ?? 'N/A' }}
                                </td>

                                <td>

                                    <span class="{{ $blog->is_active ? 'text-green-600' : 'text-red-600' }}">

                                        {{ $blog->is_active ? 'Active' : 'Inactive' }}

                                    </span>

                                </td>

                                <td>

                                    <div class="flex gap-3">

                                        <a href="{{ route('admin.blogs.edit', $blog) }}">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.blogs.destroy', $blog) }}"
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

                                <td colspan="6" class="text-center py-4">
                                    No blogs found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>