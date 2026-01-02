<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MortgageCalculatorController extends Controller
{
    public function index()
    {
        return view('mortgage_calculator');
    }

    public function calculate(Request $request)
    {
        // Fetch the user input
        $homeValue = $request->input('home_value');
        $downPaymentAmount = $request->input('down_payment_amount');
        $downPaymentPercentage = $request->input('down_payment_percentage') / 100;
        $interestRate = $request->input('interest_rate') / 100;
        $mortgageType = $request->input('mortgage_type');
        $propertyTaxes = $request->input('property_taxes');
        $homeInsurance = $request->input('home_insurance');
        $hoaDues = $request->input('hoa_dues');

        // Calculate loan amount
        $loanAmount = $homeValue - $downPaymentAmount;
        $loanTerm = $mortgageType === '15_year' ? 15 * 12 : 30 * 12;
        $monthlyRate = $interestRate / 12;

        // Monthly payment formula
        $principalAndInterest = $loanAmount * ($monthlyRate * pow(1 + $monthlyRate, $loanTerm)) / (pow(1 + $monthlyRate, $loanTerm) - 1);

        // Total monthly payment
        $totalMonthlyPayment = $principalAndInterest + $propertyTaxes + $homeInsurance + $hoaDues;

        // Return results
        return response()->json([
            'principal_and_interest' => number_format($principalAndInterest, 2),
            'property_taxes' => number_format($propertyTaxes, 2),
            'home_insurance' => number_format($homeInsurance, 2),
            'hoa_dues' => number_format($hoaDues, 2),
            'total_payment' => number_format($totalMonthlyPayment, 2),
        ]);
    }
}
