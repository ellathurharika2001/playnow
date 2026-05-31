<!-- Modern Animated Footer -->
<footer class="pn-footer">
    <!-- Main Footer Content -->
    <div class="pn-footer-main">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="pn-footer-about">
                        <div class="pn-footer-logo mb-4">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('logo.png') }}" alt="PlayNow" class="pn-footer-logo-img">
                            </a>
                        </div>
                        <p class="pn-footer-description">
                            India's leading sports booking platform. Discover and book premium turfs, cricket grounds, and badminton courts near you in seconds!
                        </p>
                        <div class="pn-footer-social mt-4">
                            <a href="#" class="pn-social-link" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="pn-social-link" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="pn-social-link" title="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="pn-social-link" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="pn-social-link" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="pn-footer-links">
                        <h5 class="pn-footer-title">Quick Links</h5>
                        <ul class="pn-footer-menu">
                            <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i>Home</a></li>
                            <li><a href="#featured-grounds"><i class="bi bi-chevron-right"></i>Featured Venues</a></li>
                            <li><a href="#how-it-works"><i class="bi bi-chevron-right"></i>How It Works</a></li>
                            <li><a href="#offers"><i class="bi bi-chevron-right"></i>Special Offers</a></li>
                            <li><a href="#testimonials"><i class="bi bi-chevron-right"></i>Testimonials</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Sports Categories -->
                <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="pn-footer-links">
                        <h5 class="pn-footer-title">Sports</h5>
                        <ul class="pn-footer-menu">
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Football Turfs</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Cricket Grounds</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Badminton Courts</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Tennis Courts</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>All Sports</a></li>
                        </ul>
                    </div>
                </div>

                <!-- For Vendors -->
                <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="pn-footer-links">
                        <h5 class="pn-footer-title">For Vendors</h5>
                        <ul class="pn-footer-menu">
                            <li><a href="{{ route('vendor.register.form') }}"><i class="bi bi-chevron-right"></i>Register Venue</a></li>
                            <li><a href="{{ route('vendor.login') }}"><i class="bi bi-chevron-right"></i>Vendor Login</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Partner Benefits</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Vendor FAQs</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Support</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-2 col-md-6 col-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="pn-footer-links">
                        <h5 class="pn-footer-title">Support</h5>
                        <ul class="pn-footer-menu">
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Help Center</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Contact Us</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Privacy Policy</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Terms of Service</a></li>
                            <li><a href="#"><i class="bi bi-chevron-right"></i>Cancellation</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Cards -->
            <div class="pn-footer-contact mt-5" data-aos="fade-up" data-aos-delay="600">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="pn-contact-card">
                            <div class="pn-contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="pn-contact-info">
                                <h6 class="pn-contact-label">Location</h6>
                                <p class="pn-contact-value">Chennai, Tamil Nadu, India</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pn-contact-card">
                            <div class="pn-contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="pn-contact-info">
                                <h6 class="pn-contact-label">Phone</h6>
                                <p class="pn-contact-value">+91 98765 43210</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="pn-contact-card">
                            <div class="pn-contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="pn-contact-info">
                                <h6 class="pn-contact-label">Email</h6>
                                <p class="pn-contact-value">support@playnow.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- App Download Section -->
            <!-- <div class="pn-footer-app mt-5" data-aos="fade-up" data-aos-delay="700">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <h5 class="pn-app-title">Download Our Mobile App</h5>
                        <p class="pn-app-description">Book on the go! Get exclusive app-only deals and offers.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="pn-app-buttons">
                            <a href="#" class="pn-app-store-btn">
                                <i class="bi bi-apple"></i>
                                <div class="pn-app-btn-text">
                                    <span class="pn-app-btn-label">Download on the</span>
                                    <span class="pn-app-btn-store">App Store</span>
                                </div>
                            </a>
                            <a href="#" class="pn-app-store-btn">
                                <i class="bi bi-google-play"></i>
                                <div class="pn-app-btn-text">
                                    <span class="pn-app-btn-label">Get it on</span>
                                    <span class="pn-app-btn-store">Google Play</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="pn-footer-bottom">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6 text-center text-md-start">
                    <p class="pn-copyright">
                        © {{ date('Y') }} <strong>PlayNow</strong>. All rights reserved. Made with <i class="bi bi-heart-fill text-danger"></i> in India
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="pn-footer-bottom-links">
                        <a href="#">Privacy Policy</a>
                        <span class="pn-separator">•</span>
                        <a href="#">Terms & Conditions</a>
                        <span class="pn-separator">•</span>
                        <a href="#">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="pn-back-to-top" id="backToTop" title="Back to top">
        <i class="bi bi-arrow-up"></i>
    </button>
</footer>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom JavaScript -->
<script>
    // ===================================
    // Initialize AOS Animations
    // ===================================
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // ===================================
    // Page Loader
    // ===================================
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }, 1000);
        }
    });

    // ===================================
    // Hero Swiper
    // ===================================
    const heroSwiper = new Swiper('.pn-hero-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        speed: 1000,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    // ===================================
    // Testimonials Swiper
    // ===================================
    const testimonialsSwiper = new Swiper('.pn-testimonials-swiper', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.pn-testimonial-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });

    // ===================================
    // Counter Animation
    // ===================================
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // Trigger counter animation when stats are visible
    const statNumbers = document.querySelectorAll('.pn-stat-number');
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && entry.target.textContent === '0') {
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNumbers.forEach(stat => statsObserver.observe(stat));

    // ===================================
    // Back to Top Button
    // ===================================
    const backToTopButton = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            backToTopButton.classList.add('pn-show');
        } else {
            backToTopButton.classList.remove('pn-show');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // ===================================
    // Smooth Scroll for Anchor Links
    // ===================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerHeight = document.querySelector('.pn-header')?.offsetHeight || 0;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // ===================================
    // Newsletter Form
    // ===================================
    const newsletterForm = document.querySelector('.pn-newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            // Add your newsletter subscription logic here
            console.log('Newsletter subscription:', email);
            
            // Show success message
            alert('Thank you for subscribing! Check your email for confirmation.');
            this.reset();
        });
    }

    // ===================================
    // Add Active Class on Scroll
    // ===================================
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.pn-header');
        if (window.scrollY > 100) {
            header?.classList.add('pn-header-scrolled');
        } else {
            header?.classList.remove('pn-header-scrolled');
        }
    });

    // ===================================
    // Lazy Load Images (for better performance)
    // ===================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
</script>