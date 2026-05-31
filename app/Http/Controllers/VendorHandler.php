<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VendorHandler extends Controller
{
    public function dashboard()
    {
        $vendor = Auth::guard('vendor')->user();

        $totalBookings = Booking::where('vendor_id', $vendor->id)->count();

        $todayBookings = Booking::where('vendor_id', $vendor->id)
            ->whereDate('booking_date', today())
            ->count();

        $pendingBookings = Booking::where('vendor_id', $vendor->id)
            ->where('status', 'pending')
            ->count();

        $confirmedBookings = Booking::where('vendor_id', $vendor->id)
            ->where('status', 'confirmed')
            ->count();

        $completedBookings = Booking::where('vendor_id', $vendor->id)
            ->where('status', 'completed')
            ->count();

        $totalRevenue = Booking::where('vendor_id', $vendor->id)
            ->whereIn('payment_status', ['partial', 'paid'])
            ->sum('total_amount');

        $recentBookings = Booking::where('vendor_id', $vendor->id)
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact(
            'totalBookings',
            'todayBookings',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }
    public function bookings(){
        return view('vendor.bookings');
    }
    public function venues(){
        return view('vendor.venues');  
    }
}
