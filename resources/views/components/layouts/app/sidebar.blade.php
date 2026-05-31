<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                   
                </flux:navlist.group>
             
                <flux:navlist.group :heading="__('Vendor Management')" class="grid">
                    <flux:navlist.item icon="users" :href="route('admin.vendors')" :current="request()->routeIs('admin.vendors')" wire:navigate>
                        {{ __('Vendors') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="user-group" :href="route('admin.customers.index')" :current="request()->routeIs('admin.customers.index')" wire:navigate>
                        {{ __('Customers') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calendar" :href="route('bookings.index')" :current="request()->routeIs('bookings.index')" wire:navigate>
                        {{ __('Bookings') }}
                    </flux:navlist.item>
                </flux:navlist.group>
    
                <flux:navlist.group :heading="__('Ads')" class="grid">                
                    <flux:navlist.item 
                        icon="photo" 
                        :href="route('admin.sliders.index')" 
                        :current="request()->routeIs('admin.sliders.*')" 
                        wire:navigate
                    >
                        {{ __('Slider') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="map-pin" 
                        :href="route('admin.customers.index')" 
                        :current="request()->routeIs('admin.customers.index')" 
                        wire:navigate
                    >
                        {{ __('Popular grounds') }}
                    </flux:navlist.item>
                        <flux:navlist.group 
                                expandable
                                :expanded="request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.blogs.*')"
                                heading="Blogs"
                            >

                                <!-- Blog Categories -->
                                <flux:navlist.item 
                                    icon="folder" 
                                    :href="route('admin.blog-categories.index')" 
                                    :current="request()->routeIs('admin.blog-categories.*')" 
                                    wire:navigate
                                >
                                    {{ __('Blog Categories') }}
                                </flux:navlist.item>

                                <!-- Blog List -->
                                <flux:navlist.item 
                                    icon="document-text" 
                                    :href="route('admin.blogs.index')" 
                                    :current="request()->routeIs('admin.blogs.*')" 
                                    wire:navigate
                                >
                                    {{ __('All Blogs') }}
                                </flux:navlist.item>

                            </flux:navlist.group>

                        </flux:navlist.group>

                <flux:navlist.group :heading="__('Home')" class="grid">
                  <flux:navlist.item 
                    icon="document-text" 
                    :href="route('admin.headers.index')" 
                    :current="request()->routeIs('admin.headers.*')" 
                    wire:navigate>
                    {{ __('Header') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="bars-3-bottom-left" 
                    :href="route('admin.footers.index')" 
                    :current="request()->routeIs('admin.footers.*')" 
                    wire:navigate>
                    {{ __('Footer') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="shield-check" 
                    :href="route('admin.terms-conditions.index')" 
                    :current="request()->routeIs('admin.terms-conditions.*')" 
                    wire:navigate>
                    {{ __('Terms and Condition') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="lock-closed"  
                    :href="route('admin.privacy-policies.index')" 
                    :current="request()->routeIs('admin.privacy-policies.*')" 
                    wire:navigate>
                    {{ __('Privacy Policy') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="phone" 
                    :href="route('admin.contacts.index')" 
                    :current="request()->routeIs('admin.contacts.*')" 
                    wire:navigate>
                    {{ __('Contact Us') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="question-mark-circle" 
                    :href="route('admin.support.help')" 
                    :current="request()->routeIs('admin.support.*')" 
                    wire:navigate>
                    {{ __('Help & Support') }}
                </flux:navlist.item>
                    
                </flux:navlist.group>

            </flux:navlist>

            

            <flux:spacer />


            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
