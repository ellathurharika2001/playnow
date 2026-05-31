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
            @if ($errors->any())
                <flux:alert variant="danger" class="mb-4">
                    <template #title>{{ __('Validation Error') }}</template>
                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </flux:alert>
            @endif

            @if (session('success'))
                <flux:alert variant="success" class="mb-4">
                    <template #title>{{ __('Success') }}</template>
                    {{ session('success') }}
                </flux:alert>
            @endif

            @yield('settings-content')
        </div>
    </div>
@endsection
