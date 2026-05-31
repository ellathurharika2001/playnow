@extends('vendor.layouts.app.sidebar')


@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
<style>
    .admin-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.admin-table thead th {
    text-align: left;
    padding: 16px;
    font-weight: 600;
    color: #cbd5e1;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    white-space: nowrap;
}

.admin-table tbody td {
    padding: 18px 16px;
    vertical-align: middle;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.admin-table tbody tr {
    transition: all 0.2s ease;
}

.admin-table tbody tr:hover {
    background: rgba(255,255,255,0.03);
}

.customer-name {
    font-weight: 600;
    display: block;
}

.customer-phone {
    color: #94a3b8;
    font-size: 13px;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: rgba(34,197,94,.15);
    color: #22c55e;
}

.badge-warning {
    background: rgba(251,191,36,.15);
    color: #fbbf24;
}

.badge-danger {
    background: rgba(239,68,68,.15);
    color: #ef4444;
}

.badge-info {
    background: rgba(59,130,246,.15);
    color: #60a5fa;
}

.booking-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.booking-actions .btn {
    min-width: 80px;
    text-align: center;
}

.slot-time {
    font-weight: 500;
    white-space: nowrap;
}

.amount {
    font-weight: 700;
    color: #22c55e;
    white-space: nowrap;
}
    </style>
<div class="admin-container">

    <div class="admin-header">
        <h1 class="admin-title">Booking Management</h1>

        <a href="{{ route('vendor.bookings.create') }}"
        class="btn btn-primary">
            + Add Booking
        </a>
    </div>
    {{-- Statistics --}}
    <div class="form-grid mb-6">

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Total Bookings</h3>
            <div class="text-3xl font-bold mt-2">
                {{ $stats['total'] ?? 0 }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Today's Bookings</h3>
            <div class="text-3xl font-bold mt-2 text-blue-600">
                {{ $stats['today'] ?? 0 }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Pending</h3>
            <div class="text-3xl font-bold mt-2 text-yellow-600">
                {{ $stats['pending'] ?? 0 }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Confirmed</h3>
            <div class="text-3xl font-bold mt-2 text-green-600">
                {{ $stats['confirmed'] ?? 0 }}
            </div>
        </div>

    </div>

    {{-- Filters --}}
    <div class="admin-card mb-6">

        <h3 class="text-lg font-semibold mb-4">
            Filter Bookings
        </h3>

        <form method="GET" action="{{ route('vendor.bookings') }}">

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-input">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Date</label>

                    <input type="date"
                           name="booking_date"
                           value="{{ request('booking_date') }}"
                           class="form-input">
                </div>

            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary">
                    Filter
                </button>
            </div>

        </form>

    </div>

    {{-- Bookings Table --}}
    <div class="admin-card">

        <div class="admin-header">
            <h2 class="admin-title">Booking List</h2>
        </div>

        <div class="table-responsive">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>Booking #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Slot</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                       <tr>

    <td>
        <strong>{{ $booking->booking_number }}</strong>
    </td>

    <td>
        <span class="customer-name">
            {{ $booking->customer_name }}
        </span>

        <span class="customer-phone">
            {{ $booking->customer_phone }}
        </span>
    </td>

    <td>
        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
    </td>

    <td class="slot-time">
        {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
        -
        {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
    </td>

    <td class="amount">
        ₹{{ number_format($booking->total_amount, 2) }}
    </td>

    <td>
        @if($booking->payment_status == 'paid')
            <span class="badge badge-success">Paid</span>
        @elseif($booking->payment_status == 'partial')
            <span class="badge badge-warning">Partial</span>
        @else
            <span class="badge badge-danger">Pending</span>
        @endif
    </td>

    <td>
        @if($booking->status == 'confirmed')
            <span class="badge badge-success">Confirmed</span>
        @elseif($booking->status == 'pending')
            <span class="badge badge-warning">Pending</span>
        @elseif($booking->status == 'completed')
            <span class="badge badge-info">Completed</span>
        @else
            <span class="badge badge-danger">Cancelled</span>
        @endif
    </td>

    <td>
        <div class="booking-actions">

            <a href="{{ route('vendor.bookings.edit', $booking) }}"
               class="btn btn-secondary">
                Edit
            </a>

            <form method="POST"
                  action="{{ route('vendor.bookings.cancel', $booking) }}">
                @csrf

                <button type="submit"
                        class="btn btn-danger">
                    Cancel
                </button>
            </form>

        </div>
    </td>

</tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-8">
                                No bookings found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if(method_exists($bookings, 'links'))
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>

</div>

@endsection