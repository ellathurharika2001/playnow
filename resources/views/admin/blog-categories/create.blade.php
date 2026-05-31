{{-- resources/views/admin/blog-categories/create.blade.php --}}

<x-layouts.app.sidebar :title="'Create Blog Category'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">

                <h1 class="admin-title">
                    Create Blog Category
                </h1>

                <a href="{{ route('admin.blog-categories.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </div>

            <!-- Errors -->
            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- Card -->
            <div class="admin-card">

                <form action="{{ route('admin.blog-categories.store') }}"
                      method="POST">

                    @csrf

                    <div class="form-grid">

                        <!-- Name -->
                        <div class="form-group">

                            <label class="form-label">
                                Category Name
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-input"
                                   value="{{ old('name') }}"
                                   required>

                        </div>

                        <!-- Slug -->
                        <div class="form-group">

                            <label class="form-label">
                                Slug
                            </label>

                            <input type="text"
                                   name="slug"
                                   class="form-input"
                                   value="{{ old('slug') }}"
                                   required>

                        </div>

                        <!-- Status -->
                        <div class="form-group">

                            <label class="form-label">
                                Active Status
                            </label>

                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   checked>

                        </div>

                    </div>

                    <div class="form-actions">

                        <button type="submit"
                                class="btn btn-primary">

                            Create Category

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>