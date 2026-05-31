{{-- resources/views/admin/terms-conditions/index.blade.php --}}

<x-layouts.app.sidebar :title="__('Admin - Terms & Conditions')">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">

                <h1 class="admin-title">
                    Terms & Conditions
                    <span class="text-muted text-sm">
                        ({{ $termsConditions->total() }})
                    </span>
                </h1>

                <a href="{{ route('admin.terms-conditions.create') }}"
                   class="btn btn-primary">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 mr-2"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z"
                              clip-rule="evenodd" />
                    </svg>

                    Add Terms

                </a>

            </div>

            <!-- Success Message -->
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
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($termsConditions as $termsCondition)

                                <tr>

                                    <td>
                                        {{ $termsCondition->id }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $termsCondition->title }}
                                        </strong>
                                    </td>

                                    <td>
                                        {!! Str::limit(strip_tags($termsCondition->content), 100) !!}
                                    </td>

                                    <td>

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $termsCondition->is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800' }}">

                                            {{ $termsCondition->is_active ? 'Active' : 'Inactive' }}

                                        </span>

                                    </td>

                                    <td>

                                        <div class="flex space-x-3">

                                            <!-- Edit -->
                                            <a href="{{ route('admin.terms-conditions.edit', $termsCondition->id) }}"
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
                                            <form action="{{ route('admin.terms-conditions.destroy', $termsCondition->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this item?')"
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

                                    <td colspan="5"
                                        class="text-center text-muted py-4">

                                        No Terms & Conditions found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                @if ($termsConditions->hasPages())

                    <div class="mt-4">
                        {{ $termsConditions->links() }}
                    </div>

                @endif

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>