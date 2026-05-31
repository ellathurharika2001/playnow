<x-layouts.app.sidebar>
    <flux:main>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">
            @php $isEdit = isset($header) && $header->exists; @endphp

            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Edit Header
                </h1>
            </div>

            <div class="admin-card">
                <form action="{{ route('admin.headers.update', $header) }}"
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

                    <h3 class="text-lg font-semibold mb-4">Website Information</h3>

                    <div class="form-grid">
                        <!-- Website Title -->
                        <div class="form-group">
                            <label class="form-label">Website Title *</label>
                            <input type="text"
                                   name="website_title"
                                   value="{{ old('website_title', $header->website_title) }}"
                                   class="form-input"
                                   required>
                            @error('website_title')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            
                            @if ($header->logo)
                                <div style="margin-bottom: 12px;">
                                    <img src="{{ asset($header->logo) }}" 
                                         alt="Current Logo" 
                                         style="height: 80px; width: auto; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 4px; padding: 8px;">
                                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 4px;">Current logo</p>
                                </div>
                            @endif
                            
                            <input type="file"
                                   name="logo"
                                   class="form-input"
                                   accept="image/*">
                            <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF, SVG (Max: 2MB). Leave empty to keep current logo.</small>
                            @error('logo')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-6">Social Media Links</h3>

                    <div class="form-grid">
                        <!-- Facebook Link -->
                        <div class="form-group">
                            <label class="form-label">Facebook Link</label>
                            <input type="url"
                                   name="facebook_link"
                                   value="{{ old('facebook_link', $header->facebook_link) }}"
                                   class="form-input"
                                   placeholder="https://facebook.com/yourpage">
                            @error('facebook_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Twitter Link -->
                        <div class="form-group">
                            <label class="form-label">Twitter Link</label>
                            <input type="url"
                                   name="twitter_link"
                                   value="{{ old('twitter_link', $header->twitter_link) }}"
                                   class="form-input"
                                   placeholder="https://twitter.com/yourhandle">
                            @error('twitter_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Instagram Link -->
                        <div class="form-group">
                            <label class="form-label">Instagram Link</label>
                            <input type="url"
                                   name="instagram_link"
                                   value="{{ old('instagram_link', $header->instagram_link) }}"
                                   class="form-input"
                                   placeholder="https://instagram.com/yourprofile">
                            @error('instagram_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- LinkedIn Link -->
                        <div class="form-group">
                            <label class="form-label">LinkedIn Link</label>
                            <input type="url"
                                   name="linkedin_link"
                                   value="{{ old('linkedin_link', $header->linkedin_link) }}"
                                   class="form-input"
                                   placeholder="https://linkedin.com/company/yourcompany">
                            @error('linkedin_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- YouTube Link -->
                        <div class="form-group">
                            <label class="form-label">YouTube Link</label>
                            <input type="url"
                                   name="youtube_link"
                                   value="{{ old('youtube_link', $header->youtube_link) }}"
                                   class="form-input"
                                   placeholder="https://youtube.com/yourchannel">
                            @error('youtube_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="is_active" class="form-input">
                                <option value="1" @selected(old('is_active', $header->is_active) == 1)>Active</option>
                                <option value="0" @selected(old('is_active', $header->is_active) == 0)>Inactive</option>
                            </select>
                            @error('is_active')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions mt-6">
                        <a href="{{ route('admin.headers.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Update Header
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>