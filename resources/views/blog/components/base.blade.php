<!DOCTYPE html>
<html lang="en">
<head>
     <title>@yield('title')</title>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <link rel="shortcut icon" href="{{asset('assets/logos/patrick_logo.png')}}" type="image/x-icon">
     
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
     
     <!-- Protect navbar from being hidden -->
     <style>
         .modern-navbar {
             display: block !important;
             visibility: visible !important;
             opacity: 1 !important;
         }
     </style>
     
     <!-- CK editor-->
     <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css" />
     <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/ckeditor5-premium-features.css" />
     <script type="importmap">
       {
           "imports": {
               "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
               "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/",
               "ckeditor5-premium-features": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/ckeditor5-premium-features.js",
               "ckeditor5-premium-features/": "https://cdn.ckeditor.com/ckeditor5-premium-features/42.0.0/"
           }
       }
   </script>
</head>
<body id="top">

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
                     @auth
                     <a href="{{ route('dashboard') }}"
                         class="modern-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                         <i class="fas fa-tachometer-alt"></i>
                         <span>Dashboard</span>
                     </a>
                     @endauth
                    
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
                             @auth
                             <li><a class="dropdown-item dropdown-item-modern" href="{{ route('budget_calculator.list') }}">
                                 <i class="fas fa-list me-2"></i> My Budgets
                             </a></li>
                             @endauth
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
                             <li><a class="dropdown-item dropdown-item-modern" href="{{ route('course.index') }}">
                                 <i class="fas fa-graduation-cap me-2"></i> Courses
                             </a></li>
                             @if(Route::has('financial-assessment.index'))
                             <li><a class="dropdown-item dropdown-item-modern" href="{{ route('financial-assessment.index') }}">
                                 <i class="fas fa-clipboard-check me-2"></i> Financial Assessment
                             </a></li>
                             @endif
                             @if(Route::has('financial-milestones.index'))
                             <li><a class="dropdown-item dropdown-item-modern" href="{{ route('financial-milestones.index') }}">
                                 <i class="fas fa-flag-checkered me-2"></i> Financial Milestones
                             </a></li>
                             @endif
                             @if(Route::has('financial-coaching.index'))
                             <li><a class="dropdown-item dropdown-item-modern" href="{{ route('financial-coaching.index') }}">
                                 <i class="fas fa-user-tie me-2"></i> Financial Coaching
                             </a></li>
                             @endif
                         </ul>
                     </div>

                     <!-- Admin Dropdown (only for admins) -->
                     @auth
                         @if (Auth::user()->role == 'admin')
                         <div class="nav-dropdown dropdown">
                             <a href="#" class="modern-nav-link dropdown-toggle {{ request()->routeIs('blogs.*') || request()->routeIs('youtube.*') || request()->routeIs('contact.*') || request()->routeIs('admin*') ? 'active' : '' }}" 
                                id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="fas fa-cog"></i>
                                 <span>Admin</span>
                                 <i class="fas fa-chevron-down ms-1" style="font-size: 0.75rem;"></i>
                             </a>
                             <ul class="dropdown-menu dropdown-menu-modern" aria-labelledby="adminDropdown">
                                 <li><a class="dropdown-item dropdown-item-modern" href="{{ route('admin-dashboard') }}">
                                     <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                                 </a></li>
                                 <li><a class="dropdown-item dropdown-item-modern" href="{{ route('blogs.index') }}">
                                     <i class="fas fa-edit me-2"></i> Manage Blogs
                                 </a></li>
                                 <li><a class="dropdown-item dropdown-item-modern" href="{{ route('youtube.index') }}">
                                     <i class="fab fa-youtube me-2"></i> YouTube
                                 </a></li>
                                 <li><a class="dropdown-item dropdown-item-modern" href="{{ route('contact.index') }}">
                                     <i class="fas fa-envelope me-2"></i> Contact Messages
                                 </a></li>
                                 @if(Route::has('blog-notifications.index'))
                                 <li><a class="dropdown-item dropdown-item-modern" href="{{ route('blog-notifications.index') }}">
                                     <i class="fas fa-bell me-2"></i> Blog Notifications
                                 </a></li>
                                 @endif
                             </ul>
                         </div>
                         @endif
                     @endauth
                     
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

