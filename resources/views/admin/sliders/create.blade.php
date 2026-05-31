{{-- resources/views/admin/sliders/create.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Add Slider
                </h1>

            </div>

            <div class="admin-card">

                <form action="{{ route('admin.sliders.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="form-grid">

                        <!-- Title -->
                        <div class="form-group">

                            <label class="form-label">
                                Title *
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Image -->
                        <div class="form-group">

                            <label class="form-label">
                                Slider Image *
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Content -->
                        <div class="form-group">

                            <label class="form-label">
                                Content
                            </label>

                            <div id="editor"
                                 style="height: 300px; background: white;">
                                {!! old('content') !!}
                            </div>

                            <input type="hidden"
                                   name="content"
                                   id="content">

                        </div>

                        <!-- Button Text -->
                        <div class="form-group">

                            <label class="form-label">
                                Button Text
                            </label>

                            <input type="text"
                                   name="button_text"
                                   value="{{ old('button_text') }}"
                                   class="form-input">

                        </div>

                        <!-- Button Link -->
                        <div class="form-group">

                            <label class="form-label">
                                Button Link
                            </label>

                            <input type="url"
                                   name="button_link"
                                   value="{{ old('button_link') }}"
                                   class="form-input">

                        </div>

                        <!-- Sort -->
                        <div class="form-group">

                            <label class="form-label">
                                Sort Order
                            </label>

                            <input type="number"
                                   name="sort_order"
                                   value="{{ old('sort_order', 0) }}"
                                   class="form-input">

                        </div>

                        <!-- Status -->
                        <div class="form-group">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-input">

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="form-actions mt-6">

                        <a href="{{ route('admin.sliders.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Create Slider
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