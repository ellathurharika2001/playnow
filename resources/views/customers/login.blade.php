@extends('app')

@section('title', 'User Login')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user-style.css') }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-step step-card">
                <div class="text-start mb-5">
                    <h4 class="mb-4 fw-semibold">User Login</h4>
                    <p class="text-white-50">Access your account to book turfs and manage bookings</p>
                </div>

                <!-- Success/Error Messages -->
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

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Login Method Tabs -->
                <ul class="nav nav-pills mb-4 justify-content-center" id="loginTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="password-tab" data-bs-toggle="pill" data-bs-target="#password-login" type="button" role="tab">
                            <i class="bi bi-key-fill me-2"></i>Password
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="otp-tab" data-bs-toggle="pill" data-bs-target="#otp-login" type="button" role="tab">
                            <i class="bi bi-shield-lock-fill me-2"></i>Email OTP
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="loginTabContent">
                    <!-- Password Login Tab -->
                    <div class="tab-pane fade show active" id="password-login" role="tabpanel">
                        <form method="POST" action="{{ route('customers.login.submit') }}" id="loginForm">
                            @csrf

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text-white">Email</label>
                                        <input class="form-control form-control-lg" 
                                               type="email" 
                                               name="email" 
                                               placeholder="Enter your email" 
                                               value="{{ old('email') }}"
                                               required>
                                        <small class="form-text text-white-50">Enter your registered email</small>
                                        @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text-white">Password</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-lg" 
                                                   type="password" 
                                                   name="password" 
                                                   id="password"
                                                   placeholder="Enter your password" 
                                                   required>
                                            <button class="btn btn-outline-light" type="button" id="togglePassword">
                                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="yellow" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                                    <path d="M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label text-white" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-gradient next-btn shop-btn w-100" id="loginBtn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        <span class="btn-text">Login to Your Account</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- OTP Login Tab -->
                    <div class="tab-pane fade" id="otp-login" role="tabpanel">
                        <!-- Step 1: Enter Email for OTP -->
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
                                            <input class="form-control form-control-lg text-center otp-input" 
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
                    </div>
                </div>

                <!-- Google Login (Always visible) -->
                <div class="mt-5 pt-4 border-top border-white-20">
                    <p class="text-center text-white-50 mb-3">Or continue with</p>
                    <div class="row g-3">
                        <div class="col-12">
                            <a href="{{ route('customers.login.google.redirect') }}" class="btn btn-outline-light w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="me-2" style="display: inline-block; vertical-align: middle;">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                                Login with Google
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Registration Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('customers.register') }}" class="text-white-50">
                        Don't have an account? <span class="text-white fw-semibold">Register here</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if(type === 'text') {
                eyeIcon.innerHTML = `
                    <path d="M13.359 11.238C14.14 10.132 15 8 15 8s-3-5.5-8-5.5c-1.2 0-2.325.306-3.359.854l1.232 1.232A3 3 0 0 1 11 8a3 3 0 0 1-2.518 2.92l1.232 1.232z"/>
                    <path d="M3.707 2.293l-1.414 1.414 12 12 1.414-1.414-12-12z"/>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                    <path d="M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                `;
            }
        });
    }

    // Password login form submission
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const spinner = loginBtn.querySelector('.spinner-border');
            const btnText = loginBtn.querySelector('.btn-text');
            if (spinner && btnText) {
                spinner.classList.remove('d-none');
                loginBtn.disabled = true;
                btnText.textContent = 'Logging in...';
            }
        });
    }

    // OTP Login functionality
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
    if (sendOtpBtn) {
        sendOtpBtn.addEventListener('click', function() {
            const email = emailInput.value.trim();
            
            if (!email || !validateEmail(email)) {
                alert('Please enter a valid email address');
                return;
            }

            sendOTP(email);
        });
    }

    // Resend OTP
    if (resendOtpBtn) {
        resendOtpBtn.addEventListener('click', function() {
            sendOTP(emailInput.value.trim());
        });
    }

    // Back to email step
    if (backToEmailBtn) {
        backToEmailBtn.addEventListener('click', function() {
            emailStep.style.display = 'block';
            otpStep.style.display = 'none';
            clearInterval(countdownInterval);
            otpInput.value = '';
        });
    }

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
                alert(data.message || 'Failed to send OTP. Please make sure you have an account.');
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
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // OTP form submission
    const otpForm = document.getElementById('otpForm');
    if (otpForm) {
        otpForm.addEventListener('submit', function() {
            const spinner = document.querySelector('#verifyOtpBtn .spinner-border');
            const btnText = document.querySelector('#verifyOtpBtn .btn-text');
            
            if (spinner && btnText) {
                spinner.classList.remove('d-none');
                document.getElementById('verifyOtpBtn').disabled = true;
                btnText.textContent = 'Verifying...';
            }
        });
    }

    // Reset OTP step when switching tabs
    const otpTab = document.getElementById('otp-tab');
    if (otpTab) {
        otpTab.addEventListener('click', function() {
            if (emailStep && otpStep) {
                emailStep.style.display = 'block';
                otpStep.style.display = 'none';
                clearInterval(countdownInterval);
                if (otpInput) otpInput.value = '';
                if (emailInput) emailInput.value = '';
            }
        });
    }
});
</script>

<style>
.input-group .btn-outline-light {
    border-color: #dee2e6;
}

.input-group .btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.border-white-20 {
    border-color: rgba(255, 255, 255, 0.2) !important;
}

.shop-btn {
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.shop-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7);
}

/* Tab Styles */
.nav-pills .nav-link {
    color: rgba(255, 255, 255, 0.7);
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 10px 20px;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    color: #fff;
    background-color: rgba(255, 255, 255, 0.1);
}

.nav-pills .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
}

/* OTP Input Style */
.otp-input {
    font-size: 2rem;
    letter-spacing: 1rem;
    font-weight: bold;
    text-align: center;
}

.btn-link {
    text-decoration: none;
}

.btn-link:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .nav-pills .nav-link {
        font-size: 14px;
        padding: 8px 15px;
    }
    
    .otp-input {
        font-size: 1.5rem;
        letter-spacing: 0.5rem;
    }
}
</style>

@endsection