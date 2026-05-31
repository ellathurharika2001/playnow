@extends('vendor.layouts.app.sidebar')

@section('header')
    <h1 class="text-2xl font-bold">
        {{ isset($booking) ? 'Edit Booking' : 'Add Booking' }}
    </h1>
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

<div class="admin-container">

    <div class="admin-header">
        <h1 class="admin-title">
            {{ isset($booking) ? 'Edit Booking' : 'Create Booking' }}
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('error'))
        <div class="alert alert-danger mb-4">
            {{ $errors->first('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Please fix the following errors:</strong>

            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Turf Information --}}
    <div class="admin-card mb-4">

        <h3 class="text-lg font-semibold mb-4">
            Turf Information
        </h3>

        <div class="form-grid">

            <div>
                <strong>Turf Name</strong>
                <p>{{ auth()->guard('vendor')->user()->turf_name }}</p>
            </div>

            <div>
                <strong>Owner</strong>
                <p>{{ auth()->guard('vendor')->user()->owner_name }}</p>
            </div>

            <div>
                <strong>Price / Hour</strong>
                <p>
                    ₹{{ number_format(auth()->guard('vendor')->user()->price_per_hour, 2) }}
                </p>
            </div>

        </div>

    </div>

    <div class="admin-card">

        <form
            action="{{ isset($booking)
                ? route('vendor.bookings.update', $booking)
                : route('vendor.bookings.store') }}"
            method="POST">

            @csrf

            @if(isset($booking))
                @method('PUT')
            @endif

            <h3 class="text-lg font-semibold mb-4">
                Customer Information
            </h3>

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Customer Name *</label>

                    <input type="text"
                           name="customer_name"
                           class="form-input"
                           value="{{ old('customer_name', $booking->customer_name ?? '') }}"
                           required>

                    @error('customer_name')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Phone *</label>

                    <input type="text"
                           name="customer_phone"
                           class="form-input"
                           value="{{ old('customer_phone', $booking->customer_phone ?? '') }}"
                           required>

                    @error('customer_phone')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email *</label>

                    <input type="email"
                           name="customer_email"
                           class="form-input"
                           value="{{ old('customer_email', $booking->customer_email ?? '') }}"
                           required>

                    @error('customer_email')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <h3 class="text-lg font-semibold mb-4 mt-6">
                Booking Details
            </h3>

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Booking Date *</label>

                    <input type="date"
                           name="booking_date"
                           class="form-input"
                           value="{{ old('booking_date',
                                isset($booking)
                                ? \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')
                                : '') }}"
                           required>

                    @error('booking_date')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Start Time *</label>

                    <input type="time"
                           name="start_time"
                           class="form-input"
                           value="{{ old('start_time',
                                isset($booking)
                                ? \Carbon\Carbon::parse($booking->start_time)->format('H:i')
                                : '') }}"
                           required>

                    @error('start_time')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">End Time *</label>

                    <input type="time"
                           name="end_time"
                           class="form-input"
                           value="{{ old('end_time',
                                isset($booking)
                                ? \Carbon\Carbon::parse($booking->end_time)->format('H:i')
                                : '') }}"
                           required>

                    @error('end_time')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <h3 class="text-lg font-semibold mb-4 mt-6">
                Payment Details
            </h3>

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Advance Payment *</label>

                    <input type="number"
                           name="advance_payment"
                           class="form-input"
                           step="0.01"
                           min="0"
                           value="{{ old('advance_payment', $booking->advance_payment ?? 0) }}"
                           required>

                    @error('advance_payment')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status *</label>

                    <select name="status" class="form-input">

                        <option value="pending"
                            @selected(old('status', $booking->status ?? '') == 'pending')>
                            Pending
                        </option>

                        <option value="confirmed"
                            @selected(old('status', $booking->status ?? '') == 'confirmed')>
                            Confirmed
                        </option>

                        <option value="completed"
                            @selected(old('status', $booking->status ?? '') == 'completed')>
                            Completed
                        </option>

                        <option value="cancelled"
                            @selected(old('status', $booking->status ?? '') == 'cancelled')>
                            Cancelled
                        </option>

                        <option value="no_show"
                            @selected(old('status', $booking->status ?? '') == 'no_show')>
                            No Show
                        </option>

                    </select>

                    @error('status')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <h3 class="text-lg font-semibold mb-4 mt-6">
                Additional Information
            </h3>

            <div class="form-group">
                <label class="form-label">
                    Special Requests
                </label>

                <textarea name="special_requests"
                          rows="4"
                          class="form-input">{{ old('special_requests', $booking->special_requests ?? '') }}</textarea>

                @error('special_requests')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label class="form-label">
                    Notes
                </label>

                <textarea name="admin_notes"
                          rows="4"
                          class="form-input">{{ old('admin_notes', $booking->admin_notes ?? '') }}</textarea>

                @error('admin_notes')
                    <small class="text-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions mt-6">

                <a href="{{ route('vendor.bookings') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    {{ isset($booking) ? 'Update Booking' : 'Create Booking' }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection