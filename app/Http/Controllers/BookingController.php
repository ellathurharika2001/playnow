<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Turf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
   public function index()
    {
        $vendor = Auth::guard('vendor')->user();

        $bookings = Booking::where('vendor_id', $vendor->id)
            ->latest('booking_date')
            ->paginate(15);

        $stats = [
            'total' => Booking::where('vendor_id', $vendor->id)->count(),
            'pending' => Booking::where('vendor_id', $vendor->id)
                ->where('status', 'pending')
                ->count(),
            'confirmed' => Booking::where('vendor_id', $vendor->id)
                ->where('status', 'confirmed')
                ->count(),
            'today' => Booking::where('vendor_id', $vendor->id)
                ->whereDate('booking_date', today())
                ->count(),
        ];

        return view('vendor.bookings', compact(
            'bookings',
            'stats'
        ));
    }

    public function create()
{
    return view('vendor.form');
}

    /**
     * Store a newly created booking.
     */
 public function store(Request $request)
{
    $vendor = Auth::guard('vendor')->user();

    $validated = $request->validate([
        'booking_date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',

        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:20',
        'customer_email' => 'required|email',

        'special_requests' => 'nullable|string|max:1000',
        'admin_notes' => 'nullable|string|max:1000',

        'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',

        'advance_payment' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        $validated['booking_number'] = $this->generateBookingNumber();

        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);

        $durationMinutes = $startTime->diffInMinutes($endTime);
        $durationHours = round($durationMinutes / 60, 2);

        $totalAmount = round(
            $durationHours * $vendor->price_per_hour,
            2
        );

        if ($validated['advance_payment'] > $totalAmount) {
            return back()
                ->withInput()
                ->withErrors([
                    'advance_payment' =>
                        'Advance payment cannot exceed total amount.'
                ]);
        }

        $remainingPayment = $totalAmount - $validated['advance_payment'];

        $paymentStatus = 'pending';

        if ($remainingPayment <= 0) {
            $paymentStatus = 'paid';
        } elseif ($validated['advance_payment'] > 0) {
            $paymentStatus = 'partial';
        }

        $booking = Booking::create([
            'booking_number' => $validated['booking_number'],

            'vendor_id' => $vendor->id,
            'user_id' => null,

            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],

            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],

            'duration_hours' => $durationHours,
            'price_per_hour' => $vendor->price_per_hour,

            'total_amount' => $totalAmount,
            'advance_payment' => $validated['advance_payment'],
            'remaining_payment' => $remainingPayment,

            'special_requests' => $validated['special_requests'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,

            'status' => $validated['status'],
            'payment_status' => $paymentStatus,
        ]);

        DB::commit();

        return redirect()
            ->route('vendor.bookings')
            ->with(
                'success',
                'Booking created successfully! Booking #' . $booking->booking_number
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors([
                'error' => 'Failed to create booking: ' . $e->getMessage()
            ]);
    }
}

    /**
     * Show the form for editing the booking.
     */
