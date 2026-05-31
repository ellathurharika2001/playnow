@extends('vendor.layouts.app')

@section('header')
    <flux:heading>{{ __('Settings') }}</flux:heading>
@endsection

@section('content')
    <div class="flex items-start max-md:flex-col gap-8">
        <!-- Settings Navigation -->
        <div class="w-full md:w-[220px] pb-4">
            <flux:navlist>
                <flux:navlist.item 
                    :href="route('vendor.settings.profile.edit')"
                    :current="request()->routeIs('vendor.settings.profile.*')">
                    {{ __('Profile') }}
                </flux:navlist.item>
                <flux:navlist.item 
                    :href="route('vendor.settings.appearance.edit')"
                    :current="request()->routeIs('vendor.settings.appearance.*')">
                    {{ __('Appearance') }}
                </flux:navlist.item>
                <flux:navlist.item 
                    :href="route('vendor.settings.password.edit')"
                    :current="request()->routeIs('vendor.settings.password.*')">
                    {{ __('Password') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <!-- Settings Content -->
        <div class="flex-1 self-stretch max-md:pt-6 w-full">
            <flux:heading level="2" class="mb-1">{{ __('Update Password') }}</flux:heading>
            <flux:subheading class="mb-6">{{ __('Ensure your account is using a long, random password to stay secure') }}</flux:subheading>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">{{ __('Validation Error') }}</h3>
                    <ul class="list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="font-semibold text-green-800 dark:text-green-200">{{ __('Success') }}</p>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('vendor.settings.password.update') }}" method="POST" class="space-y-6 max-w-lg">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <flux:fieldset>
                    <flux:label for="current_password">{{ __('Current Password') }}</flux:label>
                    <flux:input 
                        type="password"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                        required />
                    @error('current_password')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- New Password -->
                <flux:fieldset>
                    <flux:label for="password">{{ __('New Password') }}</flux:label>
                    <flux:input 
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        required />
                    <flux:description class="mt-2">
                        {{ __('Must be at least 8 characters long and contain uppercase, lowercase, and numbers') }}
                    </flux:description>
                    @error('password')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Confirm Password -->
                <flux:fieldset>
                    <flux:label for="password_confirmation">{{ __('Confirm Password') }}</flux:label>
                    <flux:input 
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required />
                    @error('password_confirmation')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Password Requirements -->
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg text-sm">
                    <p class="font-semibold text-blue-900 dark:text-blue-200 mb-2">{{ __('Password Requirements') }}</p>
                    <ul class="list-inside list-disc space-y-1 text-xs text-blue-800 dark:text-blue-300">
                        <li>{{ __('At least 8 characters') }}</li>
                        <li>{{ __('At least one uppercase letter') }}</li>
                        <li>{{ __('At least one lowercase letter') }}</li>
                        <li>{{ __('At least one number') }}</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <flux:button type="submit" variant="primary">
                        {{ __('Update Password') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
@endsection
