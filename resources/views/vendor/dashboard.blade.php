@extends('vendor.layouts.app.sidebar')

@section('header')
    <h1 class="text-2xl font-bold">Vendor Dashboard</h1>
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

<div class="admin-container">

    <div class="admin-header">
        <h1 class="admin-title">Dashboard Overview</h1>
    </div>

    <div class="form-grid">

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Total Bookings</h3>
            <div class="text-3xl font-bold mt-3">
                {{ $totalBookings }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Pending Bookings</h3>
            <div class="text-3xl font-bold mt-3 text-yellow-600">
                {{ $pendingBookings }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Completed Bookings</h3>
            <div class="text-3xl font-bold mt-3 text-green-600">
                {{ $completedBookings }}
            </div>
        </div>

        <div class="admin-card">
            <h3 class="text-lg font-semibold">Revenue</h3>
            <div class="text-3xl font-bold mt-3 text-blue-600">
                ₹{{ number_format($totalRevenue, 2) }}
            </div>
        </div>

    </div>

    <div class="admin-card mt-6">
        <h3 class="text-lg font-semibold mb-4">
            Recent Bookings
        </h3>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Booking #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td>{{ $booking->booking_number }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>₹{{ number_format($booking->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No bookings found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection