<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Turf;
use App\Models\Booking;

class AdminHomeController extends Controller
{
    public function headers()
    {
        return view('admin.headers', ['message' => 'This is the admin header management page.']);
    }
public function dashboard()
{
    return view('dashboard', [
        'bookingCount' => Booking::count(),
        'customerCount' => User::count(),
        'vendorCount' => Turf::count(),

        'pendingBookings' => Booking::where('status', 'pending')->count(),
        'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
        'completedBookings' => Booking::where('status', 'completed')->count(),
    ]);
}
}
