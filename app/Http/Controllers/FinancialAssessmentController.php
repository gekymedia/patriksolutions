<?php

namespace App\Http\Controllers;

use App\Models\FinancialAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialAssessmentController extends Controller
{
    public function index()
    {
        return view('financial-assessment.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'answers' => 'required|string', // Changed from array to string since we're sending JSON
            'email' => 'nullable|email',
        ]);

        // Parse JSON answers
        $answers = json_decode($validated['answers'], true);
        
        if (!$answers || !is_array($answers)) {
            return redirect()->back()->withErrors(['answers' => 'Invalid answers format. Please try again.'])->withInput();
        }

        // Calculate score and determine stage
        $score = $this->calculateScore($answers);
        $stage = $this->determineStage($answers, $score);
        $milestone = $this->recommendMilestone($stage, $answers);
        $plan = $this->generatePlan($stage, $milestone, $answers);

        $assessment = FinancialAssessment::create([
            'user_id' => Auth::id(),
            'email' => $validated['email'] ?? $answers['email'] ?? Auth::user()?->email,
            'answers' => $answers, // Model will cast to JSON automatically
            'current_stage' => (string) $stage,
            'recommended_milestone' => (string) $milestone,
            'personalized_plan' => json_encode($plan), // Convert array to JSON string for text column
            'score' => $score,
        ]);

        return redirect()->route('financial-assessment.result', $assessment->id)->with('success', 'Your financial plan is ready!');
    }

    public function result($id)
    {
        $assessment = FinancialAssessment::findOrFail($id);
        return view('financial-assessment.result', compact('assessment'));
    }

    private function calculateScore($answers)
    {
        $score = 0;
        $maxScore = 100;

        // Scoring logic based on answers
        if (isset($answers['emergency_fund'])) {
            if ($answers['emergency_fund'] === 'yes_6months') $score += 25;
            elseif ($answers['emergency_fund'] === 'yes_3months') $score += 15;
            elseif ($answers['emergency_fund'] === 'yes_1month') $score += 5;
        }

        if (isset($answers['debt_situation'])) {
            if ($answers['debt_situation'] === 'no_debt') $score += 30;
            elseif ($answers['debt_situation'] === 'managing') $score += 15;
            elseif ($answers['debt_situation'] === 'struggling') $score += 5;
        }

        if (isset($answers['saving_habit'])) {
            if ($answers['saving_habit'] === 'always') $score += 20;
            elseif ($answers['saving_habit'] === 'sometimes') $score += 10;
        }

        if (isset($answers['investing'])) {
            if ($answers['investing'] === 'yes_regular') $score += 25;
            elseif ($answers['investing'] === 'yes_occasional') $score += 10;
        }

        return min($score, $maxScore);
    }

    private function determineStage($answers, $score)
    {
        if ($score >= 80) return 'advanced';
        if ($score >= 60) return 'building_wealth';
        if ($score >= 40) return 'building_foundation';
        if ($score >= 20) return 'getting_started';
        return 'emergency_mode';
    }

    private function recommendMilestone($stage, $answers)
    {
        $milestones = [
            'emergency_mode' => 'emergency_fund',
            'getting_started' => 'debt_free',
            'building_foundation' => 'emergency_fund',
            'building_wealth' => 'first_investment',
            'advanced' => 'wealth_building',
        ];

        // Override based on specific answers
        if (isset($answers['debt_situation']) && $answers['debt_situation'] !== 'no_debt') {
            return 'debt_free';
        }

        if (isset($answers['emergency_fund']) && $answers['emergency_fund'] === 'no') {
            return 'emergency_fund';
        }

        return $milestones[$stage] ?? 'emergency_fund';
    }

    private function generatePlan($stage, $milestone, $answers)
    {
        $plans = [
            'emergency_mode' => [
                'Focus on building a $1,000 starter emergency fund',
                'Track every expense to understand where your money goes',
                'Create a realistic budget and stick to it',
                'Consider finding additional income sources',
            ],
            'getting_started' => [
                'Build a $1,000 emergency fund first',
                'List all debts and create a payoff plan',
                'Start tracking expenses daily',
                'Set up automatic savings',
            ],
            'building_foundation' => [
                'Grow emergency fund to 3-6 months of expenses',
                'Continue debt payoff strategy',
                'Start learning about investing basics',
                'Review and optimize your budget monthly',
            ],
            'building_wealth' => [
                'Maximize retirement contributions',
                'Diversify investment portfolio',
                'Continue building emergency fund',
                'Consider additional income streams',
            ],
            'advanced' => [
                'Focus on wealth preservation',
                'Consider estate planning',
                'Explore advanced investment strategies',
                'Give back and help others',
            ],
        ];

        return $plans[$stage] ?? $plans['getting_started'];
    }
}
