<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">

        <div class="grid gap-4 md:grid-cols-3">

            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-sm text-gray-500">Total Bookings</h3>
                <p class="mt-2 text-4xl font-bold">{{ $bookingCount }}</p>
            </div>

            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-sm text-gray-500">Customers</h3>
                <p class="mt-2 text-4xl font-bold">{{ $customerCount }}</p>
            </div>

            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <h3 class="text-sm text-gray-500">Vendors</h3>
                <p class="mt-2 text-4xl font-bold">{{ $vendorCount }}</p>
            </div>

        </div>

        <div class="grid gap-4 md:grid-cols-3">

            <div class="rounded-xl border border-yellow-200 p-6">
                <h3 class="text-sm text-yellow-600">Pending Bookings</h3>
                <p class="mt-2 text-3xl font-bold">{{ $pendingBookings }}</p>
            </div>

            <div class="rounded-xl border border-blue-200 p-6">
                <h3 class="text-sm text-blue-600">Confirmed Bookings</h3>
                <p class="mt-2 text-3xl font-bold">{{ $confirmedBookings }}</p>
            </div>

            <div class="rounded-xl border border-green-200 p-6">
                <h3 class="text-sm text-green-600">Completed Bookings</h3>
                <p class="mt-2 text-3xl font-bold">{{ $completedBookings }}</p>
            </div>

        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-lg font-semibold mb-4">
                System Overview
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div>
                    <p class="text-sm text-gray-500">Bookings</p>
                    <p class="text-2xl font-bold">{{ $bookingCount }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Customers</p>
                    <p class="text-2xl font-bold">{{ $customerCount }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Vendors</p>
                    <p class="text-2xl font-bold">{{ $vendorCount }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Completion Rate</p>
                    <p class="text-2xl font-bold">
                        {{ $bookingCount > 0 ? round(($completedBookings / $bookingCount) * 100) : 0 }}%
                    </p>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>