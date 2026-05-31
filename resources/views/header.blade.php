    <!--------------- Header Section --------------->
    <header id="header" class="pn-header">
        <!-- Desktop Header -->
        <div class="pn-header-desktop d-none d-lg-block">
            <div class="container-fluid px-4">
                <div class="row align-items-center py-3">
                    <!-- Logo -->
                    <div class="col-auto">
                        <a href="{{route('home')}}" class="pn-logo">
                            <img src="{{asset('logo.png')}}" alt="PlayNow - Book Your Ground" class="pn-logo-img">
                        </a>
                    </div>
                    
                    <!-- Search Section -->
                    <div class="col">
                        <div class="pn-search-wrapper">
                            <div class="pn-search-container">
                                <!-- Search Input -->
                                <div class="pn-search-input-group">
                                    <i class="bi bi-search pn-search-icon"></i>
                                    <input 
                                        type="text" 
                                        class="pn-search-input" 
                                        placeholder="Search grounds, turf, or venues..."
                                        aria-label="Search"
                                    >
                                </div>
                                
                                <!-- Divider -->
                                <div class="pn-search-divider"></div>
                                
                                <!-- Location Dropdown -->
                                <div class="pn-location-dropdown">
                                    <button 
                                        type="button" 
                                        class="pn-location-btn dropdown-toggle" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false"
                                    >
                                        <i class="bi bi-geo-alt me-1"></i>
                                        <span class="pn-location-text">Chennai</span>
                                    </button>
                                    <ul class="dropdown-menu pn-location-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt-fill me-2"></i>Bangalore</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt-fill me-2"></i>Hyderabad</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt-fill me-2"></i>Mumbai</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt-fill me-2"></i>Delhi</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-geo-alt-fill me-2"></i>Pune</a></li>
                                    </ul>
                                </div>
                                
                                <!-- Search Button -->
                                <button class="pn-search-btn">
                                    <i class="bi bi-search me-2"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="col-auto">
                        <div class="pn-user-menu dropdown">
                            <button 
                                class="pn-user-btn dropdown-toggle" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                            >
                                <i class="bi bi-person-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end pn-user-dropdown">
                                @auth('web')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customers.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>My Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person-circle me-2"></i>My Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('customers.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    <li class="dropdown-header">User Account</li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customers.login') }}">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>User Login
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('customers.register') }}">
                                            <i class="bi bi-person-plus me-2"></i>User Register
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="dropdown-header">Vendor Account</li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('vendor.login') }}">
                                            <i class="bi bi-shop me-2"></i>Vendor Login
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('vendor.register') }}">
                                            <i class="bi bi-shop-window me-2"></i>Vendor Register
                                        </a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Header -->
        <div class="pn-header-mobile d-block d-lg-none">
            <div class="container-fluid">
                <div class="row align-items-center py-3 px-2">
                    <!-- Menu Button -->
                    <div class="col-auto">
                        <button 
                            class="pn-mobile-menu-btn" 
                            type="button" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#mobileMenu"
                            aria-controls="mobileMenu"
                        >
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                    
                    <!-- Mobile Logo -->
                    <div class="col text-center">
                        <a href="{{route('home')}}" class="pn-mobile-logo">
                            <img src="{{asset('logo.png')}}" alt="PlayNow" class="pn-mobile-logo-img">
                        </a>
                    </div>
                    
                    <!-- User Icon -->
                    <div class="col-auto">
                        <button 
                            class="pn-mobile-user-btn dropdown-toggle" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false"
                        >
                            <i class="bi bi-person-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end pn-user-dropdown">
                            @auth('web')
                                <li>
                                    <a class="dropdown-item" href="{{ route('customers.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>My Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i>My Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customers.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="dropdown-header">User Account</li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customers.login') }}">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>User Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customers.register') }}">
                                        <i class="bi bi-person-plus me-2"></i>User Register
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header">Vendor Account</li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('vendor.login') }}">
                                        <i class="bi bi-shop me-2"></i>Vendor Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('vendor.register') }}">
                                        <i class="bi bi-shop-window me-2"></i>Vendor Register
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
                
                <!-- Mobile Search Bar -->
                <div class="row px-2 pb-3">
                    <div class="col-12">
                        <div class="pn-mobile-search">
                            <i class="bi bi-search pn-mobile-search-icon"></i>
                            <input 
                                type="text" 
                                class="pn-mobile-search-input" 
                                placeholder="Search grounds..."
                            >
                            <button class="pn-mobile-location-btn dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-geo-alt"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Chennai</a></li>
                                <li><a class="dropdown-item" href="#">Bangalore</a></li>
                                <li><a class="dropdown-item" href="#">Hyderabad</a></li>
                                <li><a class="dropdown-item" href="#">Mumbai</a></li>
                                <li><a class="dropdown-item" href="#">Delhi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Offcanvas Menu -->
        <div class="offcanvas offcanvas-start pn-mobile-offcanvas" tabindex="-1" id="mobileMenu">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="pn-mobile-nav">
                    <li class="pn-mobile-nav-item">
                        <a href="{{route('home')}}" class="pn-mobile-nav-link">
                            <i class="bi bi-house-door me-3"></i>
                            Home
                        </a>
                    </li>
                    <li class="pn-mobile-nav-item">
                        <a href="#" class="pn-mobile-nav-link">
                            <i class="bi bi-trophy me-3"></i>
                            Football Grounds
                        </a>
                    </li>
                    <li class="pn-mobile-nav-item">
                        <a href="#" class="pn-mobile-nav-link">
                            <i class="bi bi-circle me-3"></i>
                            Cricket Grounds
                        </a>
                    </li>
                    <li class="pn-mobile-nav-item">
                        <a href="#" class="pn-mobile-nav-link">
                            <i class="bi bi-grid-3x3 me-3"></i>
                            Turf/Indoor Courts
                        </a>
                    </li>
                    <li class="pn-mobile-nav-item">
                        <a href="#" class="pn-mobile-nav-link">
                            <i class="bi bi-star me-3"></i>
                            Featured Venues
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!--------------- Header Section End --------------->