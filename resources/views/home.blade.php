@extends('app')

@section('title', 'PlayNow - Book Sports Grounds & Turfs')

@section('content')
<link rel="stylesheet" href="{{asset('css/home.css')}}">
<!-- Animated Football Loader -->
<!-- <div id="page-loader" class="pn-loader">
    <div class="pn-loader-content">
        <div class="pn-football-loader">
            <div class="pn-football">
                <div class="pn-football-panel"></div>
                <div class="pn-football-panel"></div>
                <div class="pn-football-panel"></div>
                <div class="pn-football-panel"></div>
                <div class="pn-football-panel"></div>
                <div class="pn-football-panel"></div>
            </div>
        </div>
        <p class="pn-loader-text mt-4">Loading your game...</p>
    </div>
</div> -->

<!-- Hero Section with Swiper -->
<section id="pn-hero" class="pn-hero-section position-relative overflow-hidden">
    <div class="pn-hero-overlay"></div>
    
    <div class="swiper pn-hero-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="pn-hero-slide" style="background-image: url('{{ asset('assets/images/home1.jpg') }}');">
                    <div class="pn-hero-content">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <span class="pn-hero-badge" data-aos="fade-down">
                                        <i class="bi bi-trophy-fill me-2"></i>Premium Sports Venues
                                    </span>
                                    <h1 class="pn-hero-title" data-aos="fade-up" data-aos-delay="100">
                                        Book Your <span class="pn-text-gradient">Dream Ground</span>
                                    </h1>
                                    <p class="pn-hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                                        Find and book the best turfs, cricket grounds & badminton courts near you in seconds!
                                    </p>
                                    <div class="pn-hero-buttons" data-aos="fade-up" data-aos-delay="300">
                                        <a href="#nearby-venues" class="btn pn-btn-primary pn-btn-lg">
                                            <i class="bi bi-search me-2"></i>Find Venues
                                        </a>
                                        <a href="#how-it-works" class="btn pn-btn-outline pn-btn-lg">
                                            <i class="bi bi-play-circle me-2"></i>How It Works
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="swiper-slide">
                <div class="pn-hero-slide" style="background-image: url('{{ asset('assets/images/home2.jpg') }}');">
                    <div class="pn-hero-content">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <span class="pn-hero-badge" data-aos="fade-down">
                                        <i class="bi bi-lightning-fill me-2"></i>Instant Booking
                                    </span>
                                    <h1 class="pn-hero-title" data-aos="fade-up" data-aos-delay="100">
                                        Play When <span class="pn-text-gradient">You Want</span>
                                    </h1>
                                    <p class="pn-hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                                        Real-time availability, instant confirmation, and seamless booking experience!
                                    </p>
                                    <div class="pn-hero-buttons" data-aos="fade-up" data-aos-delay="300">
                                        <a href="#featured-grounds" class="btn pn-btn-primary pn-btn-lg">
                                            <i class="bi bi-star-fill me-2"></i>Featured Grounds
                                        </a>
                                        <a href="#offers" class="btn pn-btn-outline pn-btn-lg">
                                            <i class="bi bi-tag-fill me-2"></i>Special Offers
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="swiper-slide">
                <div class="pn-hero-slide" style="background-image: url('{{ asset('assets/images/home3.jpg') }}');">
                    <div class="pn-hero-content">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <span class="pn-hero-badge" data-aos="fade-down">
                                        <i class="bi bi-people-fill me-2"></i>Join 10,000+ Players
                                    </span>
                                    <h1 class="pn-hero-title" data-aos="fade-up" data-aos-delay="100">
                                        Your Game, <span class="pn-text-gradient">Our Passion</span>
                                    </h1>
                                    <p class="pn-hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                                        Trusted by thousands of sports enthusiasts across Chennai and beyond!
                                    </p>
                                    <div class="pn-hero-buttons" data-aos="fade-up" data-aos-delay="300">
                                        <a href="#" class="btn pn-btn-primary pn-btn-lg">
                                            <i class="bi bi-calendar-check me-2"></i>Book Now
                                        </a>
                                        <a href="#testimonials" class="btn pn-btn-outline pn-btn-lg">
                                            <i class="bi bi-chat-quote me-2"></i>Read Reviews
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="swiper-button-next pn-swiper-nav"></div>
        <div class="swiper-button-prev pn-swiper-nav"></div>
        <div class="swiper-pagination pn-swiper-pagination"></div>
    </div>
    
    <!-- Floating Stats -->
    <div class="pn-hero-stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="pn-stat-card" data-aos="zoom-in" data-aos-delay="400">
                        <div class="pn-stat-icon">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div class="pn-stat-content">
                            <h3 class="pn-stat-number" data-count="150">0</h3>
                            <p class="pn-stat-label">Venues</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-stat-card" data-aos="zoom-in" data-aos-delay="500">
                        <div class="pn-stat-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="pn-stat-content">
                            <h3 class="pn-stat-number" data-count="10000">0</h3>
                            <p class="pn-stat-label">Happy Players</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-stat-card" data-aos="zoom-in" data-aos-delay="600">
                        <div class="pn-stat-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="pn-stat-content">
                            <h3 class="pn-stat-number" data-count="50000">0</h3>
                            <p class="pn-stat-label">Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-stat-card" data-aos="zoom-in" data-aos-delay="700">
                        <div class="pn-stat-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="pn-stat-content">
                            <h3 class="pn-stat-number" data-count="15">0</h3>
                            <p class="pn-stat-label">Cities</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Sports Categories -->
