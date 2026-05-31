{{-- resources/views/admin/contacts/edit.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">

                <h1 class="admin-title">
                    Edit Contact
                </h1>

            </div>

            <div class="admin-card">

                <form action="{{ route('admin.contacts.update', $contact) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-grid">

                        <!-- Address -->
                        <div class="form-group">

                            <label class="form-label">
                                Address *
                            </label>

                            <textarea name="address"
                                      class="form-input"
                                      rows="4"
                                      required>{{ old('address', $contact->address) }}</textarea>

                        </div>

                        <!-- Phone -->
                        <div class="form-group">

                            <label class="form-label">
                                Phone *
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $contact->phone) }}"
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
                                   value="{{ old('email', $contact->email) }}"
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
                                   value="{{ old('location_link', $contact->location_link) }}"
                                   class="form-input">

                        </div>

                        <!-- Whatsapp -->
                        <div class="form-group">

                            <label class="form-label">
                                Whatsapp
                            </label>

                            <input type="text"
                                   name="whatsapp"
                                   value="{{ old('whatsapp', $contact->whatsapp) }}"
                                   class="form-input">

                        </div>

                        <!-- Working Hours -->
                        <div class="form-group">

                            <label class="form-label">
                                Working Hours
                            </label>

                            <input type="text"
                                   name="working_hours"
                                   value="{{ old('working_hours', $contact->working_hours) }}"
                                   class="form-input">

                        </div>

                        <!-- Status -->
                        <div class="form-group">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                    class="form-input">

                                <option value="1"
                                    @selected(old('is_active', $contact->is_active) == 1)>
                                    Active
                                </option>

                                <option value="0"
                                    @selected(old('is_active', $contact->is_active) == 0)>
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
                            Update Contact
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>