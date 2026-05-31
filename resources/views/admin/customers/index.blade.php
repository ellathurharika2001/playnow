<x-layouts.app.sidebar :title="$title ?? 'Registered Users'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Registered Users
                    <span class="text-muted text-sm">
                        ({{ $customers->total() }})
                    </span>
                </h1>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Card -->
            <div class="admin-card">

                <div class="overflow-x-auto">
                    <table class="w-full table table-hover align-middle">

                        <thead class="bg-gray-50">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Google ID</th>
                                <th>Email Verified</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($customers as $customer)

                                <tr>

                                    <td>
                                        {{ $customer->id }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $customer->name ?? 'N/A' }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $customer->email ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $customer->mobile ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $customer->google_id ?? 'N/A' }}
                                    </td>

                                    <td>
                                        @if($customer->is_email_verified)
                                            <span class="badge bg-success">
                                                Verified
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Not Verified
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $customer->created_at->format('d M Y') }}
                                    </td>

                                    <td class="flex gap-2">

                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition"
                                            title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" 
                                            onsubmit="return confirm('Delete this Customer?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition"
                                                title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        No registered users found.
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $customers->links() }}
                </div>

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>