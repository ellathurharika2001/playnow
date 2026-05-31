<x-layouts.app.sidebar :title="__('Admin - Header Management')">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">
                <h1 class="admin-title">
                    Header Management
                    <span class="text-muted text-sm">
                        ({{ $headers->total() }})
                    </span>
                </h1>

                <a href="{{ route('admin.headers.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 mr-2"
                         viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z"
                              clip-rule="evenodd" />
                    </svg>
                    Add New Header
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
                    <table class="w-full table table-hover align-middle">

                        <thead class="bg-gray-50">
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Website Title</th>
                                <th>Social Links</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($headers as $header)
                                <tr>

                                    <td>{{ $header->id }}</td>

                                    <!-- Logo -->
                                    <td>
                                        @if ($header->logo)
                                            <img src="{{ asset($header->logo) }}"
                                                 alt="Logo"
                                                 class="h-10 w-10 rounded object-cover">
                                        @else
                                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">
                                                    No Logo
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Website Title -->
                                    <td>
                                        <strong>{{ $header->website_title }}</strong>
                                    </td>

                                    <!-- Social Links -->
                                    <td>
                                        <div class="flex flex-wrap gap-2">

                                            @if ($header->facebook_link)
                                                <a href="{{ $header->facebook_link }}"
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    FB
                                                </a>
                                            @endif

                                            @if ($header->twitter_link)
                                                <a href="{{ $header->twitter_link }}"
                                                   target="_blank"
                                                   class="text-sky-500 hover:text-sky-700 text-sm">
                                                    TW
                                                </a>
                                            @endif

                                            @if ($header->instagram_link)
                                                <a href="{{ $header->instagram_link }}"
                                                   target="_blank"
                                                   class="text-pink-600 hover:text-pink-800 text-sm">
                                                    IG
                                                </a>
                                            @endif

                                            @if ($header->linkedin_link)
                                                <a href="{{ $header->linkedin_link }}"
                                                   target="_blank"
                                                   class="text-blue-700 hover:text-blue-900 text-sm">
                                                    LI
                                                </a>
                                            @endif

                                            @if ($header->youtube_link)
                                                <a href="{{ $header->youtube_link }}"
                                                   target="_blank"
                                                   class="text-red-600 hover:text-red-800 text-sm">
                                                    YT
                                                </a>
                                            @endif

                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $header->is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800' }}">
                                            {{ $header->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="flex space-x-3">

                                            <!-- Edit -->
                                            <a href="{{ route('admin.headers.edit', $header->id) }}"
                                               class="text-blue-600 hover:text-blue-900 transition"
                                               title="Edit">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-5 w-5"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.headers.destroy', $header->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this header?')"
                                                  class="inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition"
                                                        title="Delete">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5"
                                                         viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                              clip-rule="evenodd" />
                                                    </svg>

                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No headers found
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                @if ($headers->hasPages())
                    <div class="mt-4">
                        {{ $headers->links() }}
                    </div>
                @endif

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>