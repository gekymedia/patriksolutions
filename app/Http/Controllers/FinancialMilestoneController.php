<?php

namespace App\Http\Controllers;

use App\Models\FinancialMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialMilestoneController extends Controller
{
    public function index()
    {
        $milestones = FinancialMilestone::where('user_id', Auth::id())
            ->orderBy('is_completed')
            ->orderBy('order')
            ->get();
        
        return view('financial-milestones.index', compact('milestones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'milestone_type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date',
        ]);

        $milestone = FinancialMilestone::create([
            'user_id' => Auth::id(),
            'milestone_type' => $validated['milestone_type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'target_amount' => $validated['target_amount'] ?? null,
            'target_date' => $validated['target_date'] ?? null,
            'current_amount' => 0,
            'is_completed' => false,
            'order' => FinancialMilestone::where('user_id', Auth::id())->max('order') + 1,
        ]);

        return redirect()->route('financial-milestones.index')->with('success', 'Milestone created successfully!');
    }

    public function update(Request $request, $id)
    {
        $milestone = FinancialMilestone::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date',
            'is_completed' => 'sometimes|boolean',
        ]);

        if (isset($validated['is_completed']) && $validated['is_completed'] && !$milestone->is_completed) {
            $validated['completed_at'] = now();
        } elseif (isset($validated['is_completed']) && !$validated['is_completed']) {
            $validated['completed_at'] = null;
        }

        $milestone->update($validated);

        return redirect()->route('financial-milestones.index')->with('success', 'Milestone updated successfully!');
    }

    public function destroy($id)
    {
        $milestone = FinancialMilestone::where('user_id', Auth::id())->findOrFail($id);
        $milestone->delete();

        return redirect()->route('financial-milestones.index')->with('success', 'Milestone deleted successfully!');
    }
}