<section class="pn-section pn-sports-categories">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-trophy me-2"></i>Choose Your Sport
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Popular Sports <span class="pn-text-gradient">Categories</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Book your favorite sports venue with just a few clicks
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="100">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-football">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <h4 class="pn-sport-name">Football</h4>
                    <p class="pn-sport-count">45 Venues</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="200">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-cricket">
                        <i class="bi bi-circle"></i>
                    </div>
                    <h4 class="pn-sport-name">Cricket</h4>
                    <p class="pn-sport-count">38 Grounds</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="300">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-badminton">
                        <i class="bi bi-egg"></i>
                    </div>
                    <h4 class="pn-sport-name">Badminton</h4>
                    <p class="pn-sport-count">52 Courts</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="400">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-tennis">
                        <i class="bi bi-circle"></i>
                    </div>
                    <h4 class="pn-sport-name">Tennis</h4>
                    <p class="pn-sport-count">24 Courts</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="500">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-volleyball">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <h4 class="pn-sport-name">Volleyball</h4>
                    <p class="pn-sport-count">18 Courts</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="600">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-basketball">
                        <i class="bi bi-circle"></i>
                    </div>
                    <h4 class="pn-sport-name">Basketball</h4>
                    <p class="pn-sport-count">15 Courts</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="700">
                <a href="#" class="pn-sport-card">
                    <div class="pn-sport-icon pn-sport-swimming">
                        <i class="bi bi-droplet-fill"></i>
                    </div>
                    <h4 class="pn-sport-name">Swimming</h4>
                    <p class="pn-sport-count">12 Pools</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-4 col-lg-3" data-aos="flip-left" data-aos-delay="800">
                <a href="#" class="pn-sport-card pn-sport-card-more">
                    <div class="pn-sport-icon pn-sport-more">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <h4 class="pn-sport-name">View All</h4>
                    <p class="pn-sport-count">Sports</p>
                    <div class="pn-sport-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Grounds / Trending Venues -->