public function edit(Booking $booking)
{
    $vendor = Auth::guard('vendor')->user();

    if ($booking->vendor_id != $vendor->id) {
        abort(403, 'Unauthorized');
    }

    return view('vendor.form', compact('booking'));
}

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
{
    $vendor = Auth::guard('vendor')->user();

    if ($booking->vendor_id != $vendor->id) {
        abort(403);
    }

    $validated = $request->validate([
        'booking_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',

        'customer_name' => 'required|string|max:255',
        'customer_phone' => 'required|string|max:20',
        'customer_email' => 'required|email',

        'special_requests' => 'nullable|string|max:1000',
        'admin_notes' => 'nullable|string|max:1000',

        'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',

        'advance_payment' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {

        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validated['end_time']);

        $durationMinutes = $startTime->diffInMinutes($endTime);
        $durationHours = round($durationMinutes / 60, 2);

        $totalAmount = round(
            $durationHours * $booking->price_per_hour,
            2
        );

        if ($validated['advance_payment'] > $totalAmount) {
            return back()
                ->withInput()
                ->withErrors([
                    'advance_payment' =>
                        'Advance payment cannot exceed total amount.'
                ]);
        }

        $remainingPayment = $totalAmount - $validated['advance_payment'];

        $paymentStatus = 'pending';

        if ($remainingPayment <= 0) {
            $paymentStatus = 'paid';
        } elseif ($validated['advance_payment'] > 0) {
            $paymentStatus = 'partial';
        }

        $booking->update([
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],

            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],

            'duration_hours' => $durationHours,

            'total_amount' => $totalAmount,
            'advance_payment' => $validated['advance_payment'],
            'remaining_payment' => $remainingPayment,

            'special_requests' => $validated['special_requests'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,

            'status' => $validated['status'],
            'payment_status' => $paymentStatus,
        ]);

        DB::commit();

        return redirect()
            ->route('vendor.bookings')
            ->with('success', 'Booking updated successfully.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors([
                'error' => 'Failed to update booking: ' . $e->getMessage()
            ]);
    }
}

    /**
     * Cancel the booking.
     */
    public function cancel(Request $request, Booking $booking)
{
    $vendor = Auth::guard('vendor')->user();

    if ($booking->vendor_id != $vendor->id) {
        abort(403);
    }

    $request->validate([
        'cancellation_reason' => 'nullable|string|max:500',
    ]);

    $booking->update([
        'status' => 'cancelled',
        'cancellation_reason' => $request->cancellation_reason,
        'cancelled_at' => now(),
    ]);

    return redirect()
        ->route('vendor.bookings')
        ->with('success', 'Booking cancelled successfully.');
}

    /**
     * Check if a time slot is available.
     */
    private function checkSlotAvailability($venueId, $date, $startTime, $endTime, $excludeBookingId = null)
    {
        $query = Booking::where('venue_id', $venueId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    /**
     * Get booking statistics.
     */
    public function statistics()
    {
        $vendorId = auth()->id();
        $today = now()->toDateString();

        $stats = [
            'today_bookings' => Booking::where('vendor_id', $vendorId)
                ->where('booking_date', $today)
                ->count(),
            
            'pending_bookings' => Booking::where('vendor_id', $vendorId)
                ->where('status', 'pending')
                ->count(),
            
            'total_revenue_month' => Booking::where('vendor_id', $vendorId)
                ->whereMonth('booking_date', now()->month)
                ->whereYear('booking_date', now()->year)
                ->sum('total_amount'),
            
            'upcoming_bookings' => Booking::where('vendor_id', $vendorId)
                ->where('booking_date', '>=', $today)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
        ];

        return response()->json($stats);
    }
    public function turfs()
    {
        $vendor = auth()->guard('vendor')->user();

        return view('vendor.turfs', compact('vendor'));
    }
    public function turfEdit()
    {
        $vendor = auth()->guard('vendor')->user();

        return view('vendor.turfs', compact('vendor'));
    }
    public function turfUpdate(Request $request)
    {
        $vendor = auth()->guard('vendor')->user();

        $validated = $request->validate([
            'turf_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:turfs,email,' . $vendor->id,
            'mobile' => 'required|digits:10|unique:turfs,mobile,' . $vendor->id,
            'full_address' => 'required|string',
            'area_city' => 'required|string|max:255',
            'google_maps_link' => 'nullable|url|max:255',
            'landmark' => 'nullable|string|max:255',
            'sport_type' => 'required|string|max:255',
            'turf_size' => 'required|string|max:255',
            'indoor_outdoor' => 'required',
            'price_per_hour' => 'required|numeric',
            'slot_duration' => 'required',
            'opening_time' => 'required',
            'closing_time' => 'required',
        ]);

        if ($request->hasFile('photos')) {

            $photos = [];
            foreach ($request->file('photos') as $file) {

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('turfs'), $imageName);

                $photos[] = 'turfs/' . $imageName;
            }
            $validated['photos'] = $photos;

        }
        $vendor->update($validated);
        return redirect()->route('vendor.turfs')
            ->with('success', 'Turf updated successfully.');
    }
    private function generateBookingNumber()
{
    do {
        $bookingNumber = 'BK' . now()->format('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
    } while (Booking::where('booking_number', $bookingNumber)->exists());

    return $bookingNumber;
}
}
