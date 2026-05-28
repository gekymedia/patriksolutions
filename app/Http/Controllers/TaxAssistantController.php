<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TaxAssistantController extends Controller
{
    private string $systemPrompt = <<<PROMPT
You are Patrik's AI Tax & Finance Assistant — a premium, expert-level assistant on patriksolutions.com. 
You were built by Patrik Barfi, a professional licensed tax preparer based in Mason Neck, VA with deep expertise in personal finance, tax preparation, budgeting, debt management, and investing.

YOUR EXPERTISE:
- US federal and state tax filing (W-2, 1099, self-employment, small business)
- Tax deductions and credits (standard vs itemized, home office, education, child tax credits)
- Estimated quarterly taxes for freelancers and business owners
- Retirement accounts (401k, IRA, Roth IRA, contribution limits)
- Budgeting strategies (70/30 rule, zero-based budgeting, envelope method)
- Debt payoff strategies (debt snowball, debt avalanche)
- Investment basics (index funds, compound interest, diversification)
- Real estate basics (mortgage, equity, rental income taxes)

RESPONSE STYLE:
- Warm, direct, and expert — like a knowledgeable friend who happens to be a tax professional
- Practical and actionable — give specific steps, not vague advice
- Keep responses under 150 words unless a detailed breakdown is truly needed
- Always mention relevant Patrik Solutions tools when applicable
- For complex tax situations, recommend booking a 1-on-1 consultation with Patrik at patriksolutions.com
- Never give advice that could cause legal harm — qualify when necessary

PLATFORM TOOLS TO RECOMMEND:
- Budget Calculator, Debt Snowball Calculator, Investment Calculator, Retirement Calculator
- Mortgage Calculator, Compound Interest Calculator, Net Worth Calculator
- Financial Health Assessment (free), Financial Literacy Courses
- 1-on-1 Tax Consultation with Patrik (Elite members only)

You are a PRO/ELITE tier assistant — go deep, be specific, give real value.
PROMPT;

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array|max:10',
        ]);

        $user    = Auth::user();
        $message = $request->input('message');
        $history = $request->input('history', []);

        // Rate limiting for Pro users (Elite gets double)
        $rateKey = "tax_chat_{$user->id}_" . now()->format('Y-m-d-H');
        $limit   = $user->isElite() ? 100 : 50;
        $current = Cache::get($rateKey, 0);

        if ($current >= $limit) {
            return response()->json([
                'success' => false,
                'message' => 'Hourly limit reached. Please try again shortly.',
            ], 429);
        }

        Cache::put($rateKey, $current + 1, now()->addHour());

        // Build messages with history
        $messages = [];
        foreach (array_slice($history, -8) as $item) {
            $messages[] = ['role' => $item['role'], 'content' => $item['content']];
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        try {
            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.api_key'),
                'anthropic-version' => '2023-06-01',
                'Content-Type'      => 'application/json',
            ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-20250514',
                'max_tokens' => 1000,
                'system'     => $this->systemPrompt,
                'messages'   => $messages,
            ]);

            if ($response->failed()) {
                Log::error('Tax assistant API error', ['status' => $response->status()]);
                return response()->json(['success' => false, 'message' => 'AI service unavailable.'], 503);
            }

            $reply = $response->json('content.0.text') ?? 'Sorry, I could not generate a response.';

            return response()->json([
                'success' => true,
                'reply'   => $reply,
                'plan'    => $user->currentPlan(),
            ]);

        } catch (\Exception $e) {
            Log::error('Tax assistant error', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
    }

    // Free users get a teaser — 3 questions/day
    public function freeChat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $user    = Auth::user();
        $rateKey = "free_chat_{$user->id}_" . now()->format('Y-m-d');
        $count   = Cache::get($rateKey, 0);
        $limit   = $user->dailyChatLimit();

        if ($count >= $limit) {
            return response()->json([
                'success'      => false,
                'limit_reached' => true,
                'message'      => "You've used your {$limit} free questions today. Upgrade to Pro for unlimited access.",
                'upgrade_url'  => route('membership.index'),
            ], 429);
        }

        Cache::put($rateKey, $count + 1, now()->endOfDay());

        // Simplified prompt for free tier
        $response = Http::withHeaders([
            'x-api-key'         => config('services.anthropic.api_key'),
            'anthropic-version' => '2023-06-01',
            'Content-Type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-sonnet-4-20250514',
            'max_tokens' => 1000,
            'system'     => 'You are the Patrik Solutions AI assistant. Give a brief, helpful answer in under 80 words. End with a gentle nudge to upgrade to Pro at patriksolutions.com for deeper, unlimited help.',
            'messages'   => [['role' => 'user', 'content' => $request->message]],
        ]);

        $remaining = $limit - $count - 1;

        return response()->json([
            'success'   => true,
            'reply'     => $response->json('content.0.text'),
            'remaining' => $remaining,
            'limit'     => $limit,
        ]);
    }
}
