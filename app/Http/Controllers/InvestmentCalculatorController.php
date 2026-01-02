<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestmentCalculatorController extends Controller
{
    public function index()
    {
        return view('investment_calculator.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'current_age' => 'required|integer|min:0',
            'retirement_age' => 'required|integer|min:67',
            'current_investment' => 'required|numeric|min:0',
            'monthly_contribution' => 'required|numeric|min:0',
            'annual_return' => 'required|numeric|min:0|max:100',
        ]);

        $current_age = $request->input('current_age');
        $retirement_age = $request->input('retirement_age');
        $current_investment = $request->input('current_investment');
        $monthly_contribution = $request->input('monthly_contribution');
        $annual_return = $request->input('annual_return') / 100;

        $years_to_invest = $retirement_age - $current_age;
        $monthly_return = $annual_return / 12;

        $future_value_of_current_investment = $current_investment * pow((1 + $monthly_return), ($years_to_invest * 12));
        $future_value_of_contributions = $monthly_contribution * (pow((1 + $monthly_return), ($years_to_invest * 12)) - 1) / $monthly_return;

        $future_value = $future_value_of_current_investment + $future_value_of_contributions;

        return response()->json(['future_value' => $future_value]);
    }
}
