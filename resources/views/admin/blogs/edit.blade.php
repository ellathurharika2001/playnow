{{-- resources/views/admin/blogs/edit.blade.php --}}

<x-layouts.app.sidebar :title="'Edit Blog'">
    <flux:main>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header flex justify-between items-center">

                <h1 class="admin-title">
                    Edit Blog
                </h1>

                <a href="{{ route('admin.blogs.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </div>

            <div class="admin-card p-6">

                <form action="{{ route('admin.blogs.update', $blog) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Category -->
                        <div>

                            <label class="form-label">
                                Category
                            </label>

                            <select name="blog_category_id"
                                    class="form-control"
                                    required>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}"
                                        {{ $blog->blog_category_id == $category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <!-- Title -->
                        <div>

                            <label class="form-label">
                                Title
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title', $blog->title) }}"
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
                                   value="{{ old('slug', $blog->slug) }}"
                                   required>

                        </div>

                        <!-- Image -->
                        <div>

                            <label class="form-label">
                                Blog Image
                            </label>

                            @if($blog->image)

                                <img src="{{ asset($blog->image) }}"
                                     class="h-20 rounded mb-3">

                            @endif

                            <input type="file"
                                   name="image"
                                   class="form-control">

                        </div>

                        <!-- Content -->
                        <div class="md:col-span-2">

                            <label class="form-label">
                                Content
                            </label>

                            <div id="editor"
                                 style="height: 300px; background: white;">

                                {!! $blog->content !!}

                            </div>

                            <input type="hidden"
                                   name="content"
                                   id="content">

                        </div>

                        <!-- Status -->
                        <div>

                            <label class="form-label d-block">
                                Active Status
                            </label>

                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ $blog->is_active ? 'checked' : '' }}>

                        </div>

                    </div>

                    <div class="mt-6">

                        <button type="submit"
                                class="btn btn-primary">

                            Update Blog

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

    hiddenInput.value = quill.root.innerHTML;

    quill.on('text-change', function () {
        hiddenInput.value = quill.root.innerHTML;
    });

});

</script>

    </flux:main>
</x-layouts.app.sidebar>