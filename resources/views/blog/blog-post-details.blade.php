@extends('layouts.app')
@section('title', 'Patrik Solutions | Blog Details')

@section('content')
<section class="modern-section" style="background: var(--bg-light); padding-top: 2rem;">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8 col-md-12 mb-4">
                    <div class="modern-card">
                        <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.5rem;">
                            {{ $blog->blog_title}}
                        </h1>

                        <div class="d-flex gap-4 mb-4" style="font-size: 1rem; color: var(--text-secondary); flex-wrap: wrap;">
                            <span>
                                <i class="fas fa-user me-2"></i> {{$blog->blog_author}}
                            </span>
                            <span>
                                <i class="fas fa-calendar-alt me-2"></i> {{$blog->created_at->format('M d, Y')}}
                            </span>
                            <span>
                                <i class="fas fa-eye me-2"></i> {{$blog->blog_view}} views
                            </span>
                        </div>

                        <img src="{{asset('storage/'.$blog->blog_thumbnail) }}" 
                             class="img-fluid rounded-modern mb-4" 
                             alt="{{ $blog->blog_title }}"
                             style="width: 100%; height: 500px; object-fit: cover;">

                        <div class="blog-content" style="font-size: 1.125rem; line-height: 1.8; color: var(--text-primary);">
                            {!! $blog->blog_content !!}
                        </div>

                        <!-- Notification Subscription -->
                        <div class="mt-5 pt-4" style="border-top: 2px solid var(--border-color);">
                            <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                                <i class="fas fa-bell me-2"></i>Get Notified
                            </h5>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                Never miss a new blog post! Enable notifications to stay updated.
                            </p>
                            <button id="subscribeBtnDetail" class="btn btn-modern btn-modern-primary" onclick="subscribeToNotifications()">
                                <i class="fas fa-bell me-2"></i>Enable Notifications
                            </button>
                            <button id="unsubscribeBtnDetail" class="btn btn-modern" style="display: none; background: rgba(239,68,68,0.1); color: var(--danger-color); border: 1px solid rgba(239,68,68,0.2);" onclick="unsubscribeFromNotifications()">
                                <i class="fas fa-bell-slash me-2"></i>Disable Notifications
                            </button>
                        </div>

                        <!-- Social Share -->
                        <div class="mt-5 pt-4" style="border-top: 2px solid var(--border-color);">
                            <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                                <i class="fas fa-share-alt me-2"></i>Share this post
                            </h5>
                            <div class="d-flex gap-3">
                                <a href="#" target="_blank" class="btn btn-modern" style="background: #3b5998; color: white;">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                                <a href="#" target="_blank" class="btn btn-modern" style="background: #1DA1F2; color: white;">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="#" target="_blank" class="btn btn-modern" style="background: #0077b5; color: white;">
                                    <i class="fab fa-linkedin-in"></i> LinkedIn
                                </a>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="mt-5 pt-4" style="border-top: 2px solid var(--border-color);">
                            <h4 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem;">
                                <i class="fas fa-comments me-2"></i>Comments
                            </h4>

                            <p class="text-muted mb-4">No comments found. Be the first to comment!</p>
                            
                            <h5 class="mb-3" style="font-weight: 600; color: var(--text-primary);">
                                Leave a Comment
                            </h5>

                            <form action="#" class="form">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-primary);">Name</label>
                                        <input type="text" name="name" class="form-control" style="border-radius: 0.5rem; border: 1px solid var(--border-color); padding: 0.75rem 1rem;" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" style="font-weight: 600; color: var(--text-primary);">Email</label>
                                        <input type="email" name="email" class="form-control" style="border-radius: 0.5rem; border: 1px solid var(--border-color); padding: 0.75rem 1rem;" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 600; color: var(--text-primary);">Message</label>
                                    <textarea name="comment" class="form-control" style="border-radius: 0.5rem; border: 1px solid var(--border-color); padding: 0.75rem 1rem;" rows="6" autocomplete="off" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-modern btn-modern-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <div class="modern-card mb-4">
                        <h5 class="mb-3" style="font-weight: 700; color: var(--text-primary);">
                            <i class="fas fa-list me-2"></i>Other Posts
                        </h5>
                        <ul class="list-unstyled">
                            @php
                                $relatedBlogs = \App\Models\Blog::where('id', '!=', $blog->id)->latest()->take(5)->get();
                            @endphp
                            @if($relatedBlogs->count() > 0)
                                @foreach($relatedBlogs as $relatedBlog)
                                <li class="mb-3 pb-3" style="border-bottom: 1px solid var(--border-color);">
                                    <a href="{{ route('blog-details', $relatedBlog->id)}}" 
                                       style="color: var(--text-secondary); text-decoration: none; transition: color 0.3s; display: block;"
                                       onmouseover="this.style.color='var(--primary-color)'"
                                       onmouseout="this.style.color='var(--text-secondary)'">
                                        <i class="fas fa-chevron-right me-2" style="font-size: 0.8rem;"></i>
                                        {{ Str::limit($relatedBlog->blog_title, 60) }}
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $relatedBlog->created_at->format('M d, Y') }}
                                    </small>
                                </li>
                                @endforeach
                            @else
                                <li class="text-muted">No other posts available</li>
                            @endif
                        </ul>
                    </div>

                    <div class="modern-card" style="background: var(--gradient-primary); color: white;">
                        <h5 class="mb-3" style="font-weight: 700;">
                            <i class="fas fa-info-circle me-2"></i>About Patrik Solutions
                        </h5>
                        <p style="opacity: 0.95; line-height: 1.7;">
                            Your trusted partner in financial literacy and empowerment. Explore our calculators, 
                            courses, and resources to take control of your financial future.
                        </p>
                        <a href="{{ route('index') }}" class="btn btn-modern mt-3" style="background: white; color: var(--primary-color); width: 100%;">
                            Learn More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
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
        if (document.getElementById('subscribeBtnDetail')) {
            document.getElementById('subscribeBtnDetail').style.display = isSubscribed ? 'none' : 'block';
            document.getElementById('unsubscribeBtnDetail').style.display = isSubscribed ? 'block' : 'none';
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
    if (document.getElementById('subscribeBtnDetail')) {
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

