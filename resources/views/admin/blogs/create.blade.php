{{-- resources/views/admin/blogs/create.blade.php --}}

<x-layouts.app.sidebar :title="'Create Blog'">
    <flux:main>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">

                <h1 class="admin-title">
                    Create Blog
                </h1>

                <a href="{{ route('admin.blogs.index') }}"
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

                <form action="{{ route('admin.blogs.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="form-grid">

                        <!-- Category -->
                        <div class="form-group">

                            <label class="form-label">
                                Category
                            </label>

                            <select name="blog_category_id"
                                    class="form-input"
                                    required>

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}">

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- Title -->
                        <div class="form-group">

                            <label class="form-label">
                                Title
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-input"
                                   value="{{ old('title') }}"
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

                        <!-- Image -->
                        <div class="form-group">

                            <label class="form-label">
                                Blog Image
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-input">

                        </div>

                        <!-- Content -->
                        <div class="form-group" style="grid-column: 1 / -1;">

                            <label class="form-label">
                                Content
                            </label>

                            <div id="editor"
                                 style="height: 300px; background: white;">
                            </div>

                            <input type="hidden"
                                   name="content"
                                   id="content">

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

                            Create Blog

                        </button>

                    </div>

                </form>

            </div>

        </div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const hiddenInput = document.querySelector('#content');

    quill.on('text-change', function () {

        hiddenInput.value = quill.root.innerHTML;

    });

});

</script>

    </flux:main>
</x-layouts.app.sidebar>