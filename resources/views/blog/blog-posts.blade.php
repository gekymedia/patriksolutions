@extends('layouts.app')
@section('title', 'Patrik Solutions | Blog Posts')

@section('content')

<section class="modern-section" style="background: var(--bg-light); padding-top: 3rem; padding-bottom: 3rem;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title" style="margin-bottom: 1rem;">
                Our <span class="text-gradient">Blog</span>
            </h1>
            <p class="lead text-secondary" style="font-size: 1.25rem;">
                Read through some of the interesting topics on financial freedom from Patrik Barfi
            </p>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-12 mb-4 order-lg-last">
                <div class="modern-card mb-4">
                    <h5 class="mb-3" style="font-weight: 700; color: var(--text-primary);">
                        <i class="fas fa-search me-2"></i>Blog Search
                    </h5>
                    <form action="#" id="blog-search-form">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control calculator-form-section .form-control" placeholder="Search for...">
                            <button class="btn btn-modern btn-modern-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="modern-card mb-4">
                    <h5 class="mb-3" style="font-weight: 700; color: var(--text-primary);">
                        <i class="fas fa-bell me-2"></i>Get Notifications
                    </h5>
                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                        Stay updated with our latest blog posts. Get notified when we publish new content!
                    </p>
                    <button id="subscribeBtn" class="btn btn-modern btn-modern-primary w-100" onclick="subscribeToNotifications()">
                        <i class="fas fa-bell me-2"></i>Enable Notifications
                    </button>
                    <button id="unsubscribeBtn" class="btn btn-modern w-100" style="display: none; background: rgba(239,68,68,0.1); color: var(--danger-color); border: 1px solid rgba(239,68,68,0.2);" onclick="unsubscribeFromNotifications()">
                        <i class="fas fa-bell-slash me-2"></i>Disable Notifications
                    </button>
                    <p class="text-muted mt-2 mb-0" style="font-size: 0.75rem;">
                        <i class="fas fa-shield-alt me-1"></i>We respect your privacy
                    </p>
                </div>

                <div class="modern-card">
                    <h5 class="mb-3" style="font-weight: 700; color: var(--text-primary);">
                        <i class="fas fa-list me-2"></i>Recent Posts
                    </h5>
                    <ul class="list-unstyled">
                        @foreach($blogs->take(5) as $blog)
                        <li class="mb-2 pb-2" style="border-bottom: 1px solid var(--border-color);">
                            <a href="{{ route('blog-details', $blog->id)}}" 
                               style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s; display: block;"
                               onmouseover="this.style.color='var(--primary-color)'"
                               onmouseout="this.style.color='var(--text-secondary)'">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.8rem;"></i>
                                {{ Str::limit($blog->blog_title, 50) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-12">
                <div class="row g-4">
                    @foreach($blogs as $blog)
                    <div class="col-md-6">
                        <div class="feature-card">
                            <img src="{{asset('storage/'.$blog->blog_thumbnail) }}" 
                                 class="img-fluid rounded-modern mb-3" 
                                 alt="{{ $blog->blog_title }}"
                                 style="width: 100%; height: 250px; object-fit: cover;">
                            
                            <div class="d-flex gap-3 mb-2" style="font-size: 0.875rem; color: var(--text-secondary); flex-wrap: wrap;">
                                <span>
                                    <i class="fas fa-user me-1"></i> {{$blog->blog_author}}
                                </span>
                                <span>
                                    <i class="fas fa-calendar-alt me-1"></i> {{$blog->created_at->format('M d, Y')}}
                                </span>
                                <span>
                                    <i class="fas fa-eye me-1"></i> {{$blog->blog_view}}
                                </span>
                            </div>

                            <h3 class="feature-title" style="font-size: 1.4rem; margin-bottom: 1rem;">
                                <a href="{{ route('blog-details', $blog->id)}}" 
                                   style="text-decoration: none; color: inherit; transition: color 0.3s;"
                                   onmouseover="this.style.color='var(--primary-color)'"
                                   onmouseout="this.style.color='inherit'">
                                    {{$blog->blog_title}}
                                </a>
                            </h3>

                            <a href="{{ route('blog-details', $blog->id)}}" 
                               class="btn btn-modern btn-modern-primary w-100 mt-3">
                                Read More <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach

                    @if($blogs->isEmpty())
                    <div class="col-12">
                        <div class="modern-card text-center py-5">
                            <i class="fas fa-blog" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.3; margin-bottom: 1rem;"></i>
                            <h4 class="text-secondary">No blog posts available</h4>
                            <p class="text-muted">Check back later for new posts!</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
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
    }

    // Show toast notification
    function showNotification(message, type) {
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
    if (document.getElementById('subscribeBtn')) {
        checkSubscriptionStatus();
    }

    // Request notification permission
    document.addEventListener('DOMContentLoaded', function() {
        if ('Notification' in window && Notification.permission === 'default') {
            // Optionally request permission when user clicks subscribe
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
@endpush
@endsection