{{-- CONTENT --}}
@yield('content')

     <!-- FOOTER -->
     @include('blog.components.footer')
     
     <!-- SCRIPTS -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     
     <!-- Navbar scroll effect script -->
     <script>
         // Ensure navbar is always visible and protect it from being hidden
         document.addEventListener('DOMContentLoaded', function() {
             const navbar = document.querySelector('.modern-navbar');
             if (navbar) {
                 navbar.style.display = 'block';
                 navbar.style.visibility = 'visible';
                 navbar.style.opacity = '1';
                 
                 // Monitor for changes and restore visibility
                 const observer = new MutationObserver(function(mutations) {
                     if (navbar.style.display === 'none' || navbar.style.visibility === 'hidden') {
                         navbar.style.display = 'block';
                         navbar.style.visibility = 'visible';
                         navbar.style.opacity = '1';
                     }
                 });
                 
                 observer.observe(navbar, {
                     attributes: true,
                     attributeFilter: ['style', 'class'],
                     childList: false,
                     subtree: false
                 });
             }
         });
         
         window.addEventListener('scroll', function() {
             const navbar = document.querySelector('.modern-navbar');
             if (navbar) {
                 if (window.scrollY > 50) {
                     navbar.classList.add('scrolled');
                 } else {
                     navbar.classList.remove('scrolled');
                 }
                 // Ensure navbar stays visible on scroll
                 navbar.style.display = 'block';
                 navbar.style.visibility = 'visible';
             }
         });
     </script>
     
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <script type="module" src="{{ asset('assets/vendor/ckeditor.js') }}"></script>
     
     <!-- Pusher Blog Notification Script -->
     <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
     <script>
         let isSubscribed = false;
         let pusherChannel = null;

         // Check subscription status
         async function checkSubscriptionStatus() {
             try {
                 const response = await fetch('{{ route("blog-notifications.subscribe") }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                     }
                 });
                 
                 const data = await response.json();
                 if (data.success) {
                     isSubscribed = true;
                     updateButtonStates();
                     initializePusher();
                 }
             } catch (error) {
                 console.error('Error checking subscription:', error);
             }
         }

         // Subscribe to notifications
         async function subscribeToNotifications() {
             try {
                 const response = await fetch('{{ route("blog-notifications.subscribe") }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                     }
                 });

                 const data = await response.json();
                 
                 if (data.success) {
                     isSubscribed = true;
                     updateButtonStates();
                     initializePusher();
                     showNotification('Successfully subscribed to blog notifications!', 'success');
                 } else {
                     showNotification('Failed to subscribe. Please try again.', 'error');
                 }
             } catch (error) {
                 console.error('Subscription error:', error);
                 showNotification('An error occurred. Please try again.', 'error');
             }
         }

         // Unsubscribe from notifications
         async function unsubscribeFromNotifications() {
             try {
                 const response = await fetch('{{ route("blog-notifications.unsubscribe") }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                     }
                 });

                 const data = await response.json();
                 
                 if (data.success) {
                     isSubscribed = false;
                     updateButtonStates();
                     if (pusherChannel) {
                         pusherChannel.unsubscribe();
                         pusherChannel = null;
                     }
                     showNotification('Successfully unsubscribed from notifications.', 'success');
                 }
             } catch (error) {
                 console.error('Unsubscribe error:', error);
                 showNotification('An error occurred. Please try again.', 'error');
             }
         }

         // Initialize Pusher connection
         function initializePusher() {
             if (typeof Pusher === 'undefined') {
                 console.error('Pusher is not loaded');
                 return;
             }

             const pusherKey = '{{ config("broadcasting.connections.pusher.key") ?: env("PUSHER_APP_KEY", "") }}';
             const pusherCluster = '{{ config("broadcasting.connections.pusher.options.cluster") ?: env("PUSHER_APP_CLUSTER", "mt1") }}';
             
             if (!pusherKey) {
                 console.error('Pusher key not configured. Please set PUSHER_APP_KEY in .env');
                 return;
             }

             const pusher = new Pusher(pusherKey, {
                 cluster: pusherCluster,
                 encrypted: true
             });

             pusherChannel = pusher.subscribe('blog-notifications');
             
             pusherChannel.bind('blog.published', function(data) {
                 showBrowserNotification(data);
             });
         }

         // Show browser notification
         function showBrowserNotification(data) {
             if (!('Notification' in window)) {
                 return;
             }

             if (Notification.permission === 'granted') {
                 const notification = new Notification(data.title || 'New Blog Post', {
                     body: `Check out: ${data.title}`,
                     icon: data.thumbnail || '{{ asset("assets/logos/patrick_logo.png") }}',
                     badge: '{{ asset("assets/logos/patrick_logo.png") }}',
                     tag: 'blog-' + data.id,
                     data: {
                         url: data.url
                     }
                 });

                 notification.onclick = function() {
                     window.focus();
                     window.location.href = data.url;
                     notification.close();
                 };
             } else if (Notification.permission !== 'denied') {
                 Notification.requestPermission().then(function(permission) {
                     if (permission === 'granted') {
                         showBrowserNotification(data);
                     }
                 });
             }
         }

         // Update button states
         function updateButtonStates() {
             if (document.getElementById('subscribeBtn')) {
                 document.getElementById('subscribeBtn').style.display = isSubscribed ? 'none' : 'block';
                 document.getElementById('unsubscribeBtn').style.display = isSubscribed ? 'block' : 'none';
             }
             if (document.getElementById('subscribeBtnDetail')) {
                 document.getElementById('subscribeBtnDetail').style.display = isSubscribed ? 'none' : 'block';
                 document.getElementById('unsubscribeBtnDetail').style.display = isSubscribed ? 'block' : 'none';
             }
         }

         // Show toast notification
         function showNotification(message, type) {
             // Create a simple toast notification
             const toast = document.createElement('div');
             toast.style.cssText = `
                 position: fixed;
                 top: 20px;
                 right: 20px;
                 padding: 1rem 1.5rem;
                 background: ${type === 'success' ? 'var(--success-color)' : 'var(--danger-color)'};
                 color: white;
                 border-radius: 12px;
                 box-shadow: var(--shadow-lg);
                 z-index: 10000;
                 animation: slideIn 0.3s ease;
             `;
             toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`;
             document.body.appendChild(toast);

             setTimeout(() => {
                 toast.style.animation = 'slideOut 0.3s ease';
                 setTimeout(() => toast.remove(), 300);
             }, 3000);
         }

         // Check subscription status on page load
         if (document.getElementById('subscribeBtn') || document.getElementById('subscribeBtnDetail')) {
             checkSubscriptionStatus();
         }

         // Request notification permission on subscribe
         document.addEventListener('DOMContentLoaded', function() {
             if ('Notification' in window && Notification.permission === 'default') {
                 // Optionally request permission when user clicks subscribe
             }
             
             // Final check to ensure navbar is visible after all scripts load
             setTimeout(function() {
                 const navbar = document.querySelector('.modern-navbar');
                 if (navbar) {
                     navbar.style.display = 'block';
                     navbar.style.visibility = 'visible';
                     navbar.style.opacity = '1';
                 }
             }, 200);
         });
         
         // Additional protection - check after page fully loads
         window.addEventListener('load', function() {
             const navbar = document.querySelector('.modern-navbar');
             if (navbar) {
                 navbar.style.display = 'block';
                 navbar.style.visibility = 'visible';
                 navbar.style.opacity = '1';
             }
         });
     </script>
     <style>
         @keyframes slideIn {
             from { transform: translateX(400px); opacity: 0; }
             to { transform: translateX(0); opacity: 1; }
         }
         @keyframes slideOut {
             from { transform: translateX(0); opacity: 1; }
             to { transform: translateX(400px); opacity: 0; }
         }
     </style>
</body>
</html>