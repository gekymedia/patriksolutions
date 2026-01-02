<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtSnowballCalculatorController extends Controller
{
    public function index()
    {
        return view('debt-snowball-calculator.index');
    }
}