<section id="featured-grounds" class="pn-section pn-featured-section bg-light">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-star-fill me-2"></i>Top Rated
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Featured <span class="pn-text-gradient">Grounds</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Premium venues loved by thousands of players
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="pn-venue-card">
                    <div class="pn-venue-badge">
                        <i class="bi bi-star-fill"></i> Featured
                    </div>
                    <div class="pn-venue-image">
                        <img src="https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=800&q=80" alt="Turf Arena" class="w-100">
                        <div class="pn-venue-overlay">
                            <a href="#" class="btn pn-btn-white pn-btn-sm">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                    <div class="pn-venue-content">
                        <div class="pn-venue-header">
                            <h4 class="pn-venue-name">PlayNow Premier Turf</h4>
                            <div class="pn-venue-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.8</span>
                            </div>
                        </div>
                        <p class="pn-venue-location">
                            <i class="bi bi-geo-alt me-1"></i>Anna Nagar, Chennai
                        </p>
                        <div class="pn-venue-features">
                            <span class="pn-feature-tag"><i class="bi bi-circle-fill me-1"></i>5-a-side</span>
                            <span class="pn-feature-tag"><i class="bi bi-brightness-high me-1"></i>Floodlights</span>
                            <span class="pn-feature-tag"><i class="bi bi-p-square me-1"></i>Parking</span>
                        </div>
                        <div class="pn-venue-footer">
                            <div class="pn-venue-price">
                                <span class="pn-price-label">Starting from</span>
                                <span class="pn-price-amount">₹1,200<small>/hour</small></span>
                            </div>
                            <a href="#" class="btn pn-btn-primary pn-btn-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pn-venue-card">
                    <div class="pn-venue-badge pn-badge-trending">
                        <i class="bi bi-fire"></i> Trending
                    </div>
                    <div class="pn-venue-image">
                        <img src="https://images.unsplash.com/photo-1589487391730-58f20eb2c308?auto=format&fit=crop&w=800&q=80" alt="Cricket Ground" class="w-100">
                        <div class="pn-venue-overlay">
                            <a href="#" class="btn pn-btn-white pn-btn-sm">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                    <div class="pn-venue-content">
                        <div class="pn-venue-header">
                            <h4 class="pn-venue-name">City Super Cricket Ground</h4>
                            <div class="pn-venue-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>4.9</span>
                            </div>
                        </div>
                        <p class="pn-venue-location">
                            <i class="bi bi-geo-alt me-1"></i>Velachery, Chennai
                        </p>
                        <div class="pn-venue-features">
                            <span class="pn-feature-tag"><i class="bi bi-circle me-1"></i>Box Cricket</span>
                            <span class="pn-feature-tag"><i class="bi bi-droplet me-1"></i>Washroom</span>
                            <span class="pn-feature-tag"><i class="bi bi-cup-hot me-1"></i>Cafeteria</span>
                        </div>
                        <div class="pn-venue-footer">
                            <div class="pn-venue-price">
                                <span class="pn-price-label">Starting from</span>
                                <span class="pn-price-amount">₹1,800<small>/hour</small></span>
                            </div>
                            <a href="#" class="btn pn-btn-primary pn-btn-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="pn-venue-card">
                    <div class="pn-venue-badge pn-badge-new">
                        <i class="bi bi-lightning-fill"></i> New
                    </div>
                    <div class="pn-venue-image">
                        <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&q=80" alt="Badminton Arena" class="w-100">
                        <div class="pn-venue-overlay">
                            <a href="#" class="btn pn-btn-white pn-btn-sm">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                    <div class="pn-venue-content">
                        <div class="pn-venue-header">
                            <h4 class="pn-venue-name">SmashPro Badminton Arena</h4>
                            <div class="pn-venue-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>5.0</span>
                            </div>
                        </div>
                        <p class="pn-venue-location">
                            <i class="bi bi-geo-alt me-1"></i>T. Nagar, Chennai
                        </p>
                        <div class="pn-venue-features">
                            <span class="pn-feature-tag"><i class="bi bi-snow me-1"></i>AC Indoor</span>
                            <span class="pn-feature-tag"><i class="bi bi-wifi me-1"></i>WiFi</span>
                            <span class="pn-feature-tag"><i class="bi bi-shop me-1"></i>Pro Shop</span>
                        </div>
                        <div class="pn-venue-footer">
                            <div class="pn-venue-price">
                                <span class="pn-price-label">Starting from</span>
                                <span class="pn-price-amount">₹900<small>/hour</small></span>
                            </div>
                            <a href="#" class="btn pn-btn-primary pn-btn-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="#" class="btn pn-btn-outline-primary pn-btn-lg">
                <i class="bi bi-grid-3x3-gap me-2"></i>View All Venues
            </a>
        </div>
    </div>
</section>

