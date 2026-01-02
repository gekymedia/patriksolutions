<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NetWorthCalculatorController extends Controller
{
    public function index()
    {
        return view('net-worth-calculator.index');
    }
}
