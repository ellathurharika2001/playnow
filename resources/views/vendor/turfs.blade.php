@extends('vendor.layouts.app.sidebar')

@section('header')
    <h1 class="text-2xl font-bold">Turfs</h1>
@endsection

@section('content')
      <style>
        .suggestions-box {
            border: 1px solid #ddd;
            background: #fff;
            max-height: 200px;
            overflow-y: auto;
            position: relative;
            z-index: 1000;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background: #f0f0f0;
        }
        </style>
        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">

        <div class="admin-container">
            @php $isEdit = isset($vendor) && $vendor->exists; @endphp
            <div class="admin-header">
                <h1 class="admin-title">
                    {{ $isEdit ? 'Edit Turf' : 'Add New Turf' }}
                </h1>
            </div>

            <div class="admin-card">
                <form
                    action="{{ $isEdit
                        ? route('vendor.turfs.update', $vendor)
                        : route('vendor.turfs.create') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">Turf Information</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Turf Name *</label>
                            <input type="text"
                                   name="turf_name"
                                   value="{{ old('turf_name', $vendor->turf_name ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('turf_name')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Owner Name *</label>
                            <input type="text"
                                   name="owner_name"
                                   value="{{ old('owner_name', $vendor->owner_name ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('owner_name')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $vendor->email ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('email')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mobile *</label>
                            <input type="tel"
                                   name="mobile"
                                   value="{{ old('mobile', $vendor->mobile ?? '') }}"
                                   class="form-input"
                                   maxlength="10"
                                   required>
                            @error('mobile')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-6">Location & Details</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Full Address *</label>
                            <textarea name="full_address"
                                      id="full_address"
                                      rows="3"
                                      class="form-input"
                                      required>{{ old('full_address', $vendor->full_address ?? '') }}</textarea>
                            <div id="address-suggestions" class="suggestions-box"></div>
                            @error('full_address')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div>

                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text"
                                   name="area_city"
                                   value="{{ old('area_city', $vendor->area_city ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('area_city')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Google Maps Link</label>
                            <input type="url"
                                   name="google_maps_link"
                                   value="{{ old('google_maps_link', $vendor->google_maps_link ?? '') }}"
                                   class="form-input"
                                   placeholder="https://maps.app.goo.gl/...">
                            @error('google_maps_link')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Landmark</label>
                            <input type="text"
                                   name="landmark"
                                   value="{{ old('landmark', $vendor->landmark ?? '') }}"
                                   class="form-input">
                            @error('landmark')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4 mt-6">Turf Configuration</h3>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Sport Type *</label>
                            <select name="sport_type" class="form-input">
                                <option value="Cricket" @selected(old('sport_type', $vendor->sport_type ?? '') === 'Cricket')>Cricket</option>
                                <option value="Football" @selected(old('sport_type', $vendor->sport_type ?? '') === 'Football')>Football</option>
                                <option value="Multi-sport" @selected(old('sport_type', $vendor->sport_type ?? '') === 'Multi-sport')>Multi-sport</option>
                            </select>
                            @error('sport_type')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Turf Size *</label>
                            <input type="text"
                                   name="turf_size"
                                   value="{{ old('turf_size', $vendor->turf_size ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('turf_size')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Indoor / Outdoor</label>
                            <select name="indoor_outdoor" class="form-input">
                                <option value="indoor" @selected(old('indoor_outdoor', $vendor->indoor_outdoor ?? '') === 'indoor')>Indoor</option>
                                <option value="outdoor" @selected(old('indoor_outdoor', $vendor->indoor_outdoor ?? '') === 'outdoor')>Outdoor</option>
                            </select>
                            @error('indoor_outdoor')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Price / hr *</label>
                            <input type="number"
                                   name="price_per_hour"
                                   value="{{ old('price_per_hour', $vendor->price_per_hour ?? '') }}"
                                   class="form-input"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('price_per_hour')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Slot Duration *</label>
                            <input type="text"
                                   name="slot_duration"
                                   value="{{ old('slot_duration', $vendor->slot_duration ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('slot_duration')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Opening Time *</label>
                            <input type="time"
                                   name="opening_time"
                                   value="{{ old('opening_time', optional($vendor->opening_time)->format('H:i') ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('opening_time')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Closing Time *</label>
                            <input type="time"
                                   name="closing_time"
                                   value="{{ old('closing_time', optional($vendor->closing_time)->format('H:i') ?? '') }}"
                                   class="form-input"
                                   required>
                            @error('closing_time')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Registration Date</label>
                            <input type="date"
                                   name="registration_date"
                                   value="{{ old('registration_date', optional($vendor->registration_date)->format('Y-m-d') ?? '') }}"
                                   class="form-input">
                            @error('registration_date')
                                <small class="text-error">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Photos</label>

                        @if(isset($vendor) && !empty($vendor->photos))
                            <div class="grid grid-cols-4 gap-3 mb-3">
                                @foreach((array) $vendor->photos as $photo)
                                    <img src="{{ asset($photo) }}"
                                         alt="Turf photo"
                                         class="h-20 w-20 rounded object-cover">
                                @endforeach
                            </div>
                        @endif

                        <input type="file"
                               name="photos[]"
                               class="form-input"
                               accept="image/*"
                               multiple>
                        <small class="text-muted">Upload one or more images.</small>

                        @error('photos')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                        @error('photos.*')
                            <small class="text-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="form-actions mt-6">
                        <a href="{{ route('vendor.turfs') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? 'Update Turf' : 'Create Turf' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
        const API_KEY = "5966538c02904b00a21b4630fccd3059";


const input = document.getElementById("full_address");
const suggestionBox = document.getElementById("address-suggestions");

// Fetch suggestions while typing
input.addEventListener("input", async function () {
    const query = this.value;

    if (query.length < 3) {
        suggestionBox.innerHTML = "";
        return;
    }

    const url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&limit=5&apiKey=${API_KEY}`;
    const res = await fetch(url);
    const data = await res.json();

    suggestionBox.innerHTML = "";

    data.features.forEach(feature => {
      
        const div = document.createElement("div");
        div.classList.add("suggestion-item");
        div.innerText = feature.properties.formatted;

        div.addEventListener("click", () => {
            // Set address
            input.value = feature.properties.formatted;

            // Set lat/lng
            document.getElementById('latitude').value = feature.geometry.coordinates[1];
            document.getElementById('longitude').value = feature.geometry.coordinates[0];

            // Optional: auto city
            if (feature.properties.city) {
                document.querySelector('[name="area_city"]').value = feature.properties.city;
            }

            suggestionBox.innerHTML = "";
        });

        suggestionBox.appendChild(div);
    });
});

// Close dropdown if clicked outside
document.addEventListener("click", function (e) {
    if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
        suggestionBox.innerHTML = "";
    }
});
</script>

    
@endsection
