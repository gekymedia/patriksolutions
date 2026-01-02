# Pusher Blog Notifications Setup Guide

## Overview
Blog notifications now use Pusher for real-time notifications. When a new blog is published, all subscribed users will receive instant browser notifications.

## Setup Instructions

### 1. Get Pusher Credentials

1. Sign up at [pusher.com](https://pusher.com) (free tier available)
2. Create a new app
3. Get your credentials:
   - App ID
   - Key
   - Secret
   - Cluster (e.g., mt1, eu, ap1)

### 2. Update Environment Variables

Add to your `.env` file:
```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

### 3. Update Vite Configuration

Add to your `.env` file (for frontend):
```env
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 4. Update Blog Notification Script

The Pusher key is currently using config. Make sure your `config/broadcasting.php` has:
```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'useTLS' => true,
    ],
],
```

### 5. Rebuild Assets

After updating environment variables:
```bash
npm run build
# or for development
npm run dev
```

## How It Works

1. **User Subscribes**: User clicks "Enable Notifications" on blog page
2. **Subscription Saved**: User preference saved to database
3. **Pusher Connection**: Frontend connects to Pusher channel `blog-notifications`
4. **Blog Published**: Admin publishes a blog → `BlogPublished` event is fired
5. **Event Broadcast**: Event broadcasts to Pusher channel
6. **Notification Received**: All subscribed users receive the notification
7. **Browser Notification**: Browser shows native notification (if permission granted)

## Features

- ✅ Real-time notifications via Pusher
- ✅ Browser push notifications
- ✅ Admin can see all subscribers
- ✅ Automatic notification when blog is published
- ✅ Works on all modern browsers
- ✅ No service worker needed

## Testing

1. Set up Pusher credentials
2. Visit blog page
3. Click "Enable Notifications"
4. Allow browser notification permission
5. Publish a new blog as admin
6. You should receive a notification instantly!

## Files Modified

1. `app/Events/BlogPublished.php` - Event that broadcasts to Pusher
2. `app/Http/Controllers/BlogController.php` - Fires event on publish
3. `app/Http/Controllers/BlogNotificationController.php` - Simplified for Pusher
4. `resources/js/bootstrap.js` - Pusher configuration
5. `resources/views/blog/components/base.blade.php` - Pusher client script
6. Database migration - Updated for Pusher compatibility

