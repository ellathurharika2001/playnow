{{-- resources/views/admin/blog-categories/edit.blade.php --}}

<x-layouts.app.sidebar :title="'Edit Blog Category'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header flex justify-between items-center">

                <h1 class="admin-title">
                    Edit Blog Category
                </h1>

                <a href="{{ route('admin.blog-categories.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </div>

            <!-- Validation Errors -->
            @if ($errors->any())

                <div class="alert alert-danger mb-4">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- Form -->
            <div class="admin-card p-6">

                <form action="{{ route('admin.blog-categories.update', $blogCategory) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Name -->
                        <div>

                            <label class="form-label">
                                Category Name
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $blogCategory->name) }}"
                                   required>

                        </div>

                        <!-- Slug -->
                        <div>

                            <label class="form-label">
                                Slug
                            </label>

                            <input type="text"
                                   name="slug"
                                   class="form-control"
                                   value="{{ old('slug', $blogCategory->slug) }}"
                                   required>

                        </div>

                        <!-- Status -->
                        <div>

                            <label class="form-label d-block">
                                Active Status
                            </label>

                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $blogCategory->is_active) ? 'checked' : '' }}>

                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="mt-6">

                        <button type="submit"
                                class="btn btn-primary">

                            Update Category

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>