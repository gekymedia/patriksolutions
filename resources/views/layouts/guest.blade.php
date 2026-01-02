<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Patrik Solutions')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/logos/patrick_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Modern UI CSS -->
    <link href="{{ asset('css/modern-ui.css') }}" rel="stylesheet">

    <!-- Additional Styles -->
    @stack('styles')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Modern Navigation -->
    <nav class="modern-navbar navbar navbar-expand-lg">
        <div class="container">
            <a href="{{ route('index') }}" class="navbar-brand">
                <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions Logo">
                <span>Patrik Solutions</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav d-flex align-items-center gap-2">
                    <a href="{{ route('index') }}" class="modern-nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                   
                    <!-- Calculators Dropdown -->
                    <div class="nav-dropdown dropdown">
                        <a href="#" class="modern-nav-link dropdown-toggle {{ request()->routeIs('*calculator*') || request()->routeIs('mortgage*') || request()->routeIs('debt-snowball*') || request()->routeIs('net-worth*') || request()->routeIs('compound-interest*') ? 'active' : '' }}" 
                           id="calculatorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-calculator"></i>
                            <span>Calculators</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-modern" aria-labelledby="calculatorsDropdown">
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('budget_calculator.index') }}">
                                <i class="fas fa-calculator me-2"></i> Budget Calculator
                            </a></li>
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('investment_calculator.index') }}">
                                <i class="fas fa-chart-line me-2"></i> Investment Calculator
                            </a></li>
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('retirement_calculator.index') }}">
                                <i class="fas fa-piggy-bank me-2"></i> Retirement Calculator
                            </a></li>
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('mortgage-calculator') }}">
                                <i class="fas fa-home me-2"></i> Mortgage Calculator
                            </a></li>
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('mortgage.payoff') }}">
                                <i class="fas fa-key me-2"></i> Mortgage Payoff
                            </a></li>
                            @if(Route::has('debt-snowball-calculator.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('debt-snowball-calculator.index') }}">
                                <i class="fas fa-snowflake me-2"></i> Debt Snowball
                            </a></li>
                            @endif
                            @if(Route::has('net-worth-calculator.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('net-worth-calculator.index') }}">
                                <i class="fas fa-wallet me-2"></i> Net Worth
                            </a></li>
                            @endif
                            @if(Route::has('compound-interest-calculator.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('compound-interest-calculator.index') }}">
                                <i class="fas fa-percent me-2"></i> Compound Interest
                            </a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- Resources Dropdown -->
                    <div class="nav-dropdown dropdown">
                        <a href="#" class="modern-nav-link dropdown-toggle {{ request()->routeIs('blog*') || request()->routeIs('course*') || request()->routeIs('financial-*') ? 'active' : '' }}" 
                           id="resourcesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-book"></i>
                            <span>Resources</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-modern" aria-labelledby="resourcesDropdown">
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('blog-posts') }}">
                                <i class="fas fa-blog me-2"></i> Blog
                            </a></li>
                            @if(Route::has('course.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('course.index') }}">
                                <i class="fas fa-graduation-cap me-2"></i> Courses
                            </a></li>
                            @endif
                            @if(Route::has('financial-assessment.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('financial-assessment.index') }}">
                                <i class="fas fa-clipboard-check me-2"></i> Financial Assessment
                            </a></li>
                            @endif
                            @if(Route::has('financial-coaching.index'))
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('financial-coaching.index') }}">
                                <i class="fas fa-user-tie me-2"></i> Financial Coaching
                            </a></li>
                            @endif
                        </ul>
                    </div>
                    
                    @auth
                        <div class="dropdown ms-2">
                            <button class="btn btn-modern btn-modern-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                                <li><a class="dropdown-item dropdown-item-modern" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item dropdown-item-modern" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item dropdown-item-modern text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-modern btn-modern-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-modern" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2);">
                            <i class="fas fa-user-plus"></i>
                            <span>Register</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <!-- End of Modern Nav -->

    <!-- Page Content -->
    <div class="min-h-screen" style="background: #f9fafb; padding-top: 2rem;">
        <main>
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ensure navbar is always visible
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.modern-navbar');
            if (navbar) {
                navbar.style.display = 'block';
                navbar.style.visibility = 'visible';
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.modern-navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                navbar.style.display = 'block';
                navbar.style.visibility = 'visible';
            }
        });

        // Handle dropdown hover on desktop
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu-modern');
                
                if (toggle && menu) {
                    let hoverTimeout;
                    
                    dropdown.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                        dropdown.classList.add('show');
                        toggle.setAttribute('aria-expanded', 'true');
                        menu.style.display = 'block';
                    });
                    
                    dropdown.addEventListener('mouseleave', function() {
                        hoverTimeout = setTimeout(function() {
                            dropdown.classList.remove('show');
                            toggle.setAttribute('aria-expanded', 'false');
                        }, 150);
                    });
                    
                    menu.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                    });
                    
                    menu.addEventListener('mouseleave', function() {
                        dropdown.classList.remove('show');
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        }
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const navDropdowns = document.querySelectorAll('.nav-dropdown');
                navDropdowns.forEach(function(dropdown) {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                    dropdown.classList.remove('show');
                });
            }, 250);
        });
        
        // Toast notifications
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        toastList.forEach(toast => toast.show());
    </script>
    
    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
