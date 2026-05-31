<x-layouts.app.sidebar :title="$title ?? 'Turfs'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Turfs
                    <span class="text-muted text-sm">({{ $vendors->total() }})</span>
                </h1>
                <a href="{{ route('admin.vendor.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Add Turf
                </a>
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
                    <!-- Filter -->
                    <div class="flex justify-end mb-4">
                        <form method="GET" action="{{ route('admin.vendors') }}">
                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="border rounded-lg px-3 py-2">

                                <option value="">All Status</option>

                                <option value="approved"
                                    {{ request('status') == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>

                                <option value="pending"
                                    {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="disabled"
                                    {{ request('status') == 'disabled' ? 'selected' : '' }}>
                                    Disabled
                                </option>
                            </select>
                        </form>
                    </div>
                    <table class="w-full table table-hover align-middle">
                        <thead class="bg-gray-50">
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Turf Name</th>
                            <th>Owner</th>
                            <th>Contact</th>
                            <th>Sport Type</th>
                            <th>Location</th>
                            <th>Price / hr</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vendors as $turf)
                            <tr>
                                <td>{{ $turf->id }}</td>

                               <td>
                                @php
                                    $photos = is_string($turf->photos) ? json_decode($turf->photos, true) : $turf->photos;
                                @endphp
                                @if(!empty($photos) && is_array($photos) && count($photos) > 0)
                                    <img src="{{ asset($photos[0]) }}" alt="{{ $turf->turf_name }}" 
                                        class="h-10 w-10 rounded object-cover">
                                @else
                                    <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No photo</span>
                                    </div>
                                @endif
                            </td>

                                <td>
                                    <strong>{{ $turf->turf_name }}</strong><br>
                                    <small class="text-muted">{{ $turf->turf_size }}</small>
                                </td>

                                <td>
                                    {{ $turf->owner_name }}
                                </td>

                                <td>
                                    {{ $turf->mobile }}<br>
                                    <small class="text-muted">{{ $turf->email }}</small>
                                </td>

                                <td>
                                    {{ $turf->sport_type }}
                                </td>

                                <td>
                                    {{ $turf->area_city }}
                                </td>

                                <td>
                                    ₹{{ number_format($turf->price_per_hour, 2) }}
                                </td>

                                <td>
                                    <form action="" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $turf->status === 'approved' 
                                                ? 'bg-green-100 text-green-800' 
                                                : ($turf->status === 'pending' 
                                                    ? 'bg-yellow-100 text-yellow-800' 
                                                    : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($turf->status) }}
                                        </button>
                                    </form>
                                </td>   

                                <td>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.vendor.view', $turf->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition"
                                            title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.vendor.edit', $turf->id) }}"
                                            class="text-blue-600 hover:text-blue-900 transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.vendor.delete', $turf->id) }}" method="POST" 
                                            onsubmit="return confirm('Delete this turf?')"
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
                                <td colspan="10" class="text-center text-muted py-4">
                                    No turfs found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>


            </div>
        </div>

    </flux:main>
</x-layouts.app.sidebar>