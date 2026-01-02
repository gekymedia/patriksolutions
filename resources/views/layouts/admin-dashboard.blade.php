<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Patrik Solutions</title>
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
        
        .sidebar-divider {
            height: 1px;
            background: var(--border-color);
            margin: 1rem 0;
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }
        
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .content-area {
            padding: 2rem;
        }
        
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            cursor: pointer;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
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
            
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    @if(Auth::check() && Auth::user()->role !== 'admin')
        <script>window.location.href = '{{ route('dashboard') }}';</script>
    @endif
    
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('index') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit;">
                    <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions Logo">
                    <span>Admin Panel</span>
                </a>
            </div>
            
            <nav class="sidebar-menu">
                <a href="{{ route('admin-dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin-dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Admin Dashboard</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('dashboard') && !request()->routeIs('admin-dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>User Dashboard</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-menu-item" style="font-weight: 600; color: var(--text-primary); cursor: default;">
                    <i class="fas fa-cog"></i>
                    <span>Management</span>
                </div>
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
                <a href="{{ route('users.index') }}" class="sidebar-menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
                @if(Route::has('admin.notifications.create'))
                <a href="{{ route('admin.notifications.create') }}" class="sidebar-menu-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" style="padding-left: 3rem;">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Notifications</span>
                </a>
                @endif
                
                <div class="sidebar-divider"></div>
                
                <a href="{{ route('profile.edit') }}" class="sidebar-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-edit"></i>
                    <span>Profile</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="sidebar-menu-item" style="border: none; background: none; cursor: pointer; width: 100%; text-align: left;" onclick="this.submit()">
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
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">Admin: {{ Auth::user()->name }}</span>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="content-area">
                @hasSection('page-title')
                    <div class="mb-4">
                        <h1 class="mb-2" style="font-size: 2rem; font-weight: 700; color: var(--text-primary);">
                            @yield('page-title')
                        </h1>
                        @hasSection('page-description')
                        <p class="text-muted mb-0">@yield('page-description')</p>
                        @endhasSection
                    </div>
                @endhasSection
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
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

