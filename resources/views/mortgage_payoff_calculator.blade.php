@extends('layouts.app')

@section('title', 'Mortgage Payoff Calculator')
@section('page-title', 'Mortgage Payoff Calculator')
@section('page-description', 'Calculate how to pay off your mortgage faster')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
        }
        
        .container {
            padding: 30px 20px;
            max-width: 1200px;
            margin: auto;
        }
        
        .calculator-wrapper {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }
        
        .form-container {
            flex: 1;
            min-width: 400px;
        }
        
        .results-container {
            width: 400px;
            min-width: 350px;
        }
        
        @media (max-width: 992px) {
            .calculator-wrapper {
                flex-direction: column;
            }
            
            .results-container {
                width: 100%;
            }
        }
        
        .calculator-container {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .result {
            margin-top: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
            color: white;
            position: sticky;
            top: 20px;
        }
        
        .result h4 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
        }
        
        .result-value {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .intro-text {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8eef8 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            border-left: 4px solid #667eea;
            color: #333;
        }
        
        .intro-text p {
            margin: 0;
            line-height: 1.6;
        }
    </style>
@endpush

@section('content')
<div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Enter Your Mortgage Details</h2>

                    <form id="mortgage-form">
                        <div class="form-group">
                            <label for="loan_balance"><i class="fas fa-dollar-sign"></i> Loan Balance ($):</label>
                            <input type="number" id="loan_balance" name="loan_balance" value="300000" min="0" step="1000" required>
                        </div>

                        <div class="form-group">
                            <label for="interest_rate"><i class="fas fa-percentage"></i> Annual Interest Rate (%):</label>
                            <input type="number" id="interest_rate" name="interest_rate" value="4.5" min="0" max="100" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label for="monthly_payment"><i class="fas fa-calendar-alt"></i> Monthly Payment ($):</label>
                            <input type="number" id="monthly_payment" name="monthly_payment" value="1500" min="0" step="100" required>
                        </div>

                        <button type="submit"><i class="fas fa-calculator"></i> Calculate Payoff Date</button>
                    </form>
                </div>
            </div>

            <div class="results-container">
                <div class="result" id="result" style="display: none;">
                    <h4><i class="fas fa-calendar-check"></i> Payoff Date</h4>
                    <div class="result-value" id="payoff_date">-</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculatePayoff() {
            let loanBalance = parseFloat(document.getElementById('loan_balance').value) || 0;
            let interestRate = parseFloat(document.getElementById('interest_rate').value) || 0;
            let monthlyPayment = parseFloat(document.getElementById('monthly_payment').value) || 0;

            if (loanBalance <= 0 || interestRate < 0 || monthlyPayment <= 0) {
                document.getElementById('result').style.display = 'none';
                return;
            }

            let monthlyRate = interestRate / 100 / 12;
            let months = 0;
            let balance = loanBalance;

            while (balance > 0.01) {
                let interest = balance * monthlyRate;
                let principal = monthlyPayment - interest;

                if (principal <= 0) {
                    document.getElementById('result').style.display = 'none';
                    alert("The monthly payment is too low to cover the interest. Please enter a higher amount.");
                    return;
                }

                balance -= principal;
                months++;

                if (months > 600) { // Safety limit (50 years)
                    alert("The calculation suggests a very long payoff period. Please verify your inputs.");
                    return;
                }

                if (balance < 0) {
                    balance = 0;
                }
            }

            let currentDate = new Date();
            currentDate.setMonth(currentDate.getMonth() + months);
            let payoffDate = currentDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            document.getElementById('payoff_date').textContent = payoffDate;
            document.getElementById('result').style.display = 'block';
        }

        document.getElementById('mortgage-form').addEventListener('submit', function(e) {
            e.preventDefault();
            calculatePayoff();
        });

        // Real-time calculation
        document.getElementById('loan_balance').addEventListener('input', calculatePayoff);
        document.getElementById('interest_rate').addEventListener('input', calculatePayoff);
        document.getElementById('monthly_payment').addEventListener('input', calculatePayoff);
    </script>
@endpush
