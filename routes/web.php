<?php

use App\Http\Controllers\AdmincustomersController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\VendorRegisterController;
use App\Http\Controllers\VendorHandler;
use App\Http\Controllers\Vendor\SettingsController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\AdminHelpController;
use App\Http\Controllers\AdminBookingsController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HelpController;
use App\Models\User;

Route::get('/', function () {
    // Public home page for ground/turf booking
    return view('home');
})->name('home');

Route::get('/dd', function () {
    dd(User::all());
})->name('home');

/**
 * Vendor (ground owner) authentication and dashboard
 */
Route::prefix('vendor')->group(function () {
    Route::get('/register', [VendorRegisterController::class, 'create'])->name('vendor.register.form');
    Route::post('/register', [VendorRegisterController::class, 'store'])->name('vendor.register');
    Route::get('/login', [VendorRegisterController::class, 'login'])->name('vendor.login');
    Route::get('/forgot', [VendorRegisterController::class, 'forgot'])->name('vendor.password.forgot');
    Route::post('/login', [VendorRegisterController::class, 'loginCheck'])->name('vendor.login.submit');
    Route::get('/logout', [VendorRegisterController::class, 'logout'])->name('vendor.logout');

    // Google OAuth routes
    Route::get('/login/google/redirect', [VendorRegisterController::class, 'googleRedirect'])->name('vendor.login.google.redirect');
    Route::get('/login/google/callback', [VendorRegisterController::class, 'googleCallback'])->name('vendor.login.google.callback');

    Route::middleware(['vendorAuth'])->group(function () {
        Route::get('/dashboard', [VendorHandler::class, 'dashboard'])->name('vendor.dashboard');
        Route::get('/turfs', [BookingController::class, 'turfs'])->name('vendor.turfs');
        Route::get('/turf/edit', [VendorRegisterController::class, 'turfEdit'])->name('vendor.turf.edit');
        Route::put('/turf/update', [VendorRegisterController::class, 'turfUpdate'])->name('vendor.turfs.update');
        
        Route::get('/bookings', [BookingController::class, 'index'])->name('vendor.bookings');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('vendor.bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('vendor.bookings.store');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('vendor.bookings.edit');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('vendor.bookings.update');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('vendor.bookings.cancel');
        Route::get('/bookings/statistics', [BookingController::class, 'statistics'])->name('vendor.bookings.statistics');

        Route::get('/help', [HelpController::class, 'help'])->name('vendor.help');
        Route::post('/help/send', [HelpController::class, 'sendMessage'])->name('help.send');
        Route::get('/help/messages', [HelpController::class, 'fetchMessages'])->name('help.messages');
        Route::post('/help/messages/{id}/reaction', [HelpController::class, 'addReaction'])->name('help.reaction.add');
        Route::delete('/help/messages/{id}/reaction', [HelpController::class, 'removeReaction'])->name('help.reaction.remove');
        Route::get('/help/unread-count', [HelpController::class, 'getUnreadCount'])->name('help.unread');

        

        // Vendor settings (profile/password/appearance)
        Route::prefix('settings')->name('vendor.settings.')->group(function () {
            Route::get('/profile', [SettingsController::class, 'profileEdit'])->name('profile.edit');
            Route::put('/profile', [SettingsController::class, 'profileUpdate'])->name('profile.update');
            Route::get('/appearance', [SettingsController::class, 'appearanceEdit'])->name('appearance.edit');
            Route::put('/appearance', [SettingsController::class, 'appearanceUpdate'])->name('appearance.update');
            Route::get('/password', [SettingsController::class, 'passwordEdit'])->name('password.edit');
            Route::put('/password', [SettingsController::class, 'passwordUpdate'])->name('password.update');
        });

        // TODO: Add vendor venue & booking management routes here
    });
});

/**
 * Admin area – manage vendors (and later venues/bookings)
 */

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminHomeController::class, 'dashboard'])->name('dashboard');

        // Vendor management for admin (approve/disable vendors)
        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [VendorController::class, 'index'])->name('index');
            Route::get('/create', [VendorController::class, 'create'])->name('create');
            Route::get('/{vendor}', [VendorController::class, 'show'])->name('show');
            Route::post('/', [VendorController::class, 'store'])->name('store');
            Route::get('/{vendor}/edit', [VendorController::class, 'edit'])->name('edit');
            Route::put('/{vendor}', [VendorController::class, 'update'])->name('update');
            Route::delete('/{vendor}', [VendorController::class, 'destroy'])->name('destroy');
            Route::patch('/{vendor}/toggle-status', [VendorController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::get('vendors', [VendorController::class, 'index'])->name('admin.vendors');
        Route::get('vendor', [VendorController::class, 'create'])->name('admin.vendor.create');
        Route::get('vendor/{vendor}', [VendorController::class, 'show'])->name('admin.vendor.view');
        Route::get('vendor/{vendor}/edit', [VendorController::class, 'edit'])->name('admin.vendor.edit');
        Route::delete('vendor/{vendor}', [VendorController::class, 'destroy'])->name('admin.vendor.delete');  
        
        Route::get('customers', [AdmincustomersController::class, 'index'])->name('admin.customers.index');
        Route::get('customers/{customer}', [AdmincustomersController::class, 'show'])->name('admin.customers.show');
        Route::get('customers/create', [AdmincustomersController::class, 'create'])->name('admin.customers.create');
        Route::post('customers', [AdmincustomersController::class, 'store'])->name('admin.customers.store');
        Route::get('customers/{customer}/edit', [AdmincustomersController::class, 'edit'])->name('admin.customers.edit');
        Route::put('customers/{customer}', [AdmincustomersController::class, 'update'])->name('admin.customers.update');
        Route::delete('customers/{customer}', [AdmincustomersController::class, 'destroy'])->name('admin.customers.destroy');

        Route::get('headers', [HeaderController::class, 'index'])->name('admin.headers.index');
        Route::get('headers/create', [HeaderController::class, 'create'])->name('admin.headers.create');
        Route::post('headers', [HeaderController::class, 'store'])->name('admin.headers.store');
        Route::get('headers/{header}/edit', [HeaderController::class, 'edit'])->name('admin.headers.edit');
        Route::put('headers/{header}', [HeaderController::class, 'update'])->name('admin.headers.update');
        Route::delete('headers/{header}', [HeaderController::class, 'destroy'])->name('admin.headers.destroy');

        Route::get('footers', [FooterController::class, 'index'])->name('admin.footers.index');
        Route::get('footers/create', [FooterController::class, 'create'])->name('admin.footers.create');
        Route::post('footers', [FooterController::class, 'store'])->name('admin.footers.store');
        Route::get('footers/{footer}/edit', [FooterController::class, 'edit'])->name('admin.footers.edit');
        Route::put('footers/{footer}', [FooterController::class, 'update'])->name('admin.footers.update');
        Route::delete('footers/{footer}', [FooterController::class, 'destroy'])->name('admin.footers.destroy');

        Route::get('terms-conditions', [TermsConditionController::class, 'index'])->name('admin.terms-conditions.index');
        Route::get('terms-conditions/create', [TermsConditionController::class, 'create'])->name('admin.terms-conditions.create');
        Route::post('terms-conditions', [TermsConditionController::class, 'store'])->name('admin.terms-conditions.store');
        Route::get('terms-conditions/{termsCondition}/edit', [TermsConditionController::class, 'edit'])->name('admin.terms-conditions.edit');
        Route::put('terms-conditions/{termsCondition}', [TermsConditionController::class, 'update'])->name('admin.terms-conditions.update');
        Route::delete('terms-conditions/{termsCondition}', [TermsConditionController::class, 'destroy'])->name('admin.terms-conditions.destroy');

        Route::get('privacy-policies', [PrivacyPolicyController::class, 'index'])->name('admin.privacy-policies.index');
        Route::get('privacy-policies/create', [PrivacyPolicyController::class, 'create'])->name('admin.privacy-policies.create');
        Route::post('privacy-policies', [PrivacyPolicyController::class, 'store'])->name('admin.privacy-policies.store');
        Route::get('privacy-policies/{privacyPolicy}/edit', [PrivacyPolicyController::class, 'edit'])->name('admin.privacy-policies.edit');
        Route::put('privacy-policies/{privacyPolicy}', [PrivacyPolicyController::class, 'update'])->name('admin.privacy-policies.update');
        Route::delete('privacy-policies/{privacyPolicy}', [PrivacyPolicyController::class, 'destroy'])->name('admin.privacy-policies.destroy');

        Route::get('contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('contacts/create', [ContactController::class, 'create'])->name('admin.contacts.create');
        Route::post('contacts', [ContactController::class, 'store'])->name('admin.contacts.store');
        Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('admin.contacts.edit');
        Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('admin.contacts.update');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

        Route::get('sliders', [SliderController::class, 'index'])->name('admin.sliders.index');
        Route::get('sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create');
        Route::post('sliders', [SliderController::class, 'store'])->name('admin.sliders.store');
        Route::get('sliders/{slider}/edit', [SliderController::class, 'edit'])->name('admin.sliders.edit');
        Route::put('sliders/{slider}', [SliderController::class, 'update'])->name('admin.sliders.update');
        Route::delete('sliders/{slider}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');

        Route::get('/help', [AdminHelpController::class, 'help'])->name('admin.support.help');
        Route::post('/help/send', [AdminHelpController::class, 'sendMessage'])->name('admin.support.help.send');
        Route::get('/help/messages', [AdminHelpController::class, 'fetchMessages'])->name('admin.support.help.messages');
        Route::post('/help/messages/{message}/reaction', [AdminHelpController::class, 'addReaction'])->name('admin.support.help.reaction.add');
        Route::delete('/help/messages/{message}/reaction', [AdminHelpController::class, 'removeReaction'])->name('admin.support.help.reaction.remove');
        Route::get('/help/unread-count', [AdminHelpController::class, 'getUnreadCount'])->name('admin.support.help.unread-count');
        Route::get('/help/{vendor}/unread-count', [AdminHelpController::class, 'getVendorUnreadCount'])->name('admin.support.help.vendor-unread-count');
        
        Route::resource('blog-categories', BlogCategoryController::class, [
            'as' => 'admin'
        ]);
        Route::resource('blogs', BlogController::class, [
            'as' => 'admin'
        ]);

        Route::get('/bookings', [AdminBookingsController::class, 'adminIndex'])->name('bookings.index');
        Route::get('/bookings/create', [AdminBookingsController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [AdminBookingsController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [AdminBookingsController::class, 'show'])->name('bookings.show');
        Route::get('/bookings/{booking}/edit', [AdminBookingsController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [AdminBookingsController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [AdminBookingsController::class, 'destroy'])->name('bookings.destroy');
        
        Route::post('/bookings/{booking}/update-status', [AdminBookingsController::class, 'updateStatus'])->name('bookings.update-status');
        Route::post('/bookings/{booking}/update-payment-status', [AdminBookingsController::class, 'updatePaymentStatus'])->name('bookings.update-payment-status');
        Route::post('/bookings/{booking}/record-payment', [AdminBookingsController::class, 'recordPayment'])->name('bookings.record-payment');
        
        Route::get('/bookings/export/csv', [AdminBookingsController::class, 'export'])->name('bookings.export');        
        });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::prefix('customers')->name('customers.')->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
        
        Route::get('/verify-email', [UserAuthController::class, 'showVerifyEmail'])->name('verify.email');
        Route::post('/verify-email', [UserAuthController::class, 'verifyRegistrationOtp'])->name('verify.email.submit');
        Route::post('/resend-verification-otp', [UserAuthController::class, 'resendVerificationOtp'])->name('resend.verification.otp');
        
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
        
        Route::post('/send-otp', [UserAuthController::class, 'sendOtp'])->name('otp.send');
        Route::post('/verify-otp', [UserAuthController::class, 'verifyOtp'])->name('otp.verify');
        
        Route::get('/login/google', [UserAuthController::class, 'redirectToGoogle'])->name('login.google.redirect');
        Route::get('/login/google/callback', [UserAuthController::class, 'handleGoogleCallback'])->name('login.google.callback');
    });
 
    Route::middleware('auth:web')->group(function () {
        Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    });
});