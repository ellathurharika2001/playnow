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
            <flux:heading level="2" class="mb-1">{{ __('Profile Information') }}</flux:heading>
            <flux:subheading class="mb-6">{{ __('Update your vendor profile information') }}</flux:subheading>

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

            <form action="{{ route('vendor.settings.profile.update') }}" method="POST" class="space-y-6 max-w-lg">
                @csrf
                @method('PUT')

                <!-- Full Name -->
                <flux:fieldset>
                    <flux:label for="full_name">{{ __('Full Name') }}</flux:label>
                    <flux:input 
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="{{ old('full_name', $vendor->full_name) }}"
                        required />
                    @error('full_name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Email -->
                <flux:fieldset>
                    <flux:label for="email">{{ __('Email') }}</flux:label>
                    <flux:input 
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $vendor->email) }}"
                        required />
                    @error('email')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Mobile -->
                <flux:fieldset>
                    <flux:label for="mobile">{{ __('Mobile Number') }}</flux:label>
                    <flux:input 
                        type="text"
                        id="mobile"
                        name="mobile"
                        value="{{ old('mobile', $vendor->mobile) }}"
                        required />
                    @error('mobile')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Shop Name -->
                <flux:fieldset>
                    <flux:label for="shop_name">{{ __('Shop Name') }}</flux:label>
                    <flux:input 
                        type="text"
                        id="shop_name"
                        name="shop_name"
                        value="{{ old('shop_name', $vendor->shop_name) }}" />
                    @error('shop_name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Shop Address -->
                <flux:fieldset>
                    <flux:label for="shop_address">{{ __('Shop Address') }}</flux:label>
                    <flux:textarea 
                        id="shop_address"
                        name="shop_address">{{ old('shop_address', $vendor->shop_address) }}</flux:textarea>
                    @error('shop_address')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Pincode -->
                <flux:fieldset>
                    <flux:label for="pincode">{{ __('Pincode') }}</flux:label>
                    <flux:input 
                        type="text"
                        id="pincode"
                        name="pincode"
                        value="{{ old('pincode', $vendor->pincode) }}" />
                    @error('pincode')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:fieldset>

                <!-- Submit Button -->
                <div class="flex items-center gap-4">
                    <flux:button type="submit" variant="primary">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
@endsection
