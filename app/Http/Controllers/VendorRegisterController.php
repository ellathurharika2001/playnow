<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Turf;
use Illuminate\Support\Str;

class VendorRegisterController extends Controller
{
    public function create()
    {
        return view('vendor.register');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        // Step 1 - Location Details
        'turf_name'       => 'required|string|max:255',
        'owner_name'      => 'required|string|max:255',
        'mobile'          => 'required|digits:10|unique:turfs,mobile',
        'email'           => 'required|email|unique:turfs,email|max:255',
        'full_address'    => 'required|string',
        'area_city'       => 'required|string|max:255',
        'google_maps_link' => 'required|max:500',
        'landmark'        => 'nullable|string|max:255',

        // Step 2 - Sport & Pricing
        'sport_type'      => 'required|in:Football,Cricket,Multi-sport',
        'turf_size'       => 'required|string|max:50',
        'indoor_outdoor'  => 'required|in:Indoor,Outdoor',
        'price_per_hour'  => 'required|numeric|min:0',
        'slot_duration'   => 'required|integer|min:30',
        'opening_time'    => 'required|date_format:H:i',
        'closing_time'    => 'required|date_format:H:i|after:opening_time',
        'photos'          => 'required|array|min:1|max:5',
        'photos.*'        => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    try {
      
        $photoPaths = [];
        if ($request->hasFile('photos')) {


            foreach ($request->file('photos') as $file) {

                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move(public_path('turfs'), $imageName);

                $photoPaths[] = 'turfs/' . $imageName;
            }

            $validated['photos'] = $photoPaths;
        }

        // Create turf record
        $turf = Turf::create([
            'turf_name'       => $validated['turf_name'],
            'owner_name'      => $validated['owner_name'],
            'mobile'          => $validated['mobile'],
            'email'           => $validated['email'],
            'full_address'    => $validated['full_address'],
            'area_city'       => $validated['area_city'],
            'google_maps_link' => $validated['google_maps_link'],
            'landmark'        => $validated['landmark'] ?? null,

            'sport_type'      => $validated['sport_type'],
            'turf_size'       => $validated['turf_size'],
            'indoor_outdoor'  => $validated['indoor_outdoor'],
            'price_per_hour'  => $validated['price_per_hour'],
            'slot_duration'   => $validated['slot_duration'],
            'opening_time'    => $validated['opening_time'],
            'closing_time'    => $validated['closing_time'],
            'photos'          => json_encode($photoPaths), // store as JSON

            'status'          => 'pending', // default status
            'registration_date' => now(),
        ]);

        // Optional: Send notification to admin or welcome email to owner
        // Mail::to($turf->email)->send(new TurfRegistrationReceived($turf));

        return redirect()->back()
            ->with('success', '🎉 Turf registration submitted successfully! We will review and contact you soon.')
            ->with('turf_id', $turf->id);

    } catch (\Exception $e) {
        \Log::error('Turf registration failed: ' . $e->getMessage());

        return redirect()->back()
            ->with('error', 'Something went wrong. Please try again.')
            ->withInput();
    }
}
public function login(){
    return view('vendor.login');
}
public function forgot(){
    return view('vendor.login');
}
public function loginCheck(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $vendor = Turf::where('email', $request->email)
        ->where('status', 'approved') // Optional: only allow login if approved
        ->first();

    if ($vendor) {
        Auth::guard('vendor')->login($vendor);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Verified successfully!');
    } else {
        return redirect()->back()
            ->with('error', 'Invalid email or password, or account inactive.');
    }
}
   public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }

    public function googleRedirect()
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect'); 
        $scope = 'openid email profile';

        $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => $scope,
        ]);
        
        return redirect($url);
    }

    public function googleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('vendor.login')
                ->with('error', 'Google authentication cancelled.');
        }

        try {
            $code = $request->code;
            $clientId = config('services.google.client_id');
            $clientSecret = config('services.google.client_secret');
            $redirectUri = config('services.google.redirect');

            // Exchange authorization code for access token
            $client = new \GuzzleHttp\Client();
            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                ],
            ]);

            $token = json_decode($response->getBody(), true);
            $accessToken = $token['access_token'] ?? null;

            if (!$accessToken) {
                throw new \Exception('Failed to obtain access token');
            }

            // Get user info from Google
            $userResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]);

            $googleUser = json_decode($userResponse->getBody(), true);

            // Find or create vendor
            $vendor = Turf::firstOrCreate(
                ['email' => $googleUser['email']],
                [
                    'turf_name' => $googleUser['name'] ?? 'Google User',
                    'owner_name' => $googleUser['name'] ?? 'Google User',
                    'email' => $googleUser['email'],
                    'mobile' => '0000000000', // Placeholder - user will update later
                    'full_address' => 'To be updated',
                    'area_city' => 'To be updated',
                    'google_maps_link' => '',
                    'sport_type' => 'Multi-sport',
                    'turf_size' => 'Standard',
                    'indoor_outdoor' => 'Outdoor',
                    'price_per_hour' => 0,
                    'slot_duration' => 60,
                    'opening_time' => '06:00',
                    'closing_time' => '22:00',
                    'photos' => json_encode([]),
                    'status' => 'pending',
                    'registration_date' => now(),
                ]
            );

            // Login vendor
            Auth::guard('vendor')->login($vendor);

            return redirect()->route('vendor.dashboard')
                ->with('success', 'Logged in successfully with Google!');

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());

            return redirect()->route('vendor.login')
                ->with('error', 'Failed to authenticate with Google. Please try again.');
        }
    }

    public function turfEdit()
{
    $vendor = Auth::guard('vendor')->user();

    return view('vendor.turfs', compact('vendor'));
}

public function turfUpdate(Request $request)
{
    $vendor = Auth::guard('vendor')->user();

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
        'status' => 'nullable',
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

    return back()->with('success', 'Turf updated successfully!');
}

}
