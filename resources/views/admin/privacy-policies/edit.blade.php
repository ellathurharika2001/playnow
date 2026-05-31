{{-- resources/views/admin/privacy-policies/edit.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Edit Privacy Policy
                </h1>

            </div>

            <div class="admin-card">

                <form action="{{ route('admin.privacy-policies.update', $privacyPolicy) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-grid">

                        <!-- Title -->
                        <div class="form-group">

                            <label class="form-label">
                                Title *
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $privacyPolicy->title) }}"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Content -->
                        <div class="form-group">

                            <label class="form-label">
                                Content *
                            </label>

                            <div id="editor"
                                 style="height: 300px; background: white;">

                                {!! old('content', $privacyPolicy->content) !!}

                            </div>

                            <input type="hidden"
                                   name="content"
                                   id="content">

                        </div>

                        <!-- Status -->
                        <div class="form-group">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-input">

                                <option value="1"
                                    @selected(old('is_active', $privacyPolicy->is_active) == 1)>
                                    Active
                                </option>

                                <option value="0"
                                    @selected(old('is_active', $privacyPolicy->is_active) == 0)>
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="form-actions mt-6">

                        <a href="{{ route('admin.privacy-policies.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Update Privacy Policy
                        </button>

                    </div>

                </form>

            </div>

        </div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Write content here...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                ['blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
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