<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Patrik Solutions')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/logos/patrick_logo.png') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#6366f1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="{{ asset('assets/logos/patrick_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 (load first - base styles) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Modern UI CSS (load after - can override non-critical styles) -->
    <link href="{{ asset('css/modern-ui.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Additional Styles -->
    <style>
        /* Enhanced Typography - Matching STU Alumni Style */
        html {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        input[type="number"],
        input[type="date"],
        input[type="time"],
        textarea,
        select {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 15px;
            line-height: 1.5;
            letter-spacing: -0.01em;
        }
        
        input::placeholder,
        textarea::placeholder {
            color: #9CA3AF;
            opacity: 1;
            font-weight: 400;
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        
        .nav-link {
            font-size: 16px !important;
            letter-spacing: -0.01em;
        }
        
        .dropdown-item {
            font-size: 16px;
            letter-spacing: -0.01em;
        }
        
        .btn {
            font-size: 15px;
            letter-spacing: -0.01em;
            font-weight: 600;
        }
        
        .lead {
            font-size: 1.125rem;
            line-height: 1.7;
            letter-spacing: -0.01em;
        }
        
        /* Responsive font sizes */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem !important;
            }
            
            .hero-subtitle {
                font-size: 1rem !important;
            }
            
            .section-title h1,
            .section-title h2 {
                font-size: 1.75rem !important;
            }
        }
        
    </style>
    <style>
        /* CRITICAL FIX: Ensure navbar visibility - override any conflicting CSS */
        .navbar.navbar-expand-lg {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Large screens (≥992px) - navbar should always be visible */
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-collapse {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                flex-basis: auto !important;
                flex-grow: 1 !important;
                align-items: center !important;
            }
            
            .navbar-expand-lg .navbar-nav {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                flex-direction: row !important;
            }
            
            .navbar-expand-lg .nav-item {
                display: list-item !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
        .navbar-expand-lg .nav-link {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* User dropdown link - ensure horizontal layout */
        #userDropdown {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }
        
        #userDropdown img {
            flex-shrink: 0 !important;
            display: block !important;
        }
        
        #userDropdown span {
            display: inline-block !important;
            white-space: nowrap !important;
        }
        }
        
        /* Mobile screens (<992px) - use Bootstrap's collapse mechanism */
        @media (max-width: 991.98px) {
            /* Default state - hidden */
            .navbar-expand-lg .navbar-collapse:not(.show):not(.collapsing) {
                display: none !important;
            }
            
            /* When toggled open - visible */
            .navbar-expand-lg .navbar-collapse.show,
            .navbar-expand-lg .navbar-collapse.collapsing {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* Ensure nav items are visible when collapsed is open */
            .navbar-expand-lg .navbar-collapse.show .navbar-nav,
            .navbar-expand-lg .navbar-collapse.collapsing .navbar-nav {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                flex-direction: column !important;
            }
            
            .navbar-expand-lg .navbar-collapse.show .nav-item,
            .navbar-expand-lg .navbar-collapse.collapsing .nav-item {
                display: list-item !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .navbar-expand-lg .navbar-collapse.show .nav-link,
            .navbar-expand-lg .navbar-collapse.collapsing .nav-link {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }
        
        /* Active and hover states */
        .navbar-nav .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-radius: 4px;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-radius: 4px;
        }
        
        /* Toggler styles - hidden on large screens, visible on mobile */
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        
        /* Hide toggler on large screens (Bootstrap default behavior) */
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-toggler {
                display: none !important;
            }
        }
        
        /* Show toggler on mobile screens */
        @media (max-width: 991.98px) {
            .navbar-toggler {
                display: block !important;
                visibility: visible !important;
            }
        }
        
        /* Ensure Bootstrap dropdowns work correctly */
        .dropdown-menu:not(.show) {
            display: none !important;
        }
        
        .dropdown-menu.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Modern Mega Menu Styles */
        .modern-mega-menu {
            background: white;
            margin-top: 0.5rem !important;
        }
        
        .modern-dropdown-item {
            display: block;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: #111827;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .modern-dropdown-item:hover {
            background: rgba(102, 126, 234, 0.08);
            border-color: rgba(102, 126, 234, 0.2);
            transform: translateX(2px);
            color: var(--primary-color);
        }
        
        .dropdown-icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 10px;
            color: var(--primary-color);
            font-size: 1.125rem;
            flex-shrink: 0;
        }
        
        .modern-dropdown-item:hover .dropdown-icon-wrapper {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            transform: scale(1.05);
        }
        
        /* Responsive mega menu */
        @media (max-width: 991.98px) {
            .modern-mega-menu {
                min-width: 100% !important;
                max-width: 100%;
            }
            
            .modern-mega-menu .row {
                margin: 0;
            }
            
            .modern-mega-menu .col-md-6 {
                padding: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
    @stack('styles')
    @yield('styles')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="overflow-x: hidden;">
    <div class="min-h-screen" style="background: #f9fafb; width: 100%; overflow-x: hidden;">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg text-white shadow-lg" style="background: var(--primary-color); position: relative; z-index: 1030;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center text-white text-decoration-none" href="{{ route('index') }}">
                    <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions Logo" class="me-3" style="height: 40px; width: 40px; border-radius: 8px;">
                    <span class="fs-5 fw-bold">Patrik Solutions</span>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="color: white; z-index: 1031;">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav" style="z-index: 1030;">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}" href="{{ route('index') }}" style="font-size: 1rem; font-weight: 500;">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog-posts') }}" style="font-size: 1rem; font-weight: 500;">
                                <i class="fas fa-blog me-1"></i>Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('course*') ? 'active' : '' }}" href="{{ route('courses') }}" style="font-size: 1rem; font-weight: 500;">
                                <i class="fas fa-graduation-cap me-1"></i>Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('index') }}#ai-training" style="font-size: 1rem; font-weight: 500;">
                                <i class="fas fa-robot me-1"></i>AI Training
                            </a>
                        </li>
                        
                        <!-- Free Tools Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white {{ request()->routeIs('*calculator*') || request()->routeIs('mortgage*') || request()->routeIs('debt-snowball*') || request()->routeIs('net-worth*') || request()->routeIs('compound-interest*') ? 'active' : '' }}" href="#" id="toolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1rem; font-weight: 500;">
                                <i class="fas fa-calculator me-1"></i>Free Tools
                            </a>
                            <div class="dropdown-menu dropdown-menu-end modern-mega-menu" aria-labelledby="toolsDropdown" style="min-width: 700px; padding: 1.5rem; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); border: 1px solid rgba(0, 0, 0, 0.05);">
                                <div class="row g-3">
                                    <!-- Financial Calculators Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="fw-bold mb-3" style="color: var(--primary-color); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                                <i class="fas fa-chart-pie me-2"></i>Financial Calculators
                                            </h6>
                                            <div class="d-flex flex-column gap-2">
                                                <a class="modern-dropdown-item" href="{{ route('budget_calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-calculator"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Budget Calculator</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Track income & expenses</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                @auth
                                                <a class="modern-dropdown-item" href="{{ route('budget_calculator.list') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-list"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">My Budgets</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">View saved budgets</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                @endauth
                                                <a class="modern-dropdown-item" href="{{ route('debt-snowball-calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-snowflake"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Debt Snowball</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Pay off debt faster</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="modern-dropdown-item" href="{{ route('investment_calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-chart-line"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Investment Calculator</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Calculate returns</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="modern-dropdown-item" href="{{ route('retirement_calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-piggy-bank"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Retirement Calculator</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Plan for retirement</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- More Calculators & Real Estate Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="fw-bold mb-3" style="color: var(--primary-color); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                                <i class="fas fa-calculator me-2"></i>More Tools
                                            </h6>
                                            <div class="d-flex flex-column gap-2">
                                                <a class="modern-dropdown-item" href="{{ route('net-worth-calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-wallet"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Net Worth Calculator</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Track your wealth</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="modern-dropdown-item" href="{{ route('compound-interest-calculator.index') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-percent"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Compound Interest</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">See money grow</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 pt-3" style="border-top: 1px solid #e5e7eb;">
                                            <h6 class="fw-bold mb-3" style="color: var(--primary-color); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                                <i class="fas fa-home me-2"></i>Real Estate
                                            </h6>
                                            <div class="d-flex flex-column gap-2">
                                                <a class="modern-dropdown-item" href="{{ route('mortgage-calculator') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-home"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Mortgage Calculator</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Calculate payments</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="modern-dropdown-item" href="{{ route('mortgage.payoff') }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown-icon-wrapper me-3">
                                                            <i class="fas fa-key"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold" style="font-size: 0.9375rem;">Mortgage Payoff</div>
                                                            <div class="text-muted" style="font-size: 0.8125rem;">Pay off faster</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @auth
                            @if(Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('admin-dashboard') ? 'active' : '' }}" href="{{ route('admin-dashboard') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-edit me-1"></i>Blogs
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-users me-1"></i>Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('youtube.*') ? 'active' : '' }}" href="{{ route('youtube.index') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fab fa-youtube me-1"></i>YouTube
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-envelope me-1"></i>Contacts
                                    </a>
                                </li>
                                @if(Route::has('admin.notifications.create'))
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.create') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-paper-plane me-1"></i>Notifications
                                    </a>
                                </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" style="font-size: 1rem; font-weight: 500;">
                                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <ul class="navbar-nav">
                        @auth
                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1rem;">
                                    <img class="rounded-circle" 
                                         src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=FFFFFF&background=667eea' }}" 
                                         alt="{{ Auth::user()->name }}"
                                         style="height: 32px; width: 32px; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); display: inline-block; vertical-align: middle; margin-right: 0.5rem;"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=667eea'">
                                    <span class="d-none d-lg-inline" style="display: inline-block; vertical-align: middle; white-space: nowrap;">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2" style="color: var(--primary-color);"></i>Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>Profile
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}" style="font-size: 1rem; font-weight: 500;">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-danger ms-2" href="{{ route('register') }}" style="font-size: 1rem; font-weight: 500;">
                                    <i class="fas fa-user-plus me-1"></i>Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main style="padding: 0;">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>
</html>
