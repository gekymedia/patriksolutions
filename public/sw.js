// Service Worker for Blog Push Notifications
self.addEventListener('push', function(event) {
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'New Blog Post';
    const options = {
        body: data.body || 'Check out our latest blog post!',
        icon: data.icon || '/assets/logos/patrick_logo.png',
        badge: '/assets/logos/patrick_logo.png',
        image: data.image || null,
        data: {
            url: data.url || '/blog-posts'
        },
        actions: [
            {
                action: 'view',
                title: 'View Post'
            },
            {
                action: 'dismiss',
                title: 'Dismiss'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    if (event.action === 'view') {
        event.waitUntil(
            clients.openWindow(event.notification.data.url || '/blog-posts')
        );
    }
});

self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});

