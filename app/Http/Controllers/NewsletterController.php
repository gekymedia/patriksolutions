<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
            'interests' => 'nullable|array',
        ]);

        $subscription = NewsletterSubscription::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'] ?? null,
                'is_active' => true,
                'interests' => $validated['interests'] ?? [],
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing! Check your email for confirmation.',
        ]);
    }

    public function unsubscribe($email)
    {
        $subscription = NewsletterSubscription::where('email', $email)->first();
        
        if ($subscription) {
            $subscription->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);
            
            return view('newsletter.unsubscribed');
        }

        return redirect()->route('index')->with('error', 'Email not found.');
    }
}
