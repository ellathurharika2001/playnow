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
            <flux:heading level="2" class="mb-1">{{ __('Appearance') }}</flux:heading>
            <flux:subheading class="mb-6">{{ __('Customize your dashboard appearance') }}</flux:subheading>

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

            <form action="{{ route('vendor.settings.appearance.update') }}" method="POST" class="space-y-6 max-w-lg">
                @csrf
                @method('PUT')

                <!-- Theme Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Theme') }}</label>
                    
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <div class="flex items-center h-6">
                                <input id="theme-light" name="theme" type="radio" value="light" {{ session('vendor_theme', 'auto') === 'light' ? 'checked' : '' }} class="h-4 w-4 border-zinc-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </div>
                            <div class="ms-3 text-sm">
                                <label for="theme-light" class="font-medium text-zinc-900 dark:text-zinc-100 cursor-pointer">{{ __('Light') }}</label>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">{{ __('Light theme for better visibility') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-6">
                                <input id="theme-dark" name="theme" type="radio" value="dark" {{ session('vendor_theme', 'auto') === 'dark' ? 'checked' : '' }} class="h-4 w-4 border-zinc-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </div>
                            <div class="ms-3 text-sm">
                                <label for="theme-dark" class="font-medium text-zinc-900 dark:text-zinc-100 cursor-pointer">{{ __('Dark') }}</label>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">{{ __('Dark theme to reduce eye strain') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-6">
                                <input id="theme-auto" name="theme" type="radio" value="auto" {{ session('vendor_theme', 'auto') === 'auto' ? 'checked' : '' }} class="h-4 w-4 border-zinc-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </div>
                            <div class="ms-3 text-sm">
                                <label for="theme-auto" class="font-medium text-zinc-900 dark:text-zinc-100 cursor-pointer">{{ __('Auto') }}</label>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">{{ __('Follow system preferences') }}</p>
                            </div>
                        </div>
                    </div>
                    @error('theme')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language Selection -->
                <flux:fieldset>
                    <flux:label for="language">{{ __('Language') }}</flux:label>
                    <flux:select 
                        id="language"
                        name="language">
                        <option value="">{{ __('Select Language') }}</option>
                        <option value="en" {{ session('vendor_language', 'en') === 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                        <option value="hi" {{ session('vendor_language') === 'hi' ? 'selected' : '' }}>{{ __('Hindi') }}</option>
                        <option value="es" {{ session('vendor_language') === 'es' ? 'selected' : '' }}>{{ __('Spanish') }}</option>
                        <option value="fr" {{ session('vendor_language') === 'fr' ? 'selected' : '' }}>{{ __('French') }}</option>
                    </flux:select>
                    @error('language')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Sidebar Collapse Preference -->
                <div class="flex items-start">
                    <div class="flex items-center h-6">
                        <input id="sidebar-collapsed" name="sidebar_collapsed" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    </div>
                    <div class="ms-3 text-sm">
                        <label for="sidebar-collapsed" class="font-medium text-zinc-900 dark:text-zinc-100 cursor-pointer">{{ __('Collapse sidebar by default') }}</label>
                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">{{ __('Keep the sidebar collapsed when you first open the dashboard') }}</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 pt-4">
                    <flux:button type="submit" variant="primary">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
@endsection
