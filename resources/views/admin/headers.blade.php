<x-layouts.app.sidebar :title="__('Admin - Header Management')">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header flex justify-between items-center">
                <h1 class="admin-title">
                </h1>

                <a href="{{ route('admin.customers.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="admin-card p-6">

                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Name -->
                        <div>
                            <label class="form-label">Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   >
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="form-label">Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   >
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label class="form-label">Mobile</label>

                            <input type="text"
                                   name="mobile"
                                   class="form-control"
                                   >
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="form-label">
                                Password
                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control">

                        </div>

                        <!-- Google ID -->
                        <div>
                            <label class="form-label">Google ID</label>

                            <input type="text"
                                   name="google_id"
                                   class="form-control">
                        </div>

                        <!-- Verification -->
                        <div>
                            <label class="form-label d-block">
                                Email Verified
                            </label>

                            <input type="checkbox"
                                   name="is_email_verified"
                                   value="1">                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="mt-6">
                        <button type="submit"
                                class="btn btn-primary">


                        </button>
                    </div>

                </form>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>