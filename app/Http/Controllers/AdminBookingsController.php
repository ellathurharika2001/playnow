<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Turf;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminBookingsController extends Controller
{
    /**
     * Display a listing of all bookings
     */
    public function adminIndex(Request $request)
    {
        $query = Booking::with(['turf', 'user'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        // Filter by turf
        if ($request->filled('turf_id')) {
            $query->where('turf_id', $request->turf_id);
        }

        // Filter by vendor (turf owner)
        if ($request->filled('vendor_id')) {
            $query->where('turf_id', $request->vendor_id);
        }

        // Search by booking number, customer name, email, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15);
        $turfs = Turf::orderBy('turf_name', 'asc')->get();

        // Statistics
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
        ];

        return view('admin.bookings.index', compact('bookings', 'turfs', 'stats'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $turfs = Turf::where('status', 'approved')
            ->orderBy('turf_name', 'asc')
            ->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.bookings.create', compact('turfs', 'users'));
    }

    /**
     * Store a newly created booking in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'turf_id' => 'required|exists:turfs,id',
            'user_id' => 'nullable|exists:users,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'special_requests' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'advance_payment' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get turf details
            $turf = Turf::findOrFail($validated['turf_id']);

            // Generate booking number
            $validated['booking_number'] = $this->generateBookingNumber();

            // Calculate duration and total amount
            $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
            $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
            
            // Handle cases where end time is next day
            if ($endTime->lessThanOrEqualTo($startTime)) {
                $endTime->addDay();
            }
            
            $durationMinutes = $endTime->diffInMinutes($startTime);
            $durationHours = $durationMinutes / 60;

            $remainingPayment = $request->total_amount - $validated['advance_payment'];

            // Validate advance payment doesn't exceed total
            if ($validated['advance_payment'] > $request->total_amount) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'advance_payment' => 'Advance payment cannot exceed total amount.'
                    ]);
            }

            // Determine payment status
            $paymentStatus = 'pending';
            if ($remainingPayment <= 0) {
                $paymentStatus = 'paid';
            } elseif ($validated['advance_payment'] > 0) {
                $paymentStatus = 'partial';
            }

            // Prepare booking data
            $bookingData = [
                'booking_number' => $validated['booking_number'],
                'vendor_id' => $validated['turf_id'],
                'user_id' => $validated['user_id'] ?? null,
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'duration_hours' => $durationHours,
                'price_per_hour' => $turf->price_per_hour,
                'total_amount' => $request->total_amount,
                'advance_payment' => $validated['advance_payment'],
                'remaining_payment' => max(0, $remainingPayment),
                'special_requests' => $validated['special_requests'] ?? null,
                'admin_notes' => $validated['admin_notes'] ?? null,
                'status' => $validated['status'],
                'payment_status' => $paymentStatus,
            ];

            $booking = Booking::create($bookingData);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking created successfully! Booking #' . $booking->booking_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['turf', 'user']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        // Only allow editing if booking is pending or confirmed
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['error' => 'This booking can only be edited if it\'s pending or confirmed.']);
        }

        $booking->load(['turf', 'user']);
        $turfs = Turf::where('status', 'approved')
            ->orderBy('turf_name', 'asc')
            ->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.bookings.create', compact('booking', 'turfs', 'users'));
    }

    /**
     * Update the specified booking in database
     */
    public function update(Request $request, Booking $booking)
    {
        // Only allow editing if booking is pending or confirmed
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['error' => 'This booking can only be edited if it\'s pending or confirmed.']);
        }

        $validated = $request->validate([
            'turf_id' => 'required|exists:turfs,id',
            'user_id' => 'nullable|exists:users,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'special_requests' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'advance_payment' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $turf = Turf::findOrFail($validated['turf_id']);

            // Calculate duration and total amount
            $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
            $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);
            
            // Handle cases where end time is next day
            if ($endTime->lessThanOrEqualTo($startTime)) {
                $endTime->addDay();
            }
            
            $durationMinutes = $endTime->diffInMinutes($startTime);
            $durationHours = $durationMinutes / 60;

            // Calculate total amount
            $totalAmount = $request->total_amount;
            $remainingPayment = $totalAmount - $validated['advance_payment'];

            // Validate advance payment doesn't exceed total
            if ($validated['advance_payment'] > $totalAmount) {
                return back()->withErrors(['advance_payment' => 'Advance payment cannot exceed total amount.']);
            }

            // Determine payment status
            $paymentStatus = 'pending';
            if ($remainingPayment <= 0) {
                $paymentStatus = 'paid';
            } elseif ($validated['advance_payment'] > 0) {
                $paymentStatus = 'partial';
            }

            // Update booking
            $booking->update([
                'turf_id' => $validated['turf_id'],
                'user_id' => $validated['user_id'] ?? null,
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'duration_hours' => $durationHours,
                'price_per_hour' => $turf->price_per_hour,
                'total_amount' => $totalAmount,
                'advance_payment' => $validated['advance_payment'],
                'remaining_payment' => max(0, $remainingPayment),
                'special_requests' => $validated['special_requests'] ?? null,
                'admin_notes' => $validated['admin_notes'] ?? null,
                'status' => $validated['status'],
                'payment_status' => $paymentStatus,
            ]);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update booking: ' . $e->getMessage()]);
        }
    }

    /**
     * Cancel the specified booking
     */
    public function destroy(Booking $booking)
    {
        // Only allow cancelling if not already completed or cancelled
        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return back()->withErrors(['error' => 'This booking cannot be cancelled.']);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
        ]);

        $oldStatus = $booking->status;
        
        if ($validated['status'] === 'cancelled') {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        } else {
            $booking->update(['status' => $validated['status']]);
        }

        $message = "Booking status updated from {$oldStatus} to {$validated['status']}.";
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,partial,paid,refunded',
        ]);

        $oldPaymentStatus = $booking->payment_status;
        $booking->update($validated);

        $message = "Payment status updated from {$oldPaymentStatus} to {$validated['payment_status']}.";

        return redirect()->back()->with('success', $message);
    }

    /**
     * Record additional payment
     */
    public function recordPayment(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $booking->remaining_payment,
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $newAdvancePayment = $booking->advance_payment + $validated['amount'];
            $newRemainingPayment = $booking->total_amount - $newAdvancePayment;

            $paymentStatus = 'pending';
            if ($newRemainingPayment <= 0) {
                $paymentStatus = 'paid';
            } elseif ($newAdvancePayment > 0) {
                $paymentStatus = 'partial';
            }

            $booking->update([
                'advance_payment' => $newAdvancePayment,
                'remaining_payment' => max(0, $newRemainingPayment),
                'payment_status' => $paymentStatus,
                'admin_notes' => ($booking->admin_notes ?? '') . "\n[Payment Update] ₹{$validated['amount']} received. " . ($validated['notes'] ?? ''),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Payment of ₹' . $validated['amount'] . ' recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to record payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Export bookings as CSV
     */
    public function export(Request $request)
    {
        $query = Booking::with(['turf', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        if ($request->filled('turf_id')) {
            $query->where('turf_id', $request->turf_id);
        }

        $bookings = $query->orderBy('booking_date', 'desc')->get();

        $csv = "Booking Number,Turf Name,Owner,Customer Name,Phone,Email,Date,Start Time,End Time,Duration (Hours),Sport Type,Status,Payment Status,Price/Hour,Total Amount,Advance Payment,Remaining Payment\n";

        foreach ($bookings as $booking) {

            $turfName = $booking->turf?->turf_name ?? 'N/A';
            $ownerName = $booking->turf?->owner_name ?? 'N/A';
            $sportType = $booking->turf?->sport_type ?? 'N/A';

            $csv .= "\"{$booking->booking_number}\",";
            $csv .= "\"{$turfName}\",";
            $csv .= "\"{$ownerName}\",";
            $csv .= "\"{$booking->customer_name}\",";
            $csv .= "\"{$booking->customer_phone}\",";
            $csv .= "\"{$booking->customer_email}\",";
            $csv .= "\"{$booking->booking_date}\",";
            $csv .= "\"{$booking->start_time}\",";
            $csv .= "\"{$booking->end_time}\",";
            $csv .= "\"{$booking->duration_hours}\",";
            $csv .= "\"{$sportType}\",";
            $csv .= "\"{$booking->status}\",";
            $csv .= "\"{$booking->payment_status}\",";
            $csv .= "\"{$booking->price_per_hour}\",";
            $csv .= "\"{$booking->total_amount}\",";
            $csv .= "\"{$booking->advance_payment}\",";
            $csv .= "\"{$booking->remaining_payment}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="bookings_' . now()->format('Y-m-d_H-i-s') . '.csv"',
        ]);
    }

    /**
     * Get available time slots for a turf
     */
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'turf_id' => 'required|exists:turfs,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        $turf = Turf::findOrFail($request->turf_id);
        $date = $request->date;

        // Get all bookings for this date
        $bookings = Booking::where('turf_id', $turf->id)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['start_time', 'end_time']);

        // Generate available slots based on opening/closing times
        $slots = $this->generateAvailableSlots(
            $turf->opening_time,
            $turf->closing_time,
            $turf->slot_duration,
            $bookings
        );

        return response()->json([
            'success' => true,
            'slots' => $slots,
        ]);
    }

    /**
     * Generate available time slots
     */
    private function generateAvailableSlots($openingTime, $closingTime, $slotDuration, $bookings)
    {
        $slots = [];
        $current = Carbon::createFromFormat('H:i', $openingTime);
        $closing = Carbon::createFromFormat('H:i', $closingTime);

        while ($current < $closing) {
            $slotEnd = $current->copy()->addMinutes($slotDuration);
            
            if ($slotEnd > $closing) {
                break;
            }

            // Check if slot conflicts with any booking
            $isAvailable = true;
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::createFromFormat('H:i', $booking->start_time);
                $bookingEnd = Carbon::createFromFormat('H:i', $booking->end_time);

                if ($current < $bookingEnd && $slotEnd > $bookingStart) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $slots[] = [
                    'start' => $current->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                    'label' => $current->format('H:i') . ' - ' . $slotEnd->format('H:i'),
                ];
            }

            $current->addMinutes($slotDuration);
        }

        return $slots;
    }

    /**
     * Generate unique booking number
     */
   private function generateBookingNumber()
    {
        do {
            $bookingNumber = 'BK'
                . now()->format('Ymd')
                . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (
            Booking::where('booking_number', $bookingNumber)->exists()
        );

        return $bookingNumber;
    }
}