<!-- Live Slot Availability -->
<section class="pn-section pn-live-slots">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-lightning-charge-fill me-2"></i>Real-Time Updates
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Live <span class="pn-text-gradient">Slot Availability</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Check live availability and book instantly
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                <div class="pn-slot-card">
                    <div class="pn-slot-header">
                        <h5 class="pn-slot-venue">Elite Sports Arena</h5>
                        <span class="pn-slot-date"><i class="bi bi-calendar3 me-1"></i>Today</span>
                    </div>
                    <div class="pn-slot-grid">
                        <div class="pn-slot-item pn-slot-booked">
                            <span class="pn-slot-time">6:00 AM</span>
                            <span class="pn-slot-status">Booked</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">7:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">8:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-filling">
                            <span class="pn-slot-time">9:00 AM</span>
                            <span class="pn-slot-status">Filling Fast</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">10:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-booked">
                            <span class="pn-slot-time">11:00 AM</span>
                            <span class="pn-slot-status">Booked</span>
                        </div>
                    </div>
                    <a href="#" class="btn pn-btn-primary w-100 mt-3">View All Slots</a>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pn-slot-card">
                    <div class="pn-slot-header">
                        <h5 class="pn-slot-venue">Champions Cricket Ground</h5>
                        <span class="pn-slot-date"><i class="bi bi-calendar3 me-1"></i>Today</span>
                    </div>
                    <div class="pn-slot-grid">
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">6:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-filling">
                            <span class="pn-slot-time">7:00 AM</span>
                            <span class="pn-slot-status">Filling Fast</span>
                        </div>
                        <div class="pn-slot-item pn-slot-booked">
                            <span class="pn-slot-time">8:00 AM</span>
                            <span class="pn-slot-status">Booked</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">9:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">10:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-filling">
                            <span class="pn-slot-time">11:00 AM</span>
                            <span class="pn-slot-status">Filling Fast</span>
                        </div>
                    </div>
                    <a href="#" class="btn pn-btn-primary w-100 mt-3">View All Slots</a>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
                <div class="pn-slot-card">
                    <div class="pn-slot-header">
                        <h5 class="pn-slot-venue">Pro Badminton Center</h5>
                        <span class="pn-slot-date"><i class="bi bi-calendar3 me-1"></i>Today</span>
                    </div>
                    <div class="pn-slot-grid">
                        <div class="pn-slot-item pn-slot-booked">
                            <span class="pn-slot-time">6:00 AM</span>
                            <span class="pn-slot-status">Booked</span>
                        </div>
                        <div class="pn-slot-item pn-slot-booked">
                            <span class="pn-slot-time">7:00 AM</span>
                            <span class="pn-slot-status">Booked</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">8:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">9:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                        <div class="pn-slot-item pn-slot-filling">
                            <span class="pn-slot-time">10:00 AM</span>
                            <span class="pn-slot-status">Filling Fast</span>
                        </div>
                        <div class="pn-slot-item pn-slot-available">
                            <span class="pn-slot-time">11:00 AM</span>
                            <span class="pn-slot-status">Available</span>
                        </div>
                    </div>
                    <a href="#" class="btn pn-btn-primary w-100 mt-3">View All Slots</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- How It Works Section -->
