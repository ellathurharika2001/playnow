{{-- resources/views/admin/terms-conditions/edit.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Edit Terms & Conditions
                </h1>

            </div>

            <div class="admin-card">

                <form action="{{ route('admin.terms-conditions.update', $termsCondition) }}"
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
                                   value="{{ old('title', $termsCondition->title) }}"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Content -->
<div class="form-group">

    <label class="form-label">
        Content *
    </label>

    <!-- Quill Editor -->
    <div id="editor"
         style="height: 300px; background: white;">

        {!! old('content', $termsCondition->content) !!}

    </div>

    <!-- Hidden Input -->
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
                                    @selected(old('is_active', $termsCondition->is_active) == 1)>
                                    Active
                                </option>

                                <option value="0"
                                    @selected(old('is_active', $termsCondition->is_active) == 0)>
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="form-actions mt-6">

                        <a href="{{ route('admin.terms-conditions.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Update Terms
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

    // Hidden input
    const hiddenInput = document.querySelector('#content');

    // Set old content initially
    hiddenInput.value = quill.root.innerHTML;

    // Update hidden input whenever typing
    quill.on('text-change', function () {
        hiddenInput.value = quill.root.innerHTML;
    });

});
</script>
    </flux:main>
</x-layouts.app.sidebar>