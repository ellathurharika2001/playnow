{{-- resources/views/admin/sliders/index.blade.php --}}

<x-layouts.app.sidebar :title="__('Admin - Slider')">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">

            <!-- Header -->
            <div class="admin-header">

                <h1 class="admin-title">
                    Slider
                    <span class="text-muted text-sm">
                        ({{ $sliders->total() }})
                    </span>
                </h1>

                <a href="{{ route('admin.sliders.create') }}"
                   class="btn btn-primary">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 mr-2"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z"
                              clip-rule="evenodd" />

                    </svg>

                    Add Slider

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
                                <th>Image</th>
                                <th>Title</th>
                                <th>Button</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($sliders as $slider)

                                <tr>

                                    <td>{{ $slider->id }}</td>

                                    <!-- Image -->
                                    <td>

                                        @if($slider->image)

                                            <img src="{{ asset($slider->image) }}"
                                                 alt="{{ $slider->title }}"
                                                 class="h-12 w-20 rounded object-cover">

                                        @else

                                            <div class="h-12 w-20 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-xs text-gray-500">
                                                    No Image
                                                </span>
                                            </div>

                                        @endif

                                    </td>

                                    <!-- Title -->
                                    <td>

                                        <strong>
                                            {{ $slider->title }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            {{ Str::limit(strip_tags($slider->content), 60) }}
                                        </small>

                                    </td>

                                    <!-- Button -->
                                    <td>

                                        @if($slider->button_text)

                                            <a href="{{ $slider->button_link }}"
                                               target="_blank"
                                               class="text-blue-600 text-sm">

                                                {{ $slider->button_text }}

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                No Button
                                            </span>

                                        @endif

                                    </td>

                                    <!-- Sort -->
                                    <td>
                                        {{ $slider->sort_order }}
                                    </td>

                                    <!-- Status -->
                                    <td>

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $slider->is_active
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800' }}">

                                            {{ $slider->is_active ? 'Active' : 'Inactive' }}

                                        </span>

                                    </td>

                                    <!-- Actions -->
                                    <td>

                                        <div class="flex space-x-3">

                                            <!-- Edit -->
                                            <a href="{{ route('admin.sliders.edit', $slider->id) }}"
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
                                            <form action="{{ route('admin.sliders.destroy', $slider->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this slider?')"
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
                                                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9z"
                                                              clip-rule="evenodd" />

                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="text-center text-muted py-4">

                                        No sliders found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                @if($sliders->hasPages())

                    <div class="mt-4">
                        {{ $sliders->links() }}
                    </div>

                @endif

            </div>

        </div>

    </flux:main>
</x-layouts.app.sidebar>