<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turf;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    // Show all vendors
    public function index(Request $request)
    {
        $query = Turf::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vendors = $query->latest()->paginate(10);

        // Keep filter value during pagination
        $vendors->appends($request->all());

        return view('admin.vendors.index', compact('vendors'));
    }

    // Show create form
    public function create()
    {
        return view('admin.vendors.form', ['vendor' => new Turf]);
    }

    // Store new vendor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'turf_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:turfs,email',
            'mobile' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/', 'unique:turfs,mobile'],
            'full_address' => 'required|string',
            'area_city' => 'required|string|max:255',
            'google_maps_link' => 'nullable|url|max:255',
            'landmark' => 'nullable|string|max:255',
            'sport_type' => 'required|string|max:255',
            'turf_size' => 'required|string|max:255',
            'indoor_outdoor' => 'nullable|in:indoor,outdoor',
            'price_per_hour' => 'required|numeric|min:0',
            'slot_duration' => 'required|string|max:100',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'registration_date' => 'nullable|date',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:approved,pending,disabled',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
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

        Turf::create($validated);

        return redirect()->route('admin.vendors')
            ->with('success', 'Turf created successfully.');
    }

    // Show edit form
    public function edit(Turf $vendor)
    {
        return view('admin.vendors.form', [
    'vendor' => $vendor,
    'formAction' => route('vendors.update', $vendor),
    'cancelUrl' => route('admin.vendors')
]);
    }

    // Update vendor
    public function update(Request $request, Turf $vendor)
    {
        $validated = $request->validate([
            'turf_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:turfs,email,' . $vendor->id,
            'mobile' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/', 'unique:turfs,mobile,' . $vendor->id],
            'full_address' => 'required|string',
            'area_city' => 'required|string|max:255',
            'google_maps_link' => 'nullable|url|max:255',
            'landmark' => 'nullable|string|max:255',
            'sport_type' => 'required|string|max:255',
            'turf_size' => 'required|string|max:255',
            'indoor_outdoor' => 'nullable|in:indoor,outdoor',
            'price_per_hour' => 'required|numeric|min:0',
            'slot_duration' => 'required|string|max:100',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'registration_date' => 'nullable|date',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:approved,pending,disabled',
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

        return redirect()->route('admin.vendors')
            ->with('success', 'Turf updated successfully.');
    }

    // Delete vendor
    public function destroy(Turf $vendor)
    {
        // Delete shop photo if exists
        if ($vendor->shop_photo) {
            $oldPhoto = str_replace('/storage/', '', $vendor->shop_photo);
            Storage::disk('public')->delete($oldPhoto);
        }

        $vendor->delete();

        return redirect()->route('admin.vendors')
            ->with('success', 'Vendor deleted successfully.');
    }

    // Show full details of a vendor
    public function show(Turf $vendor)
    {
        return view('admin.vendors.show', compact('vendor'));
    } 

    // Toggle vendor status
    public function toggleStatus(Turf $vendor)
    {
        $vendor->status = $vendor->status === 'active' ? 'inactive' : 'active';
        $vendor->save();

        return back()->with('success', 'Vendor status updated successfully.');
    }
}
