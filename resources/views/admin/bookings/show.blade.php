{{-- resources/views/admin/bookings/show.blade.php --}}

<x-layouts.app.sidebar :title="__('Booking Details')">
    <flux:main>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <div>
                    <h1 class="admin-title">{{ $booking->booking_number }}</h1>
                    <p class="text-muted mt-2">Booking Details</p>
                </div>

                <div class="header-actions">
                    @if($booking->isEditable())
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Booking
                        </a>
                    @endif

                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Booking Information -->
                    <div class="admin-card mb-4">
                        <h3 class="card-title mb-4">Booking Information</h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Booking Number</span>
                                <span class="info-value">{{ $booking->booking_number }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Venue</span>
                                <span class="info-value">{{ $booking->venue->name ?? 'N/A' }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Booking Date</span>
                                <span class="info-value">{{ $booking->booking_date->format('d M Y') }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Time Slot</span>
                                <span class="info-value">
                                    {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Duration</span>
                                <span class="info-value">{{ $booking->duration_hours }} Hours</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="badge {{ $booking->getStatusBadgeClass() }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="admin-card mb-4">
                        <h3 class="card-title mb-4">Customer Information</h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Customer Name</span>
                                <span class="info-value">{{ $booking->customer_name }}</span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Phone</span>
                                <span class="info-value">
                                    <a href="tel:{{ $booking->customer_phone }}">{{ $booking->customer_phone }}</a>
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value">
                                    <a href="mailto:{{ $booking->customer_email }}">{{ $booking->customer_email }}</a>
                                </span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Associated User</span>
                                <span class="info-value">{{ $booking->user->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    @if($booking->special_requests)
                        <div class="admin-card mb-4">
                            <h3 class="card-title mb-4">Special Requests</h3>
                            <p class="mb-0">{{ $booking->special_requests }}</p>
                        </div>
                    @endif

                    <!-- Admin Notes -->
                    <div class="admin-card mb-4">
                        <h3 class="card-title mb-4">Admin Notes</h3>
                        <p class="mb-0 text-muted">{{ $booking->admin_notes ?? 'No notes added' }}</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Payment Information -->
                    <div class="admin-card mb-4">
                        <h3 class="card-title mb-4">Payment Information</h3>

                        <div class="payment-card">
                            <div class="payment-row">
                                <span class="payment-label">Price per Hour</span>
                                <span class="payment-value">₹{{ number_format($booking->price_per_hour, 2) }}</span>
                            </div>

                            <div class="payment-row">
                                <span class="payment-label">Duration</span>
                                <span class="payment-value">{{ $booking->duration_hours }} hrs</span>
                            </div>

                            <div class="payment-row border-top pt-2 mt-2">
                                <span class="payment-label font-weight-bold">Total Amount</span>
                                <span class="payment-value font-weight-bold">₹{{ number_format($booking->total_amount, 2) }}</span>
                            </div>

                            <div class="payment-row">
                                <span class="payment-label">Advance Paid</span>
                                <span class="payment-value text-success">₹{{ number_format($booking->advance_payment, 2) }}</span>
                            </div>

                            <div class="payment-row">
                                <span class="payment-label">Remaining</span>
                                <span class="payment-value text-danger">₹{{ number_format($booking->remaining_payment, 2) }}</span>
                            </div>

                            <div class="payment-row mt-3">
                                <span class="payment-label">Payment Status</span>
                                <span class="badge {{ $booking->getPaymentStatusBadgeClass() }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                        </div>

                        @if($booking->remaining_payment > 0)
                            <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                Record Payment
                            </button>
                        @endif
                    </div>

                    <!-- Status Management -->
                    <div class="admin-card mb-4">
                        <h3 class="card-title mb-4">Status Management</h3>

                        <form action="{{ route('bookings.update-status', $booking) }}" method="POST" class="mb-3">
                            @csrf
                            <label class="form-label">Booking Status</label>
                            <div class="input-group">
                                <select name="status" class="form-input" required>
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="no_show" {{ $booking->status === 'no_show' ? 'selected' : '' }}>No Show</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-outline-primary">
                                    Update
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('bookings.update-payment-status', $booking) }}" method="POST">
                            @csrf
                            <label class="form-label">Payment Status</label>
                            <div class="input-group">
                                <select name="payment_status" class="form-input" required>
                                    <option value="pending" {{ $booking->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="partial" {{ $booking->payment_status === 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="refunded" {{ $booking->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                <button type="submit" class="btn btn-outline-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Quick Actions -->
                    @if($booking->isCancellable())
                        <div class="admin-card">
                            <h3 class="card-title mb-4">Quick Actions</h3>

                            <form action="{{ route('bookings.destroy', $booking) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Cancel Booking
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Record Payment Modal -->
        <div class="modal fade" id="recordPaymentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Record Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('bookings.record-payment', $booking) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label">Outstanding Amount</label>
                                <input type="text" class="form-input" value="₹{{ number_format($booking->remaining_payment, 2) }}" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Payment Amount *</label>
                                <input type="number" name="amount" class="form-input" 
                                       step="0.01" min="0" max="{{ $booking->remaining_payment }}"
                                       placeholder="Enter amount" required>
                                @error('amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Record Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            .header-actions {
                display: flex;
                gap: 0.5rem;
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            .info-item {
                display: flex;
                flex-direction: column;
            }

            .info-label {
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 0.25rem;
            }

            .info-value {
                font-size: 1rem;
                color: #111827;
                font-weight: 500;
            }

            .card-title {
                font-size: 1.125rem;
                font-weight: 600;
                color: #111827;
            }

            .payment-card {
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 1rem;
            }

            .payment-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
            }

            .payment-label {
                color: #6b7280;
                font-size: 0.875rem;
            }

            .payment-value {
                color: #111827;
                font-weight: 500;
            }

            .input-group {
                display: flex;
                gap: 0.5rem;
            }

            .input-group .form-input {
                flex: 1;
            }

            .input-group .btn {
                white-space: nowrap;
            }

            @media (max-width: 768px) {
                .info-grid {
                    grid-template-columns: 1fr;
                }

                .header-actions {
                    flex-direction: column;
                    margin-top: 1rem;
                }

                .header-actions .btn {
                    width: 100%;
                }
            }
        </style>
    </flux:main>
</x-layouts.app.sidebar>