<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MortgagePayoffController extends Controller
{
    // Show the mortgage payoff calculator form
    public function index()
    {
        return view('mortgage_payoff_calculator');
    }

    // Calculate the mortgage payoff based on user input
    public function calculate(Request $request)
    {
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'monthly_payment' => 'required|numeric|min:1',
        ]);

        $loanAmount = $request->input('loan_amount');
        $interestRate = $request->input('interest_rate') / 100 / 12; // Monthly rate
        $monthlyPayment = $request->input('monthly_payment');

        // Mortgage payoff calculation formula
        $numPayments = log($monthlyPayment) - log($monthlyPayment - $loanAmount * $interestRate) / log(1 + $interestRate);

        if ($numPayments <= 0) {
            return redirect()->route('mortgage.payoff')->with('error', 'Error: Unable to calculate. Check your values.');
        }

        $numPayments = round($numPayments);

        return view('mortgage_payoff_calculator', compact('numPayments'));
    }
}
