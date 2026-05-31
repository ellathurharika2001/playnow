@extends('app')

@section('title', 'Login with OTP')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user-style.css') }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-step step-card">
                <div class="text-start mb-5">
                    <h4 class="mb-4 fw-semibold">Login with OTP</h4>
                    <p class="text-white-50">Enter your email to receive a one-time password</p>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
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

                <!-- Step 1: Enter Email -->
                <div id="emailStep">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-white">Email Address</label>
                                <input class="form-control form-control-lg" 
                                       type="email" 
                                       id="emailInput" 
                                       placeholder="Enter your email" 
                                       required>
                                <small class="form-text text-white-50">We'll send a 6-digit code to this email</small>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-gradient next-btn shop-btn w-100" id="sendOtpBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                <span class="btn-text">Send OTP</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Enter OTP (Hidden initially) -->
                <div id="otpStep" style="display: none;">
                    <form method="POST" action="{{ route('customers.otp.verify') }}" id="otpForm">
                        @csrf
                        <input type="hidden" name="email" id="hiddenEmail">
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    OTP sent to <strong id="displayEmail"></strong>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label text-white">Enter OTP</label>
                                    <input class="form-control form-control-lg text-center" 
                                           type="text" 
                                           name="otp" 
                                           id="otpInput"
                                           placeholder="000000"
                                           maxlength="6"
                                           pattern="[0-9]{6}"
                                           required>
                                    <small class="form-text text-white-50">Enter the 6-digit code sent to your email</small>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-link text-white-50" id="resendOtpBtn">
                                    Didn't receive? <span class="text-white">Resend OTP</span>
                                </button>
                                <div class="text-white-50 mt-2" id="timer" style="display: none;">
                                    Resend available in <span id="countdown">60</span>s
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-gradient next-btn shop-btn w-100" id="verifyOtpBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    <span class="btn-text">Verify & Login</span>
                                </button>
                            </div>

                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-link text-white-50" id="backToEmailBtn">
                                    <i class="bi bi-arrow-left me-2"></i>Change Email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Back to regular login -->
                <div class="mt-4 text-center">
                    <a href="{{ route('customers.login') }}" class="text-white-50">
                        <i class="bi bi-arrow-left me-2"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailStep = document.getElementById('emailStep');
    const otpStep = document.getElementById('otpStep');
    const emailInput = document.getElementById('emailInput');
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const resendOtpBtn = document.getElementById('resendOtpBtn');
    const backToEmailBtn = document.getElementById('backToEmailBtn');
    const hiddenEmail = document.getElementById('hiddenEmail');
    const displayEmail = document.getElementById('displayEmail');
    const timerDiv = document.getElementById('timer');
    const countdownSpan = document.getElementById('countdown');
    const otpInput = document.getElementById('otpInput');
    
    let countdownInterval;

    // Send OTP
    sendOtpBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        
        if (!email || !validateEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }

        sendOTP(email);
    });

    // Resend OTP
    resendOtpBtn.addEventListener('click', function() {
        sendOTP(emailInput.value.trim());
    });

    // Back to email step
    backToEmailBtn.addEventListener('click', function() {
        emailStep.style.display = 'block';
        otpStep.style.display = 'none';
        clearInterval(countdownInterval);
        otpInput.value = '';
    });

    // Function to send OTP
    function sendOTP(email) {
        const spinner = sendOtpBtn.querySelector('.spinner-border');
        const btnText = sendOtpBtn.querySelector('.btn-text');
        
        spinner.classList.remove('d-none');
        sendOtpBtn.disabled = true;
        btnText.textContent = 'Sending...';

        fetch('{{ route("customers.otp.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show OTP step
                emailStep.style.display = 'none';
                otpStep.style.display = 'block';
                hiddenEmail.value = email;
                displayEmail.textContent = email;
                
                // Start countdown
                startCountdown();
                
                // Focus on OTP input
                otpInput.focus();
            } else {
                alert(data.message || 'Failed to send OTP');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            spinner.classList.add('d-none');
            sendOtpBtn.disabled = false;
            btnText.textContent = 'Send OTP';
        });
    }

    // Countdown timer
    function startCountdown() {
        let seconds = 60;
        resendOtpBtn.style.display = 'none';
        timerDiv.style.display = 'block';
        
        countdownInterval = setInterval(function() {
            seconds--;
            countdownSpan.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                resendOtpBtn.style.display = 'block';
                timerDiv.style.display = 'none';
            }
        }, 1000);
    }

    // Email validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Auto-format OTP input (numbers only)
    otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Form submission
    document.getElementById('otpForm').addEventListener('submit', function() {
        const spinner = document.querySelector('#verifyOtpBtn .spinner-border');
        const btnText = document.querySelector('#verifyOtpBtn .btn-text');
        
        spinner.classList.remove('d-none');
        document.getElementById('verifyOtpBtn').disabled = true;
        btnText.textContent = 'Verifying...';
    });
});
</script>

<style>
.form-control-lg.text-center {
    font-size: 2rem;
    letter-spacing: 1rem;
    font-weight: bold;
}

.btn-link {
    text-decoration: none;
}

.btn-link:hover {
    text-decoration: underline;
}
</style>

@endsection