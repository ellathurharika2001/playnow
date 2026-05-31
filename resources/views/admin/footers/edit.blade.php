{{-- resources/views/admin/footers/edit.blade.php --}}

<x-layouts.app.sidebar>
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Edit Footer
                </h1>
            </div>

            <div class="admin-card">

                <form action="{{ route('admin.footers.update', $footer) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="list-disc list-inside text-sm text-red-700">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>
                        </div>
                    @endif

                    <div class="form-grid">

                        <!-- Footer Content -->
                        <div class="form-group">
                            <label class="form-label">
                                Footer Content *
                            </label>

                            <textarea name="footer_content"
                                      class="form-input"
                                      rows="5"
                                      required>{{ old('footer_content', $footer->footer_content) }}</textarea>

                            @error('footer_content')
                                <small class="text-error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Footer Logo -->
                        <div class="form-group">
                            <label class="form-label">
                                Footer Logo
                            </label>

                            @if ($footer->footer_logo)

                                <div style="margin-bottom: 12px;">

                                    <img src="{{ asset('storage/' . $footer->footer_logo) }}"
                                         alt="Current Logo"
                                         style="height: 80px; width: auto; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 4px; padding: 8px;">

                                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">
                                        Current footer logo
                                    </p>

                                </div>

                            @endif

                            <input type="file"
                                   name="footer_logo"
                                   class="form-input"
                                   accept="image/*">

                            <small class="text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG (Max: 2MB)
                            </small>

                            @error('footer_logo')
                                <small class="text-error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone', $footer->phone) }}"
                                   class="form-input">

                            @error('phone')
                                <small class="text-error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $footer->email) }}"
                                   class="form-input">

                            @error('email')
                                <small class="text-error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label class="form-label">
                                Address
                            </label>

                            <textarea name="address"
                                      class="form-input"
                                      rows="3">{{ old('address', $footer->address) }}</textarea>

                            @error('address')
                                <small class="text-error">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Facebook -->
                        <div class="form-group">
                            <label class="form-label">
                                Facebook Link
                            </label>

                            <input type="url"
                                   name="facebook_link"
                                   value="{{ old('facebook_link', $footer->facebook_link) }}"
                                   class="form-input">
                        </div>

                        <!-- Twitter -->
                        <div class="form-group">
                            <label class="form-label">
                                Twitter Link
                            </label>

                            <input type="url"
                                   name="twitter_link"
                                   value="{{ old('twitter_link', $footer->twitter_link) }}"
                                   class="form-input">
                        </div>

                        <!-- Instagram -->
                        <div class="form-group">
                            <label class="form-label">
                                Instagram Link
                            </label>

                            <input type="url"
                                   name="instagram_link"
                                   value="{{ old('instagram_link', $footer->instagram_link) }}"
                                   class="form-input">
                        </div>

                        <!-- LinkedIn -->
                        <div class="form-group">
                            <label class="form-label">
                                LinkedIn Link
                            </label>

                            <input type="url"
                                   name="linkedin_link"
                                   value="{{ old('linkedin_link', $footer->linkedin_link) }}"
                                   class="form-input">
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active" class="form-input">

                                <option value="1"
                                    @selected(old('is_active', $footer->is_active) == 1)>
                                    Active
                                </option>

                                <option value="0"
                                    @selected(old('is_active', $footer->is_active) == 0)>
                                    Inactive
                                </option>

                            </select>
                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="form-actions mt-6">

                        <a href="{{ route('admin.footers.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                            Update Footer
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>