<section id="how-it-works" class="pn-section pn-process-flow-section bg-gradient">
    <div class="container">

        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge pn-badge-white" data-aos="fade-up">
                <i class="bi bi-lightbulb-fill me-2"></i>Simple Process
            </span>

            <h2 class="pn-section-title text-white" data-aos="fade-up" data-aos-delay="100">
                How It <span class="pn-text-gradient-white">Works</span>
            </h2>

            <p class="pn-section-subtitle text-white-50" data-aos="fade-up" data-aos-delay="200">
                Book your favorite ground in 3 simple steps
            </p>
        </div>

        <div class="row g-5 align-items-center">

            <!-- Step 1 -->
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                <div class="pn-process-flow-card">

                    <div class="pn-process-flow-number">01</div>

                    <div class="pn-process-flow-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <h4 class="pn-process-flow-title">
                        Search & Explore
                    </h4>

                    <p class="pn-process-flow-description">
                        Browse through our verified venues, compare prices,
                        and check real-time availability
                    </p>

                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pn-process-flow-card pn-process-flow-card-active">

                    <div class="pn-process-flow-number">02</div>

                    <div class="pn-process-flow-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <h4 class="pn-process-flow-title">
                        Book Your Slot
                    </h4>

                    <p class="pn-process-flow-description">
                        Select your preferred date and time slot,
                        make secure payment and get instant confirmation
                    </p>

                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
                <div class="pn-process-flow-card">

                    <div class="pn-process-flow-number">03</div>

                    <div class="pn-process-flow-icon">
                        <i class="bi bi-trophy"></i>
                    </div>

                    <h4 class="pn-process-flow-title">
                        Play & Enjoy
                    </h4>

                    <p class="pn-process-flow-description">
                        Show your booking confirmation at the venue
                        and enjoy your game hassle-free
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Special Offers / Memberships -->
<section id="offers" class="pn-section pn-offers-section bg-light">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-tag-fill me-2"></i>Limited Time
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Special <span class="pn-text-gradient">Offers</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Exclusive deals and membership plans for our players
            </p>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="pn-offer-card pn-offer-hot">
                    <div class="pn-offer-ribbon">
                        <i class="bi bi-fire"></i> Hot Deal
                    </div>
                    <div class="pn-offer-icon">
                        <i class="bi bi-percent"></i>
                    </div>
                    <h4 class="pn-offer-title">Weekend Special</h4>
                    <p class="pn-offer-discount">30% OFF</p>
                    <p class="pn-offer-description">Book any ground for weekend slots and get instant 30% discount</p>
                    <ul class="pn-offer-features">
                        <li><i class="bi bi-check-circle-fill"></i>Valid on Sat & Sun</li>
                        <li><i class="bi bi-check-circle-fill"></i>All venues included</li>
                        <li><i class="bi bi-check-circle-fill"></i>Limited slots</li>
                    </ul>
                    <a href="#" class="btn pn-btn-primary w-100">Claim Offer</a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="pn-offer-card pn-offer-premium">
                    <div class="pn-offer-ribbon pn-ribbon-premium">
                        <i class="bi bi-star-fill"></i> Premium
                    </div>
                    <div class="pn-offer-icon">
                        <i class="bi bi-gem"></i>
                    </div>
                    <h4 class="pn-offer-title">Monthly Pass</h4>
                    <p class="pn-offer-discount">₹5,999/mo</p>
                    <p class="pn-offer-description">Unlimited bookings for an entire month at selected venues</p>
                    <ul class="pn-offer-features">
                        <li><i class="bi bi-check-circle-fill"></i>Unlimited slots</li>
                        <li><i class="bi bi-check-circle-fill"></i>Priority booking</li>
                        <li><i class="bi bi-check-circle-fill"></i>Free cancellation</li>
                    </ul>
                    <a href="#" class="btn pn-btn-primary w-100">Get Started</a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="pn-offer-card">
                    <div class="pn-offer-ribbon">
                        <i class="bi bi-people-fill"></i> Group
                    </div>
                    <div class="pn-offer-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="pn-offer-title">Team Package</h4>
                    <p class="pn-offer-discount">Save 40%</p>
                    <p class="pn-offer-description">Book 10 slots in advance and get 4 slots absolutely free</p>
                    <ul class="pn-offer-features">
                        <li><i class="bi bi-check-circle-fill"></i>Flexible scheduling</li>
                        <li><i class="bi bi-check-circle-fill"></i>Valid for 3 months</li>
                        <li><i class="bi bi-check-circle-fill"></i>Transferable</li>
                    </ul>
                    <a href="#" class="btn pn-btn-primary w-100">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tournament & Events Section -->
