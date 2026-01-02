<?php

namespace App\Http\Controllers;

use App\Models\BlogNotificationSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BlogNotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            // Get browser info
            $browser = $this->getBrowser($request->userAgent());
            $device = $this->getDevice($request->userAgent());

            // For Pusher, we just need to track that user wants notifications
            // No need for endpoint/keys like browser push
            $subscription = BlogNotificationSubscription::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'endpoint' => 'pusher-subscription-' . (Auth::id() ?? $request->ip()),
                ],
                [
                    'browser' => $browser,
                    'device' => $device,
                    'ip_address' => $request->ip(),
                    'is_active' => true,
                    'subscribed_at' => now(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Successfully subscribed to blog notifications!',
                'subscription' => $subscription
            ]);
        } catch (\Exception $e) {
            Log::error('Blog notification subscription error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to subscribe. Please try again.'
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        $subscription = BlogNotificationSubscription::where('user_id', Auth::id())
            ->orWhere('ip_address', $request->ip())
            ->where('is_active', true)
            ->first();

        if ($subscription) {
            $subscription->update(['is_active' => false]);
            return response()->json([
                'success' => true,
                'message' => 'Successfully unsubscribed from blog notifications.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Subscription not found.'
        ], 404);
    }

    public function index()
    {
        $subscriptions = BlogNotificationSubscription::with('user')
            ->where('is_active', true)
            ->orderBy('subscribed_at', 'desc')
            ->paginate(20);

        return view('admin.blog-notifications.index', compact('subscriptions'));
    }

    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }

    private function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            return 'Mobile';
        }
        if (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            return 'Tablet';
        }
        return 'Desktop';
    }
}
