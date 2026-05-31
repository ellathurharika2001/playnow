{{-- resources/views/admin/bookings/index.blade.php --}}

<x-layouts.app.sidebar :title="__('Admin - Bookings')">
    <flux:main>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">
            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Bookings
                    <span class="text-muted text-sm">({{ $stats['total'] }})</span>
                </h1>

                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    New Booking
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="stats-grid mb-4">
                <div class="stat-card">
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Bookings</div>
                </div>
                <div class="stat-card stat-pending">
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card stat-confirmed">
                    <div class="stat-value">{{ $stats['confirmed'] }}</div>
                    <div class="stat-label">Confirmed</div>
                </div>
                <div class="stat-card stat-completed">
                    <div class="stat-value">{{ $stats['completed'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card stat-cancelled">
                    <div class="stat-value">{{ $stats['cancelled'] }}</div>
                    <div class="stat-label">Cancelled</div>
                </div>
                <div class="stat-card stat-revenue">
                    <div class="stat-value">₹{{ number_format($stats['total_revenue'], 0) }}</div>
                    <div class="stat-label">Revenue</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="admin-card mb-4">
                <form method="GET" action="{{ route('bookings.index') }}" class="filter-form">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-input" 
                                   placeholder="Booking #, Name, Email, Phone" 
                                   value="{{ request('search') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-input">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="no_show" {{ request('status') === 'no_show' ? 'selected' : '' }}>No Show</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-input">
                                <option value="">All Payment Status</option>
                                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Turf / Ground</label>
                            <select name="turf_id" class="form-input">
                                <option value="">All Turfs</option>
                                @foreach($turfs as $turf)
                                    <option value="{{ $turf->id }}" {{ request('turf_id') == $turf->id ? 'selected' : '' }}>
                                        {{ $turf->turf_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-input" 
                                   value="{{ request('from_date') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-input" 
                                   value="{{ request('to_date') }}">
                        </div>

                        <div class="form-group filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1H3zm0 1v10a2 2 0 002 2h10a2 2 0 002-2V4H3zm5 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                Clear
                            </a>
                            <a href="{{ route('bookings.export', request()->query()) }}" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Export CSV
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bookings Table -->
            <div class="admin-card">
                <div class="overflow-x-auto">
                    @if($bookings->count() > 0)
                        <table class="w-full table table-hover align-middle">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>Booking #</th>
                                    <th>Turf</th>
                                    <th>Customer</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold">{{ $booking->booking_number }}</span>
                                        </td>
                                        <td>
                                            <div>{{ $booking->turf->turf_name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $booking->turf->owner_name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <div class="customer-info">
                                                <div class="customer-name">{{ $booking->customer_name }}</div>
                                                <small class="text-muted">{{ $booking->customer_email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                            <small class="text-muted">
                                                {{ $booking->start_time }} - {{ $booking->end_time }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $booking->getStatusBadgeClass() ?? 'badge-secondary' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $booking->getPaymentStatusBadgeClass() ?? 'badge-secondary' }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>₹{{ number_format($booking->total_amount, 2) }}</div>
                                            <small class="text-muted">Paid: ₹{{ number_format($booking->advance_payment, 2) }}</small>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('bookings.show', $booking) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>

                                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                                    <a href="{{ route('bookings.edit', $booking) }}" 
                                                       class="btn btn-sm btn-outline-secondary"
                                                       title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                @if(!in_array($booking->status, ['completed', 'cancelled']))
                                                    <form action="{{ route('bookings.destroy', $booking) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
                            </div>
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-muted mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-muted">No bookings found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }

            .stat-card {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 1.5rem;
                text-align: center;
            }

            .stat-card.stat-pending {
                border-left: 4px solid #fbbf24;
            }

            .stat-card.stat-confirmed {
                border-left: 4px solid #34d399;
            }

            .stat-card.stat-completed {
                border-left: 4px solid #3b82f6;
            }

            .stat-card.stat-cancelled {
                border-left: 4px solid #f87171;
            }

            .stat-card.stat-revenue {
                border-left: 4px solid #6366f1;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 600;
                color: #111827;
            }

            .stat-label {
                font-size: 0.875rem;
                color: #6b7280;
                margin-top: 0.5rem;
            }

            .filter-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                align-items: flex-end;
            }

            .filter-actions {
                display: flex;
                gap: 0.5rem;
            }

            .customer-info {
                display: flex;
                flex-direction: column;
            }

            .customer-name {
                font-weight: 500;
                color: #111827;
            }

            .action-buttons {
                display: flex;
                gap: 0.25rem;
                flex-wrap: wrap;
            }

            .badge {
                display: inline-block;
                padding: 0.35rem 0.65rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .badge-warning {
                background-color: #fef3c7;
                color: #92400e;
            }

            .badge-success {
                background-color: #dcfce7;
                color: #166534;
            }

            .badge-danger {
                background-color: #fee2e2;
                color: #991b1b;
            }

            .badge-info {
                background-color: #dbeafe;
                color: #1e40af;
            }

            .badge-secondary {
                background-color: #e5e7eb;
                color: #374151;
            }

            @media (max-width: 768px) {
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .filter-grid {
                    grid-template-columns: 1fr;
                }

                .filter-actions {
                    flex-direction: column;
                }

                .filter-actions .btn {
                    width: 100%;
                }

                .action-buttons {
                    flex-direction: column;
                }
            }
        </style>
    </flux:main>
</x-layouts.app.sidebar>
