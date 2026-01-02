<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Patrik Solutions</title>
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
    
    <style>
        body {
            overflow-x: hidden;
        }
        
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
            background: var(--bg-light);
        }
        
        .sidebar {
            width: 260px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-header img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }
        
        .sidebar-header span {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu-item:hover {
            background: rgba(102, 126, 234, 0.05);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu-item.active {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            font-weight: 600;
        }
        
        .sidebar-menu-item i {
            width: 20px;
            text-align: center;
        }
        
        .sidebar-divider {
            margin: 0.5rem 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }
        
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .top-bar-title h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }
        
        .top-bar-title p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.875rem;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            cursor: pointer;
        }
        
        .content-area {
            padding: 2rem;
        }
        
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('index') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                    <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions Logo">
                    <span>Patrik Solutions</span>
                </a>
            </div>
            
            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-menu-item" style="font-weight: 600; color: var(--text-primary); cursor: default;">
                    <i class="fas fa-calculator"></i>
                    <span>Calculators</span>
                </div>
                <a href="{{ route('budget_calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('budget_calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-calculator"></i>
                    <span>Budget Calculator</span>
                </a>
                <a href="{{ route('budget_calculator.list') }}" class="sidebar-menu-item {{ request()->routeIs('budget_calculator.list') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-list"></i>
                    <span>My Budgets</span>
                </a>
                <a href="{{ route('investment_calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('investment_calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-chart-line"></i>
                    <span>Investment</span>
                </a>
                <a href="{{ route('retirement_calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('retirement_calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-piggy-bank"></i>
                    <span>Retirement</span>
                </a>
                <a href="{{ route('mortgage-calculator') }}" class="sidebar-menu-item {{ request()->routeIs('mortgage-calculator') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-home"></i>
                    <span>Mortgage</span>
                </a>
                <a href="{{ route('mortgage.payoff') }}" class="sidebar-menu-item {{ request()->routeIs('mortgage.payoff') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-key"></i>
                    <span>Mortgage Payoff</span>
                </a>
                @if(Route::has('debt-snowball-calculator.index'))
                <a href="{{ route('debt-snowball-calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('debt-snowball-calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-snowflake"></i>
                    <span>Debt Snowball</span>
                </a>
                @endif
                @if(Route::has('net-worth-calculator.index'))
                <a href="{{ route('net-worth-calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('net-worth-calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-wallet"></i>
                    <span>Net Worth</span>
                </a>
                @endif
                @if(Route::has('compound-interest-calculator.index'))
                <a href="{{ route('compound-interest-calculator.index') }}" class="sidebar-menu-item {{ request()->routeIs('compound-interest-calculator.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-percent"></i>
                    <span>Compound Interest</span>
                </a>
                @endif
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-menu-item" style="font-weight: 600; color: var(--text-primary); cursor: default;">
                    <i class="fas fa-book"></i>
                    <span>Resources</span>
                </div>
                <a href="{{ route('blog-posts') }}" class="sidebar-menu-item {{ request()->routeIs('blog*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-blog"></i>
                    <span>Blog</span>
                </a>
                <a href="{{ route('course.index') }}" class="sidebar-menu-item {{ request()->routeIs('course.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Courses</span>
                </a>
                @if(Route::has('financial-assessment.index'))
                <a href="{{ route('financial-assessment.index') }}" class="sidebar-menu-item {{ request()->routeIs('financial-assessment.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Financial Assessment</span>
                </a>
                @endif
                @if(Route::has('financial-milestones.index'))
                <a href="{{ route('financial-milestones.index') }}" class="sidebar-menu-item {{ request()->routeIs('financial-milestones.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-flag-checkered"></i>
                    <span>Financial Milestones</span>
                </a>
                @endif
                @if(Route::has('financial-coaching.index'))
                <a href="{{ route('financial-coaching.index') }}" class="sidebar-menu-item {{ request()->routeIs('financial-coaching.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-user-tie"></i>
                    <span>Financial Coaching</span>
                </a>
                @endif
                
                @auth
                    @if (Auth::user()->role == 'admin')
                    <div class="sidebar-divider"></div>
                    
                    <div class="sidebar-menu-item" style="font-weight: 600; color: var(--text-primary); cursor: default;">
                        <i class="fas fa-cog"></i>
                        <span>Admin</span>
                    </div>
                    <a href="{{ route('admin-dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin*') ? 'active' : '' }}" style="padding-left: 3rem;">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Admin Dashboard</span>
                    </a>
                    <a href="{{ route('blogs.index') }}" class="sidebar-menu-item {{ request()->routeIs('blogs.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                        <i class="fas fa-edit"></i>
                        <span>Manage Blogs</span>
                    </a>
                    <a href="{{ route('youtube.index') }}" class="sidebar-menu-item {{ request()->routeIs('youtube.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                        <i class="fab fa-youtube"></i>
                        <span>YouTube</span>
                    </a>
                    <a href="{{ route('contact.index') }}" class="sidebar-menu-item {{ request()->routeIs('contact.index') ? 'active' : '' }}" style="padding-left: 3rem;">
                        <i class="fas fa-envelope"></i>
                        <span>Contact Messages</span>
                    </a>
                    @if(Route::has('blog-notifications.index'))
                    <a href="{{ route('blog-notifications.index') }}" class="sidebar-menu-item {{ request()->routeIs('blog-notifications.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                        <i class="fas fa-bell"></i>
                        <span>Blog Notifications</span>
                    </a>
                    @endif
                    @endif
                @endauth
                
                <div class="sidebar-divider"></div>
                
                <a href="{{ route('profile.edit') }}" class="sidebar-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-edit"></i>
                    <span>Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-menu-item" style="border: none; background: none; cursor: pointer;" onclick="this.submit()">
                    @csrf
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </form>
            </nav>
        </aside>
        
        <!-- Sidebar Overlay (Mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="top-bar-title">
                        <h1>@yield('page-title', 'Dashboard')</h1>
                        @hasSection('page-description')
                        <p>@yield('page-description')</p>
                        @endif
                    </div>
                </div>
                
                <div class="user-menu">
                    <div class="dropdown">
                        <button class="btn btn-modern btn-modern-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a></li>
                            <li><a class="dropdown-item dropdown-item-modern" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i> Profile
                            </a></li>
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
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }
        
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