<section class="pn-section pn-events-section">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-calendar-event me-2"></i>Upcoming Events
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Tournaments & <span class="pn-text-gradient">Events</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Join exciting tournaments and win amazing prizes
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <div class="pn-event-card pn-event-featured">
                    <div class="pn-event-image">
                        <img src="https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&w=800&q=80" alt="Football Tournament">
                        <div class="pn-event-date">
                            <span class="pn-date-day">15</span>
                            <span class="pn-date-month">Jun</span>
                        </div>
                    </div>
                    <div class="pn-event-content">
                        <div class="pn-event-meta">
                            <span class="pn-event-category"><i class="bi bi-circle-fill me-1"></i>Football</span>
                            <span class="pn-event-prize"><i class="bi bi-trophy-fill me-1"></i>₹50,000 Prize</span>
                        </div>
                        <h4 class="pn-event-title">Chennai Premier League 2024</h4>
                        <p class="pn-event-description">Inter-city 5-a-side football tournament. 16 teams competing for the championship.</p>
                        <div class="pn-event-details">
                            <div class="pn-event-info">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>PlayNow Arena, Anna Nagar</span>
                            </div>
                            <div class="pn-event-info">
                                <i class="bi bi-people-fill"></i>
                                <span>12/16 Teams Registered</span>
                            </div>
                        </div>
                        <a href="#" class="btn pn-btn-primary">Register Now</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-12" data-aos="fade-left" data-aos-delay="200">
                        <div class="pn-event-card-small">
                            <div class="pn-event-small-date">
                                <span class="pn-date-day">22</span>
                                <span class="pn-date-month">Jun</span>
                            </div>
                            <div class="pn-event-small-content">
                                <span class="pn-event-category"><i class="bi bi-circle me-1"></i>Cricket</span>
                                <h5 class="pn-event-small-title">Box Cricket Championship</h5>
                                <div class="pn-event-small-meta">
                                    <span><i class="bi bi-geo-alt"></i>Velachery Ground</span>
                                    <span><i class="bi bi-trophy"></i>₹30,000</span>
                                </div>
                            </div>
                            <a href="#" class="btn pn-btn-outline-primary pn-btn-sm">View</a>
                        </div>
                    </div>
                    
                    <div class="col-12" data-aos="fade-left" data-aos-delay="300">
                        <div class="pn-event-card-small">
                            <div class="pn-event-small-date">
                                <span class="pn-date-day">28</span>
                                <span class="pn-date-month">Jun</span>
                            </div>
                            <div class="pn-event-small-content">
                                <span class="pn-event-category"><i class="bi bi-egg me-1"></i>Badminton</span>
                                <h5 class="pn-event-small-title">Doubles Badminton Smash</h5>
                                <div class="pn-event-small-meta">
                                    <span><i class="bi bi-geo-alt"></i>T. Nagar Arena</span>
                                    <span><i class="bi bi-trophy"></i>₹20,000</span>
                                </div>
                            </div>
                            <a href="#" class="btn pn-btn-outline-primary pn-btn-sm">View</a>
                        </div>
                    </div>
                    
                    <div class="col-12" data-aos="fade-left" data-aos-delay="400">
                        <div class="pn-event-card-small">
                            <div class="pn-event-small-date">
                                <span class="pn-date-day">05</span>
                                <span class="pn-date-month">Jul</span>
                            </div>
                            <div class="pn-event-small-content">
                                <span class="pn-event-category"><i class="bi bi-circle-fill me-1"></i>Football</span>
                                <h5 class="pn-event-small-title">Corporate Football League</h5>
                                <div class="pn-event-small-meta">
                                    <span><i class="bi bi-geo-alt"></i>Multiple Venues</span>
                                    <span><i class="bi bi-trophy"></i>₹1,00,000</span>
                                </div>
                            </div>
                            <a href="#" class="btn pn-btn-outline-primary pn-btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="#" class="btn pn-btn-outline-primary pn-btn-lg">
                <i class="bi bi-calendar-event me-2"></i>View All Events
            </a>
        </div>
    </div>
</section>

<!-- Reviews & Testimonials -->
<section id="testimonials" class="pn-section pn-testimonials-section bg-light">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-chat-quote-fill me-2"></i>What Players Say
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Player <span class="pn-text-gradient">Reviews</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Trusted by thousands of sports enthusiasts across India
            </p>
        </div>
        
        <div class="pn-testimonials-slider" data-aos="fade-up" data-aos-delay="300">
            <div class="swiper pn-testimonials-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="pn-testimonial-card">
                            <div class="pn-testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="pn-testimonial-text">
                                "PlayNow has completely changed how we book our weekly football matches. The platform is super easy to use, and we always find great venues near our office!"
                            </p>
                            <div class="pn-testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=12" alt="Rajesh Kumar">
                                <div class="pn-author-info">
                                    <h5 class="pn-author-name">Rajesh Kumar</h5>
                                    <p class="pn-author-role">Football Enthusiast</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="pn-testimonial-card">
                            <div class="pn-testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="pn-testimonial-text">
                                "Best sports booking platform in Chennai! Real-time slot availability and instant confirmation makes planning our cricket matches so much easier."
                            </p>
                            <div class="pn-testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=33" alt="Priya Sharma">
                                <div class="pn-author-info">
                                    <h5 class="pn-author-name">Priya Sharma</h5>
                                    <p class="pn-author-role">Cricket Team Captain</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="pn-testimonial-card">
                            <div class="pn-testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="pn-testimonial-text">
                                "I've been using PlayNow for my badminton sessions for 6 months now. The quality of venues and hassle-free booking process is amazing!"
                            </p>
                            <div class="pn-testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=25" alt="Arjun Menon">
                                <div class="pn-author-info">
                                    <h5 class="pn-author-name">Arjun Menon</h5>
                                    <p class="pn-author-role">Badminton Player</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="pn-testimonial-card">
                            <div class="pn-testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="pn-testimonial-text">
                                "As a vendor, listing my turf on PlayNow was the best decision. I get consistent bookings and the platform handles everything smoothly."
                            </p>
                            <div class="pn-testimonial-author">
                                <img src="https://i.pravatar.cc/100?img=51" alt="Vikram Singh">
                                <div class="pn-author-info">
                                    <h5 class="pn-author-name">Vikram Singh</h5>
                                    <p class="pn-author-role">Turf Owner</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination pn-testimonial-pagination"></div>
            </div>
        </div>
        
        <div class="pn-trust-badges mt-5" data-aos="fade-up">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3">
                    <div class="pn-trust-badge">
                        <i class="bi bi-shield-check"></i>
                        <p>Verified Venues</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-trust-badge">
                        <i class="bi bi-lock-fill"></i>
                        <p>Secure Payments</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-trust-badge">
                        <i class="bi bi-headset"></i>
                        <p>24/7 Support</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="pn-trust-badge">
                        <i class="bi bi-arrow-clockwise"></i>
                        <p>Easy Cancellation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us / Benefits -->
