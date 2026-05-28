<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequiresPlan
{
    /**
     * Usage in routes:
     *   ->middleware('plan:pro')      // requires pro or elite
     *   ->middleware('plan:elite')    // requires elite only
     *
     * Returns JSON for API routes, redirect for web routes.
     */
    public function handle(Request $request, Closure $next, string $plan = 'pro')
    {
        $user = Auth::user();

        if (!$user) {
            return $this->deny($request, 'Please log in to access this feature.');
        }

        $allowed = match($plan) {
            'pro'   => $user->isPro() && $user->hasActivePlan(),
            'elite' => $user->isElite() && $user->hasActivePlan(),
            default => false,
        };

        if (!$allowed) {
            $message = $plan === 'elite'
                ? 'This feature requires an Elite membership ($49/mo).'
                : 'This feature requires a Pro membership ($19/mo). Upgrade to unlock.';

            return $this->deny($request, $message, $plan);
        }

        return $next($request);
    }

    private function deny(Request $request, string $message, string $plan = 'pro')
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success'      => false,
                'message'      => $message,
                'upgrade_plan' => $plan,
                'upgrade_url'  => route('membership.index'),
            ], 403);
        }

        return redirect()->route('membership.index')
                         ->with('upgrade_message', $message);
    }
}
