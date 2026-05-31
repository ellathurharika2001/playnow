@extends('app')

@section('title', 'Turf / Ground Registration')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user-style.css') }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Progress Steps (2 steps) -->
            <div class="progress-steps mb-5">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Location Details</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Sport & Pricing</div>
                </div>
                <div class="progress-bar" style="width: 0%;"></div>
            </div>

            <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data" id="turfForm">
                @csrf

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- ================= STEP 1: Location Details ================= -->
                <div class="form-step step-card" id="step1">
                    <div class="text-start mb-4">
                        <h4 class="fw-semibold">Turf / Ground Location</h4>
                        <p class="text-white-50">Tell us where your facility is located</p>
                    </div>

                    <div class="row g-4">
                        <!-- Turf / Ground Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="turf_name" placeholder="Turf / Ground Name *" required value="{{ old('turf_name') }}">
                            </div>
                        </div>

                        <!-- Owner Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="owner_name" placeholder="Owner Name *" required value="{{ old('owner_name') }}">
                            </div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="mobile" placeholder="Mobile Number *" required value="{{ old('mobile') }}">
                                <small class="form-text text-white-50">10-digit mobile</small>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Email Address *" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" name="full_address" rows="2" placeholder="Full Address *" required>{{ old('full_address') }}</textarea>
                            </div>
                        </div>

                        <!-- Area & City -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="area_city" placeholder="Area & City *" required value="{{ old('area_city') }}">
                            </div>
                        </div>

                        <!-- Google Maps link / pin -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="google_maps_link" placeholder="Google Maps link or pin *" required value="{{ old('google_maps_link') }}">
                                <small class="form-text text-white-50">Share the exact location</small>
                            </div>
                        </div>

                        <!-- Landmark (optional) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control form-control-lg" name="landmark" placeholder="Landmark (optional)" value="{{ old('landmark') }}">
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-5 header-nav">
                    
                        <button type="button" class="btn btn-gradient next-btn shop-btn" data-next="2">
                            Continue → Sport & Pricing
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 2: Sport & Pricing ================= -->
                <div class="form-step step-card d-none" id="step2">
                    <div class="text-start mb-4">
                        <h4 class="fw-semibold">Sport Details & Pricing</h4>
                        <p class="text-white-50">Tell players what you offer</p>
                    </div>

                    <div class="row g-4">
                        <!-- Sport type -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Sport type *</label>
                                <select class="form-select form-select-lg" name="sport_type" required>
                                    <option value="">Select sport</option>
                                    <option value="Football" {{ old('sport_type') == 'Football' ? 'selected' : '' }}>Football</option>
                                    <option value="Cricket" {{ old('sport_type') == 'Cricket' ? 'selected' : '' }}>Cricket</option>
                                    <option value="Multi-sport" {{ old('sport_type') == 'Multi-sport' ? 'selected' : '' }}>Multi-sport</option>
                                </select>
                            </div>
                        </div>

                        <!-- Turf size -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Turf size *</label>
                                <input class="form-control form-control-lg" name="turf_size" placeholder="e.g. 5s, 7s, 11s or dimensions" required value="{{ old('turf_size') }}">
                            </div>
                        </div>

                        <!-- Indoor / Outdoor -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold d-block">Indoor / Outdoor *</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="indoor_outdoor" id="indoor" value="Indoor" required {{ old('indoor_outdoor') == 'Indoor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="indoor">Indoor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="indoor_outdoor" id="outdoor" value="Outdoor" required {{ old('indoor_outdoor') == 'Outdoor' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="outdoor">Outdoor</label>
                                </div>
                            </div>
                        </div>

                        <!-- Price per hour -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Price per hour (₹) *</label>
                                <input class="form-control form-control-lg" type="number" min="0" step="1" name="price_per_hour" placeholder="e.g. 800" required value="{{ old('price_per_hour') }}">
                            </div>
                        </div>

                        <!-- Slot duration -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Slot duration (minutes) *</label>
                                <input class="form-control form-control-lg" type="number" min="30" step="15" name="slot_duration" value="{{ old('slot_duration', 60) }}" required>
                                <small class="form-text text-white-50">Usually 60 min</small>
                            </div>
                        </div>

                        <!-- Opening & closing time -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Opening time *</label>
                                <input class="form-control form-control-lg" type="time" name="opening_time" required value="{{ old('opening_time', '06:00') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-semibold">Closing time *</label>
                                <input class="form-control form-control-lg" type="time" name="closing_time" required value="{{ old('closing_time', '22:00') }}">
                            </div>
                        </div>

                        <!-- Photos (1-5) -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label fw-semibold">📸 Upload Photos (1 to 5) *</label>
                                <input class="form-control" type="file" name="photos[]" multiple accept="image/*" required>
                                <small class="form-text text-white-50">You can select up to 5 images (JPEG, PNG). Max 2MB each.</small>
                                @error('photos.*')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 header-nav">
                        <button type="button" class="btn btn-outline-light prev-btn" data-prev="1">← Back to Location</button>
                        <button type="submit" class="btn btn-gradient px-5 shop-btn" id="submitBtn">
                            Submit Turf Registration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.step');
    const progressBar = document.querySelector('.progress-bar');
    let currentStep = 1;

    // Show step function
    function showStep(stepNumber) {
        steps.forEach(step => step.classList.add('d-none'));
        document.getElementById(`step${stepNumber}`).classList.remove('d-none');
        
        const progress = ((stepNumber - 1) / (steps.length - 1)) * 100;
        progressBar.style.width = `${progress}%`;
        
        stepIndicators.forEach((indicator, index) => {
            if (index < stepNumber) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
        currentStep = stepNumber;
    }

    // Next button
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const nextStep = parseInt(this.getAttribute('data-next'));
            if (validateStep(currentStep)) {
                showStep(nextStep);
            }
        });
    });

    // Previous button
    document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const prevStep = parseInt(this.getAttribute('data-prev'));
            showStep(prevStep);
        });
    });

    // Form submit validation
    const form = document.getElementById('turfForm');
    form.addEventListener('submit', function(e) {
        if (!validateAllSteps()) {
            e.preventDefault();
            alert('Please fill all required fields correctly.');
        }
    });

    // Validation helpers (simplified, reuses original logic)
    function validateStep(step) {
        const stepEl = document.getElementById(`step${step}`);
        const requiredInputs = stepEl.querySelectorAll('[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            if (input.type === 'radio') {
                // For radio groups, check if any radio with same name is checked
                const radioName = input.name;
                const checked = stepEl.querySelector(`input[name="${radioName}"]:checked`);
                if (!checked) {
                    isValid = false;
                    highlightError(input.closest('.form-group'), 'Select an option');
                } else {
                    removeErrorHighlight(input.closest('.form-group'));
                }
            } else if (!input.value.trim()) {
                isValid = false;
                highlightError(input);
            } else {
                removeErrorHighlight(input);
            }

            // Additional format validations (email, mobile, etc.)
            if (input.name === 'email' && input.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    highlightError(input, 'Invalid email');
                }
            }
            if (input.name === 'mobile' && input.value) {
                const mobileRegex = /^[6-9]\d{9}$/;
                if (!mobileRegex.test(input.value)) {
                    isValid = false;
                    highlightError(input, 'Invalid 10-digit mobile');
                }
            }
        });

        // Special: photos[] required but we can't easily check file input without value; we'll rely on backend
        return isValid;
    }

    function validateAllSteps() {
        for (let i = 1; i <= 2; i++) {
            if (!validateStep(i)) {
                showStep(i);
                return false;
            }
        }
        return true;
    }

    function highlightError(element, message = 'This field is required') {
        element.classList.add('is-invalid');
        let parent = element.closest('.form-group') || element.parentNode;
        let errorDiv = parent.querySelector('.invalid-feedback');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            parent.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }

    function removeErrorHighlight(element) {
        element.classList.remove('is-invalid');
        let parent = element.closest('.form-group') || element.parentNode;
        let errorDiv = parent.querySelector('.invalid-feedback');
        if (errorDiv) errorDiv.remove();
    }

    // Real-time validation removal
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', function() { removeErrorHighlight(this); });
        el.addEventListener('change', function() { removeErrorHighlight(this); });
    });

    showStep(1);
});
</script>
@endsection