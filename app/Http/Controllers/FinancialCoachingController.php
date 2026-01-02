<?php

namespace App\Http\Controllers;

use App\Models\FinancialCoachingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialCoachingController extends Controller
{
    public function index()
    {
        return view('financial-coaching.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'coaching_type' => 'nullable|string',
        ]);

        FinancialCoachingRequest::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'coaching_type' => $validated['coaching_type'] ?? 'general',
            'status' => 'pending',
        ]);

        return redirect()->route('financial-coaching.index')->with('success', 'Thank you! Your coaching request has been submitted. We\'ll get back to you soon.');
    }
}
