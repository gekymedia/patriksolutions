<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompoundInterestCalculatorController extends Controller
{
    public function index()
    {
        return view('compound-interest-calculator.index');
    }
}
