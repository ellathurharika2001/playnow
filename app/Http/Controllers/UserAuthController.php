<?php

namespace App\Http\Controllers;

use App\Models\customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class UserAuthController extends Controller
{
    // Show registration page
    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('customers.dashboard');
        }
        return view('customers.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'mobile' => 'nullable|string|max:15|unique:customers,mobile',
            'password' => 'required|min:6|confirmed',
        ]);

        // Generate 6-digit OTP for email verification
        $otp = rand(100000, 999999);

        // Create user
        $user = customers::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'is_email_verified' => false,
        ]);

        // Send verification OTP email
        Mail::send('emails.registration-otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify Your Email - ' . config('app.name'));
        });

        // Store user ID in session for verification
        session(['registration_user_id' => $user->id]);

        return redirect()->route('customers.verify.email')
            ->with('success', 'Registration successful! Please check your email for the verification code.');
    }

    // Show email verification page
    public function showVerifyEmail()
    {
        if (!session('registration_user_id')) {
            return redirect()->route('customers.register')
                ->with('error', 'Please register first.');
        }

        return view('customers.verify-email');
    }

    // Verify registration OTP
    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $userId = session('registration_user_id');
        
        if (!$userId) {
            return back()->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $user = customers::find($userId);

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        // Check if OTP is valid and not expired
        if ($user->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Mark email as verified and clear OTP
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'is_email_verified' => true,
        ]);

        // Clear session
        session()->forget('registration_user_id');

        // Login the user
        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customers.dashboard')
            ->with('success', 'Email verified successfully! Welcome to ' . config('app.name'));
    }

    // Resend verification OTP
    public function resendVerificationOtp(Request $request)
    {
        $userId = session('registration_user_id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please register again.',
            ], 400);
        }

        $user = customers::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Resend OTP email
        Mail::send('emails.registration-otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify Your Email - ' . config('app.name'));
        });

        return response()->json([
            'success' => true,
            'message' => 'Verification code resent successfully!',
        ]);
    }

    // Show login page
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('customers.dashboard');
        }
        return view('customers.login');
    }

    // Handle email/password login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('customers.dashboard'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    // Show OTP login page
    public function showOtpLogin()
    {
        return view('customers.otp-login');
    }

    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        $user = customers::where('email', $request->email)->first();

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP with 10 minutes expiry
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP email
        Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Login OTP - ' . config('app.name'));
        });

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email successfully!',
        ]);
    }

    // Verify OTP and login
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = customers::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Check if OTP is valid and not expired
        if ($user->otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Clear OTP after successful verification
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'is_email_verified' => true,
        ]);

        // Login the user
        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customers.dashboard')
            ->with('success', 'Login successful!');
    }

    // Redirect to Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google OAuth callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create user
            $user = customers::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update google_id if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'is_email_verified' => true,
                    ]);
                }
            } else {
                // Create new user
                $user = customers::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(16)), // Random password
                    'is_email_verified' => true,
                ]);
            }

            // Login the user
            Auth::guard('web')->login($user, true);

            return redirect()->route('customers.dashboard')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        } catch (\Exception $e) {
            return redirect()->route('customers.login')
                ->with('error', 'Google login failed. Please try again.');
        }
    }

    // User dashboard
    public function dashboard()
    {
        return view('customers.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customers.login')
            ->with('success', 'You have been logged out successfully.');
    }
}