<x-layouts.app.sidebar :title="'Customer Details'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <style>
            .customer-profile-card {
                background: #ffffff;
                border-radius: 20px;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            }

            .customer-profile-header {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                padding: 40px 30px;
                color: #fff;
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .customer-avatar {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 32px;
                font-weight: 700;
                color: #fff;
                border: 3px solid rgba(255,255,255,0.3);
            }

            .customer-profile-body {
                padding: 30px;
            }

            .customer-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }

            .customer-info-card {
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 16px;
                padding: 20px;
                transition: 0.3s ease;
            }

            .customer-info-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            }

            .customer-label {
                font-size: 13px;
                font-weight: 600;
                color: #6b7280;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 8px;
            }

            .customer-value {
                font-size: 16px;
                font-weight: 600;
                color: #111827;
                word-break: break-word;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 8px 14px;
                border-radius: 9999px;
                font-size: 13px;
                font-weight: 600;
            }

            .status-success {
                background: #dcfce7;
                color: #166534;
            }

            .status-danger {
                background: #fee2e2;
                color: #991b1b;
            }

            .customer-top-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 24px;
            }

            .customer-back-btn {
                background: #111827;
                color: #fff;
                padding: 10px 18px;
                border-radius: 10px;
                font-weight: 600;
                text-decoration: none;
                transition: 0.3s ease;
            }

            .customer-back-btn:hover {
                background: #1f2937;
                color: #fff;
            }
        </style>

        <div class="admin-container">

            <!-- Top Header -->
            <div class="customer-top-actions">

                <div>
                    <h1 class="admin-title">
                        Customer Details
                    </h1>

                    <p class="text-muted text-sm">
                        Complete customer information overview
                    </p>
                </div>

                <a href="{{ route('admin.customers.index') }}"
                   class="customer-back-btn">
                    ← Back
                </a>

            </div>

            <!-- Main Card -->
            <div class="customer-profile-card">

                <!-- Profile Header -->
                <div class="customer-profile-header">

                    <div class="customer-avatar">
                        {{ strtoupper(substr($customer->name ?? 'U', 0, 1)) }}
                    </div>

                    <div>

                        <h2 class="text-3xl font-bold mb-1">
                            {{ $customer->name ?? 'Unknown Customer' }}
                        </h2>

                        <p class="text-blue-100 text-sm">
                            Customer ID #{{ $customer->id }}
                        </p>

                    </div>

                </div>

                <!-- Profile Body -->
                <div class="customer-profile-body">

                    <div class="customer-grid">

                        <!-- Email -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Email Address
                            </div>

                            <div class="customer-value">
                                {{ $customer->email ?? 'N/A' }}
                            </div>

                        </div>

                        <!-- Mobile -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Mobile Number
                            </div>

                            <div class="customer-value">
                                {{ $customer->mobile ?? 'N/A' }}
                            </div>

                        </div>

                        <!-- Google ID -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Google ID
                            </div>

                            <div class="customer-value">
                                {{ $customer->google_id ?? 'N/A' }}
                            </div>

                        </div>

                        <!-- Email Verification -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Email Verification
                            </div>

                            <div class="customer-value">

                                @if($customer->is_email_verified)

                                    <span class="status-badge status-success">
                                        Verified
                                    </span>

                                @else

                                    <span class="status-badge status-danger">
                                        Not Verified
                                    </span>

                                @endif

                            </div>

                        </div>

                        <!-- Created -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Created At
                            </div>

                            <div class="customer-value">
                                {{ $customer->created_at->format('d M Y h:i A') }}
                            </div>

                        </div>

                        <!-- Updated -->
                        <div class="customer-info-card">

                            <div class="customer-label">
                                Last Updated
                            </div>

                            <div class="customer-value">
                                {{ $customer->updated_at->format('d M Y h:i A') }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>