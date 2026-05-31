@extends('app')

@section('title', 'Vendor Login')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user-style.css') }}">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-step step-card">
                <div class="text-start mb-5">
                    <h4 class="mb-4 fw-semibold"> Vendor Login</h4>
                    <p class="text-white-50">Access your vendor dashboard to manage your shop</p>
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

                <form method="POST" action="{{ route('vendor.login.submit') }}" id="loginForm">
                    @csrf

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-white">Email</label>
                                <input class="form-control form-control-lg" 
                                       type="text" 
                                       name="email" 
                                       placeholder="Enter your email" 
                                       value="{{ old('login_id') }}"
                                       required>
                                <small class="form-text text-white-50">Enter the email </small>
                                @error('login_id')
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
                                            <!-- Eye SVG -->
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="yellow"  viewBox="0 0 16 16">
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

                        <div class="text-end mt-5 header-nav">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-white" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-gradient next-btn shop-btn" id="loginBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                Login to Dashboard
                            </button>
                        </div>

                        <!-- <div class="col-12 text-center mt-4">
                            <a href="{{ route('vendor.password.forgot') }}" class="text-decoration-none text-white-50">
                                Forgot your password?
                            </a>
                        </div> -->
                    <div class="text-end mt-5 header-nav">
                        <a class="form-check-label" href="{{ route('vendor.login') }}">
                            Don't have an account?
                        </a>
                    </div>

                    <!-- Google Login -->
                    <div class="mt-5 pt-4 border-top border-white-20">
                        <p class="text-center text-white-50 mb-3">Or continue with</p>
                        <div class="row g-3">
                            <div class="col-12">
                                <a href="{{ route('vendor.login.google.redirect') }}"
                                   class="btn btn-outline-light w-100">
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
                       
                    </div>
                </form>

                <!-- Alternative Login Methods -->
                <!-- <div class="mt-5 pt-4 border-top border-white-20">
                    <p class="text-center text-white-50 mb-3">Or login using</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="" class="btn btn-outline-light w-100">
                                <i class="bi bi-phone me-2"></i>Login with OTP
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-light w-100" id="googleLoginBtn">
                                <i class="bi bi-google me-2"></i>Login with Google
                            </button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle eye SVG
        if(type === 'text') {
            // Eye-slash SVG
            eyeIcon.innerHTML = `
                <path d="M13.359 11.238C14.14 10.132 15 8 15 8s-3-5.5-8-5.5c-1.2 0-2.325.306-3.359.854l1.232 1.232A3 3 0 0 1 11 8a3 3 0 0 1-2.518 2.92l1.232 1.232z"/>
                <path d="M3.707 2.293l-1.414 1.414 12 12 1.414-1.414-12-12z"/>
            `;
        } else {
            // Eye SVG
            eyeIcon.innerHTML = `
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                <path d="M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
            `;
        }
    });


    // Form validation and submission
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    loginForm.addEventListener('submit', function(e) {
        // Basic validation
        const loginId = document.querySelector('input[name="login_id"]');
        const password = document.querySelector('input[name="password"]');
        
        if (!loginId.value.trim()) {
            e.preventDefault();
            showError(loginId, 'Email or mobile number is required');
            return;
        }
        
        if (!password.value.trim()) {
            e.preventDefault();
            showError(password, 'Password is required');
            return;
        }
        
        // Validate email or mobile format
        const loginValue = loginId.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const mobileRegex = /^[6-9]\d{9}$/;
        
        if (!emailRegex.test(loginValue) && !mobileRegex.test(loginValue)) {
            e.preventDefault();
            showError(loginId, 'Please enter a valid email or 10-digit mobile number');
            return;
        }
        
        // Show loading spinner
        const spinner = loginBtn.querySelector('.spinner-border');
        spinner.classList.remove('d-none');
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';
    });

    // Real-time validation
    document.querySelectorAll('input[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                showError(this, 'This field is required');
            } else {
                removeError(this);
            }
        });

        input.addEventListener('input', function() {
            removeError(this);
        });
    });

    // Google Login Button
    const googleLoginBtn = document.getElementById('googleLoginBtn');
    googleLoginBtn.addEventListener('click', function() {
        // You'll need to implement Google OAuth here
        alert('Google login integration required. Please contact administrator.');
    });

    // Helper functions
    function showError(element, message) {
        element.classList.add('is-invalid');
        
        // Remove existing error message
        let errorDiv = element.nextElementSibling;
        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
            errorDiv.remove();
        }
        
        // Add error message
        const errorMsg = document.createElement('div');
        errorMsg.className = 'invalid-feedback d-block text-white fw-bold';
        errorMsg.textContent = message;
        
        // Insert after input element
        element.parentNode.insertBefore(errorMsg, element.nextSibling);
    }

    function removeError(element) {
        element.classList.remove('is-invalid');
        
        // Remove error message if it exists
        const errorDiv = element.nextElementSibling;
        if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
            errorDiv.remove();
        }
    }
});
</script>

<style>
/* Additional styles for login page */
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

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7);
}
</style>

@endsection