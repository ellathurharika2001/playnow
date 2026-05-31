<x-layouts.app.sidebar :title="$customer->exists ? 'Edit Customer' : 'Create Customer'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <style>

            .customer-form-wrapper {
                max-width: 1100px;
                margin: 0 auto;
            }

            .customer-form-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 24px;
            }

            .customer-page-title {
                font-size: 30px;
                font-weight: 700;
                color: #111827;
                margin-bottom: 4px;
            }

            .customer-page-subtitle {
                color: #6b7280;
                font-size: 14px;
            }

            .customer-back-btn {
                background: #111827;
                color: #fff;
                padding: 10px 18px;
                border-radius: 12px;
                text-decoration: none;
                font-weight: 600;
                transition: 0.3s ease;
            }

            .customer-back-btn:hover {
                background: #1f2937;
                color: #fff;
            }

            .customer-form-card {
                background: #ffffff;
                border-radius: 24px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                box-shadow: 0 10px 35px rgba(0,0,0,0.05);
            }

            .customer-form-banner {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                padding: 32px;
                color: #fff;
            }

            .customer-form-banner h2 {
                font-size: 28px;
                font-weight: 700;
                margin-bottom: 6px;
            }

            .customer-form-banner p {
                color: rgba(255,255,255,0.85);
                font-size: 14px;
            }

            .customer-form-body {
                padding: 32px;
            }

            .customer-form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 24px;
            }

            .customer-form-group {
                display: flex;
                flex-direction: column;
            }

            .customer-form-label {
                font-size: 14px;
                font-weight: 600;
                color: #374151;
                margin-bottom: 10px;
            }

            .customer-form-input {
                width: 100%;
                border: 1px solid #d1d5db;
                border-radius: 14px;
                padding: 14px 16px;
                font-size: 15px;
                transition: 0.3s ease;
                background: #fff;
            }

            .customer-form-input:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
                outline: none;
            }

            .customer-checkbox-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 12px;
            }

            .customer-checkbox {
                width: 18px;
                height: 18px;
                accent-color: #2563eb;
            }

            .customer-submit-section {
                margin-top: 36px;
                display: flex;
                justify-content: flex-end;
            }

            .customer-submit-btn {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                color: #fff;
                border: none;
                padding: 14px 26px;
                border-radius: 14px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: 0.3s ease;
            }

            .customer-submit-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
            }

            .customer-error-box {
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                padding: 18px;
                border-radius: 14px;
                margin-bottom: 24px;
            }

            .customer-error-box ul {
                margin: 0;
                padding-left: 18px;
            }

            .customer-helper-text {
                font-size: 13px;
                color: #6b7280;
                margin-top: 6px;
            }

        </style>

        <div class="admin-container customer-form-wrapper">

            <!-- Header -->
            <div class="customer-form-header">

                <div>

                    <h1 class="customer-page-title">
                        {{ $customer->exists ? 'Edit Customer' : 'Create Customer' }}
                    </h1>

                    <p class="customer-page-subtitle">
                        Manage customer account information and settings
                    </p>

                </div>

                <a href="{{ route('admin.customers.index') }}"
                   class="customer-back-btn">
                    ← Back
                </a>

            </div>

            <!-- Errors -->
            @if ($errors->any())

                <div class="customer-error-box">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- Form Card -->
            <div class="customer-form-card">

                <!-- Top Banner -->
                <div class="customer-form-banner">

                    <h2>
                        {{ $customer->exists ? 'Update Customer' : 'New Customer Registration' }}
                    </h2>

                    <p>
                        Fill all required customer details carefully
                    </p>

                </div>

                <!-- Form -->
                <div class="customer-form-body">

                    <form method="POST"
                          action="{{ $customer->exists
                                ? route('admin.customers.update', $customer->id)
                                : route('admin.customers.store') }}">

                        @csrf

                        @if($customer->exists)
                            @method('PUT')
                        @endif

                        <div class="customer-form-grid">

                            <!-- Name -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Full Name
                                </label>

                                <input type="text"
                                       name="name"
                                       class="customer-form-input"
                                       placeholder="Enter customer name"
                                       value="{{ old('name', $customer->name) }}">

                            </div>

                            <!-- Email -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Email Address
                                </label>

                                <input type="email"
                                       name="email"
                                       class="customer-form-input"
                                       placeholder="Enter email address"
                                       value="{{ old('email', $customer->email) }}">

                            </div>

                            <!-- Mobile -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Mobile Number
                                </label>

                                <input type="text"
                                       name="mobile"
                                       class="customer-form-input"
                                       placeholder="Enter mobile number"
                                       value="{{ old('mobile', $customer->mobile) }}">

                            </div>

                            <!-- Password -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Password
                                </label>

                                <input type="password"
                                       name="password"
                                       class="customer-form-input"
                                       placeholder="Enter password">

                                @if($customer->exists)

                                    <small class="customer-helper-text">
                                        Leave blank to keep existing password
                                    </small>

                                @endif

                            </div>

                            <!-- Google ID -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Google ID
                                </label>

                                <input type="text"
                                       name="google_id"
                                       class="customer-form-input"
                                       placeholder="Google account ID"
                                       value="{{ old('google_id', $customer->google_id) }}">

                            </div>

                            <!-- Verification -->
                            <div class="customer-form-group">

                                <label class="customer-form-label">
                                    Verification Status
                                </label>

                                <div class="customer-checkbox-wrapper">

                                    <input type="checkbox"
                                           name="is_email_verified"
                                           value="1"
                                           class="customer-checkbox"
                                           {{ old('is_email_verified', $customer->is_email_verified) ? 'checked' : '' }}>

                                    <span>
                                        Mark email as verified
                                    </span>

                                </div>

                            </div>

                        </div>

                        <!-- Submit -->
                        <div class="customer-submit-section">

                            <button type="submit"
                                    class="customer-submit-btn">

                                {{ $customer->exists ? 'Update Customer' : 'Create Customer' }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>