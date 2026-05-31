<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Show the vendor profile edit form
     */
    public function profileEdit()
    {
        $vendor = Auth::guard('vendor')->user();
        return view('vendor.settings.profile', compact('vendor'));
    }

    /**
     * Update vendor profile
     */
    public function profileUpdate(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:vendors,email,' . $vendor->id],
            'mobile' => ['required', 'string', 'max:20'],
            'shop_name' => ['nullable', 'string', 'max:255'],
            'shop_address' => ['nullable', 'string', 'max:255'],
            'pincode' => ['nullable', 'string', 'max:10'],
        ]);

        $vendor->update($validated);

        return redirect()->route('vendor.settings.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the vendor appearance edit form
     */
    public function appearanceEdit()
    {
        $vendor = Auth::guard('vendor')->user();
        return view('vendor.settings.appearance', compact('vendor'));
    }

    /**
     * Update vendor appearance preferences
     */
    public function appearanceUpdate(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $validated = $request->validate([
            'theme' => ['required', 'in:light,dark,auto'],
            'language' => ['nullable', 'string', 'max:5'],
        ]);

        // Store theme preference in session or database
        // For now, we'll use session
        session(['vendor_theme' => $validated['theme']]);

        return redirect()->route('vendor.settings.appearance.edit')
            ->with('success', 'Appearance preferences updated successfully!');
    }

    /**
     * Show the vendor password edit form
     */
    public function passwordEdit()
    {
        return view('vendor.settings.password');
    }

    /**
     * Update vendor password
     */
    public function passwordUpdate(Request $request)
    {
        $vendor = Auth::guard('vendor')->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password:vendor'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $vendor->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('vendor.settings.password.edit')
            ->with('success', 'Password updated successfully!');
    }
}
