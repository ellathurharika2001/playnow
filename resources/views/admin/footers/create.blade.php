<x-layouts.app.sidebar>
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <div class="admin-header">
                <h1 class="admin-title">
                    Add New Footer
                </h1>
            </div>

            <div class="admin-card">

                <form action="{{ route('admin.footers.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">Footer Content *</label>

                            <textarea name="footer_content"
                                      class="form-input"
                                      rows="5"
                                      required>{{ old('footer_content') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Footer Logo</label>

                            <input type="file"
                                   name="footer_logo"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone</label>

                            <input type="text"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>

                            <textarea name="address"
                                      class="form-input"
                                      rows="3">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Facebook Link</label>

                            <input type="url"
                                   name="facebook_link"
                                   value="{{ old('facebook_link') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Twitter Link</label>

                            <input type="url"
                                   name="twitter_link"
                                   value="{{ old('twitter_link') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Instagram Link</label>

                            <input type="url"
                                   name="instagram_link"
                                   value="{{ old('instagram_link') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">LinkedIn Link</label>

                            <input type="url"
                                   name="linkedin_link"
                                   value="{{ old('linkedin_link') }}"
                                   class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-actions mt-6">
                        <a href="{{ route('admin.footers.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Create Footer
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>