{{-- resources/views/admin/contacts/create.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">
                <h1 class="admin-title">
                    Add Contact
                </h1>
            </div>

            <div class="admin-card">

                <form action="{{ route('admin.contacts.store') }}"
                      method="POST">

                    @csrf

                    <div class="form-grid">

                        <!-- Address -->
                        <div class="form-group">

                            <label class="form-label">
                                Address *
                            </label>

                            <textarea name="address"
                                      class="form-input"
                                      rows="4"
                                      required>{{ old('address') }}</textarea>

                        </div>

                        <!-- Phone -->
                        <div class="form-group">

                            <label class="form-label">
                                Phone *
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Email -->
                        <div class="form-group">

                            <label class="form-label">
                                Email *
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-input"
                                   required>

                        </div>

                        <!-- Location Link -->
                        <div class="form-group">

                            <label class="form-label">
                                Location Link
                            </label>

                            <input type="url"
                                   name="location_link"
                                   value="{{ old('location_link') }}"
                                   class="form-input">

                        </div>

                        <!-- Whatsapp -->
                        <div class="form-group">

                            <label class="form-label">
                                Whatsapp
                            </label>

                            <input type="text"
                                   name="whatsapp"
                                   value="{{ old('whatsapp') }}"
                                   class="form-input">

                        </div>

                        <!-- Working Hours -->
                        <div class="form-group">

                            <label class="form-label">
                                Working Hours
                            </label>

                            <input type="text"
                                   name="working_hours"
                                   value="{{ old('working_hours') }}"
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

                        <a href="{{ route('admin.contacts.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Create Contact
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>