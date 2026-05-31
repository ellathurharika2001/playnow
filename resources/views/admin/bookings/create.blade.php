
<x-layouts.app.sidebar :title="isset($booking) ? __('Edit Booking') : __('Create Booking')">
    <flux:main>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    {{ isset($booking) ? 'Edit Booking' : 'Create New Booking' }}
                </h1>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="list-unstyled mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Card -->
            <div class="admin-card">
                <form action="{{ isset($booking) ? route('bookings.update', $booking) : route('bookings.store') }}" 
                      method="POST" 
                      id="bookingForm">
                    @csrf
                    @if(isset($booking))
                        @method('PUT')
                    @endif

                    <div class="form-sections">
                        <!-- Turf & Customer Selection -->
                        <div class="form-section">
                            <h3 class="section-title">Select Turf & Customer</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Turf / Ground <span class="text-danger">*</span></label>
                                    <select name="turf_id" class="form-input" id="turfSelect" required>
                                        <option value="">-- Select Turf --</option>
                                        @foreach($turfs as $turf)
                                            <option value="{{ $turf->id }}" 
                                                    {{ old('turf_id', isset($booking) ? $booking->turf_id : '') == $turf->turf_id ? 'selected' : '' }}>
                                                {{ $turf->turf_name }} ({{ $turf->owner_name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('turf_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Customer (Optional)</label>
                                    <select name="user_id" class="form-input">
                                        <option value="">-- Select Customer --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                    {{ old('user_id', isset($booking) ? $booking->user_id : '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Booking Date & Time -->
                        <div class="form-section">
                            <h3 class="section-title">Booking Date & Time</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Booking Date *</label>
                                    <input type="date" name="booking_date" class="form-input"
                                           value="{{ old('booking_date', isset($booking) ? \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') : '') }}"
                                           required>
                                    @error('booking_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Start Time *</label>
                                    <input type="time"
                                        name="start_time"
                                        class="form-input"
                                        value="{{ old('start_time', isset($booking) ? \Carbon\Carbon::parse($booking->start_time)->format('H:i') : '') }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">End Time *</label>
                                    <input type="time"
                                        name="end_time"
                                        class="form-input"
                                        value="{{ old('end_time', isset($booking) ? \Carbon\Carbon::parse($booking->end_time)->format('H:i') : '') }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Duration (Hours)</label>
                                    <input type="number" id="durationDisplay" name="durationDisplay" class="form-input" 
                                           value="{{ old('duration_hours', isset($booking) ? $booking->duration_hours : '') }}"
                                           step="0.01"
                                           readonly>
                                    <small class="text-muted">Auto-calculated</small>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="form-section">
                            <h3 class="section-title">Customer Information</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Customer Name *</label>
                                    <input type="text" name="customer_name" class="form-input"
                                           value="{{ old('customer_name', $booking->customer_name ?? '') }}"
                                           required>
                                    @error('customer_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Phone *</label>
                                    <input type="tel" name="customer_phone" class="form-input"
                                           value="{{ old('customer_phone', $booking->customer_phone ?? '') }}"
                                           placeholder="10-digit mobile number"
                                           required>
                                    @error('customer_phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="customer_email" class="form-input"
                                           value="{{ old('customer_email', $booking->customer_email ?? '') }}"
                                           required>
                                    @error('customer_email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Payment -->
                        <div class="form-section">
                            <h3 class="section-title">Pricing & Payment</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Price per Hour (₹) *</label>
                                    <input type="number" name="price_per_hour" class="form-input"
                                           id="pricePerHour"
                                           value="{{ old('price_per_hour', $booking->price_per_hour ?? '') }}"
                                           step="0.01" min="0" required>
                                    @error('price_per_hour')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Total Amount (₹)</label>
                                    <input type="number" id="totalAmount" name="total_amount" class="form-input"
                                           value="{{ old('total_amount', isset($booking) ? $booking->total_amount : '') }}"
                                           step="0.01"
                                           readonly>
                                    <small class="text-muted">Auto-calculated</small>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Advance Payment (₹) *</label>
                                    <input type="number" name="advance_payment" class="form-input"
                                           id="advancePayment"
                                           value="{{ old('advance_payment', $booking->advance_payment ?? 0) }}"
                                           step="0.01" min="0" required>
                                    @error('advance_payment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Remaining Amount (₹)</label>
                                    <input type="number" id="remainingAmount" id="remainingAmount" class="form-input"
                                           value="{{ old('remaining_amount', isset($booking) ? $booking->remaining_payment : '') }}"
                                           step="0.01"
                                           readonly>
                                    <small class="text-muted">Auto-calculated</small>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-section">
                            <h3 class="section-title">Status</h3>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Booking Status *</label>
                                    <select name="status" class="form-input" required>
                                        <option value="pending" {{ old('status', $booking->status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ old('status', $booking->status ?? '') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ old('status', $booking->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status', $booking->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="no_show" {{ old('status', $booking->status ?? '') === 'no_show' ? 'selected' : '' }}>No Show</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Payment Status *</label>
                                    <select name="payment_status" class="form-input" required>
                                        <option value="pending" {{ old('payment_status', $booking->payment_status ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="partial" {{ old('payment_status', $booking->payment_status ?? '') === 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="paid" {{ old('payment_status', $booking->payment_status ?? '') === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="refunded" {{ old('payment_status', $booking->payment_status ?? '') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('payment_status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="form-section">
                            <h3 class="section-title">Additional Information</h3>

                            <div class="form-group">
                                <label class="form-label">Special Requests</label>
                                <textarea name="special_requests" class="form-input" rows="3"
                                          placeholder="Any special requests from the customer...">{{ old('special_requests', $booking->special_requests ?? '') }}</textarea>
                                @error('special_requests')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Admin Notes</label>
                                <textarea name="admin_notes" class="form-input" rows="3"
                                          placeholder="Internal notes for admin...">{{ old('admin_notes', $booking->admin_notes ?? '') }}</textarea>
                                @error('admin_notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($booking) ? 'Update Booking' : 'Create Booking' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const startTimeInput = document.querySelector('input[name="start_time"]');
                const endTimeInput = document.querySelector('input[name="end_time"]');
                const priceInput = document.querySelector('#pricePerHour');
                const advancePaymentInput = document.querySelector('#advancePayment');
                const durationDisplay = document.querySelector('#durationDisplay');
                const totalAmountDisplay = document.querySelector('#totalAmount');
                const remainingAmountDisplay = document.querySelector('#remainingAmount');

                function calculateDuration() {
                    if (startTimeInput.value && endTimeInput.value) {
                        const [startHour, startMin] = startTimeInput.value.split(':').map(Number);
                        const [endHour, endMin] = endTimeInput.value.split(':').map(Number);

                        const startTotalMinutes = startHour * 60 + startMin;
                        let endTotalMinutes = endHour * 60 + endMin;

                        // Handle cross-day bookings
                        if (endTotalMinutes <= startTotalMinutes) {
                            endTotalMinutes += 24 * 60;
                        }

                        let duration = (endTotalMinutes - startTotalMinutes) / 60;
                        duration = Math.max(0, duration);

                        durationDisplay.value = duration.toFixed(2);
                        calculateTotal();
                    }
                }

                function calculateTotal() {
                    const duration = parseFloat(durationDisplay.value) || 0;
                    const pricePerHour = parseFloat(priceInput.value) || 0;
                    const totalAmount = duration * pricePerHour;

                    totalAmountDisplay.value = totalAmount.toFixed(2);
                    calculateRemaining();
                }

                function calculateRemaining() {
                    const totalAmount = parseFloat(totalAmountDisplay.value) || 0;
                    const advancePayment = parseFloat(advancePaymentInput.value) || 0;
                    const remaining = Math.max(0, totalAmount - advancePayment);

                    remainingAmountDisplay.value = remaining.toFixed(2);
                }

                // Event listeners
                startTimeInput.addEventListener('change', calculateDuration);
                endTimeInput.addEventListener('change', calculateDuration);
                priceInput.addEventListener('input', calculateTotal);
                advancePaymentInput.addEventListener('input', calculateRemaining);

                // Initial calculation
                calculateDuration();
            });
        </script>

        <style>
            .form-sections {
                display: flex;
                flex-direction: column;
                gap: 2rem;
            }

            .form-section {
                padding-bottom: 2rem;
                border-bottom: 1px solid #e5e7eb;
            }

            .form-section:last-of-type {
                border-bottom: none;
            }

            .section-title {
                font-size: 1.125rem;
                font-weight: 600;
                color: #111827;
                margin-bottom: 1rem;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .form-group {
                display: flex;
                flex-direction: column;
            }

            .form-label {
                font-size: 0.875rem;
                font-weight: 500;
                color: #374151;
                margin-bottom: 0.5rem;
            }

            .form-input {
                padding: 0.625rem 0.875rem;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                font-size: 0.875rem;
                transition: border-color 0.2s;
            }

            .form-input:focus {
                outline: none;
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .form-input:disabled {
                background-color: #f3f4f6;
                color: #9ca3af;
            }

            textarea.form-input {
                resize: vertical;
                font-family: inherit;
            }

            .form-actions {
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid #e5e7eb;
            }

            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }

                .form-actions {
                    flex-direction: column;
                }

                .form-actions .btn {
                    width: 100%;
                }
            }
        </style>
    </flux:main>
</x-layouts.app.sidebar>