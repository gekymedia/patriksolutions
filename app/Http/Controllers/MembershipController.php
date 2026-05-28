<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class MembershipController extends Controller
{
    // Stripe Price IDs — replace with your real IDs from Stripe Dashboard
    const PLANS = [
        'free'  => null,
        'pro'   => 'price_PRO_MONTHLY_ID',   // $19/mo
        'elite' => 'price_ELITE_MONTHLY_ID',  // $49/mo
    ];

    private function stripeConfigured(): bool
    {
        return filled(config('cashier.key')) && filled(config('cashier.secret'));
    }

    // Show pricing/upgrade page
    public function index()
    {
        $user = Auth::user();
        $intent = $this->stripeConfigured() ? $user->createSetupIntent() : null;

        return view('membership.index', [
            'user'              => $user,
            'currentPlan'       => $user->currentPlan(),
            'intent'            => $intent,
            'stripeConfigured'  => $this->stripeConfigured(),
        ]);
    }

    // Subscribe to a plan
    public function subscribe(Request $request)
    {
        if (! $this->stripeConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Online payments are not configured yet. Please try again later.',
            ], 503);
        }

        $request->validate([
            'plan'             => 'required|in:pro,elite',
            'payment_method'   => 'required|string',
        ]);

        $user      = Auth::user();
        $plan      = $request->plan;
        $priceId   = self::PLANS[$plan];

        try {
            // Cancel existing subscription if upgrading/downgrading
            if ($user->subscribed('default')) {
                $user->subscription('default')->swap($priceId);
            } else {
                $user->newSubscription('default', $priceId)
                     ->create($request->payment_method);
            }

            $user->forceFill(['plan' => $plan])->save();

            return response()->json([
                'success' => true,
                'message' => "Welcome to {$plan}! Your account has been upgraded.",
                'plan'    => $plan,
            ]);

        } catch (IncompletePayment $e) {
            return response()->json([
                'success'        => false,
                'requires_action' => true,
                'payment_intent'  => $e->payment->id,
            ], 402);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please check your card details.',
            ], 422);
        }
    }

    // Cancel subscription (downgrade to free)
    public function cancel()
    {
        $user = Auth::user();

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();
            $user->forceFill(['plan' => 'free'])->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Subscription cancelled. You keep access until the end of the billing period.',
        ]);
    }

    // Resume a cancelled subscription
    public function resume()
    {
        $user = Auth::user();

        if ($user->subscription('default') && $user->subscription('default')->onGracePeriod()) {
            $user->subscription('default')->resume();
            $user->forceFill(['plan' => $user->subscription('default')->stripe_price === self::PLANS['elite'] ? 'elite' : 'pro'])->save();
        }

        return response()->json(['success' => true, 'message' => 'Subscription resumed!']);
    }

    // Billing portal (Stripe hosted)
    public function billingPortal()
    {
        if (! $this->stripeConfigured()) {
            return redirect()->route('membership.index')
                ->with('upgrade_message', 'Billing is not available yet. Payment setup is still in progress.');
        }

        return Auth::user()->redirectToBillingPortal(route('membership.index'));
    }

    // Stripe webhook handler
    public function webhook()
    {
        // Laravel Cashier handles this automatically via WebhookController
        // Just register the route — see routes file
    }
}