<section class="pn-section pn-benefits-section">
    <div class="container">
        <div class="pn-section-header text-center mb-5">
            <span class="pn-section-badge" data-aos="fade-up">
                <i class="bi bi-heart-fill me-2"></i>Why Us
            </span>
            <h2 class="pn-section-title" data-aos="fade-up" data-aos-delay="100">
                Why Choose <span class="pn-text-gradient">PlayNow</span>
            </h2>
            <p class="pn-section-subtitle" data-aos="fade-up" data-aos-delay="200">
                Experience the difference with India's leading sports booking platform
            </p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="pn-benefit-card">
                    <div class="pn-benefit-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4 class="pn-benefit-title">Flexible Timing</h4>
                    <p class="pn-benefit-description">Book hourly slots that fit your schedule perfectly</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="pn-benefit-card">
                    <div class="pn-benefit-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="pn-benefit-title">Nearby Venues</h4>
                    <p class="pn-benefit-description">Find and compare sports grounds close to your location</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="pn-benefit-card">
                    <div class="pn-benefit-icon">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                    <h4 class="pn-benefit-title">Verified Partners</h4>
                    <p class="pn-benefit-description">Play only at admin-verified, trusted venues</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="pn-benefit-card">
                    <div class="pn-benefit-icon">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <h4 class="pn-benefit-title">Instant Booking</h4>
                    <p class="pn-benefit-description">Get instant confirmation with no phone calls needed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vendor CTA Section -->
<section class="pn-section pn-vendor-cta">
    <div class="container">
        <div class="pn-vendor-card" data-aos="zoom-in">
            <div class="pn-vendor-bg"></div>
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="pn-vendor-content">
                        <div class="pn-vendor-icon">
                            <i class="bi bi-shop"></i>
                        </div>
                        <h2 class="pn-vendor-title">Own a Sports Venue?</h2>
                        <p class="pn-vendor-description">
                            List your turf, cricket ground, or sports arena on PlayNow and reach thousands of active players. Boost your bookings and grow your business with India's #1 sports booking platform!
                        </p>
                        <ul class="pn-vendor-features">
                            <li><i class="bi bi-check-circle-fill"></i>Free listing for limited time</li>
                            <li><i class="bi bi-check-circle-fill"></i>Reach 10,000+ active players</li>
                            <li><i class="bi bi-check-circle-fill"></i>Easy booking management</li>
                            <li><i class="bi bi-check-circle-fill"></i>Instant payment settlement</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('vendor.register.form') }}" class="btn pn-btn-white pn-btn-lg">
                        <i class="bi bi-arrow-right-circle me-2"></i>Register Your Venue
                    </a>
                    <p class="pn-vendor-note mt-3">Join 150+ venue partners</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="pn-section pn-newsletter-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="pn-newsletter-card" data-aos="fade-up">
                    <div class="pn-newsletter-icon">
                        <i class="bi bi-envelope-heart"></i>
                    </div>
                    <h3 class="pn-newsletter-title">Stay Updated with PlayNow</h3>
                    <p class="pn-newsletter-description">
                        Get the latest updates on new venues, special offers, and upcoming tournaments
                    </p>
                    <form class="pn-newsletter-form">
                        <div class="pn-newsletter-input-group">
                            <i class="bi bi-envelope"></i>
                            <input type="email" class="pn-newsletter-input" placeholder="Enter your email address" required>
                            <button type="submit" class="btn pn-btn-primary">
                                Subscribe
                            </button>
                        </div>
                    </form>
                    <p class="pn-newsletter-privacy">
                        <i class="bi bi-shield-check me-1"></i>
                        We respect your privacy. Unsubscribe anytime.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
