@extends('app')

@section('title', 'Verify Email - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-envelope-check-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold">Verify Your Email</h3>
                        <p class="text-muted">We've sent a 6-digit code to your email address. Please enter it below.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('customers.verify.email.submit') }}" method="POST" id="verifyForm">
                        @csrf

                        <!-- OTP Input -->
                        <div class="mb-3">
                            <label for="otp" class="form-label text-center d-block">Enter Verification Code</label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" 
                                   id="otp" 
                                   name="otp" 
                                   maxlength="6" 
                                   placeholder="000000"
                                   pattern="[0-9]{6}"
                                   required
                                   autofocus>
                            @error('otp')
                                <div class="invalid-feedback text-center">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block text-center mt-2">Enter the 6-digit code</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="verifyBtn">
                                <i class="bi bi-check-circle me-2"></i>Verify Email
                            </button>
                        </div>
                    </form>

                    <!-- Resend OTP -->
                    <div class="text-center">
                        <p class="mb-2 text-muted">Didn't receive the code?</p>
                        <button type="button" class="btn btn-link text-decoration-none p-0" id="resendBtn">
                            <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                        </button>
                        <p class="mt-2" id="resendTimer" style="display: none;">
                            <small class="text-muted">Resend available in <span id="countdown">60</span>s</small>
                        </p>
                    </div>

                    <hr class="my-3">

                    <!-- Back to Register -->
                    <div class="text-center">
                        <a href="{{ route('customers.register') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Back to Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let countdownTimer;
    let secondsLeft = 60;

    // Auto-format OTP input (numbers only)
    document.getElementById('otp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Resend OTP functionality
    document.getElementById('resendBtn').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        
        fetch('{{ route("customers.resend.verification.otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.querySelector('.card-body').insertBefore(alert, document.querySelector('form'));
                
                // Start countdown
                startCountdown();
                
                // Auto-remove alert after 5 seconds
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            } else {
                alert('Error: ' + data.message);
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to resend code. Please try again.');
            btn.disabled = false;
        });
    });

    function startCountdown() {
        document.getElementById('resendBtn').style.display = 'none';
        document.getElementById('resendTimer').style.display = 'block';
        secondsLeft = 60;
        
        countdownTimer = setInterval(function() {
            secondsLeft--;
            document.getElementById('countdown').textContent = secondsLeft;
            
            if (secondsLeft <= 0) {
                clearInterval(countdownTimer);
                document.getElementById('resendBtn').style.display = 'inline-block';
                document.getElementById('resendBtn').disabled = false;
                document.getElementById('resendTimer').style.display = 'none';
            }
        }, 1000);
    }

    // Auto-submit form when 6 digits entered (optional)
    document.getElementById('otp').addEventListener('input', function() {
        if (this.value.length === 6) {
            // Optional: auto-submit
            // document.getElementById('verifyForm').submit();
        }
    });
</script>
@endpush
@endsection