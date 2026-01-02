@extends('layouts.app')

@section('title', 'Net Worth Calculator')
@section('page-title', 'Net Worth Calculator')
@section('page-description', 'Calculate your net worth by tracking your assets and liabilities')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Your Financial Picture</h2>
                
                <form id="netWorthForm">
                    <h4 class="mb-3" style="color: var(--success-color);">
                        <i class="fas fa-arrow-up me-2"></i>Assets (What You Own)
                    </h4>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-home me-1"></i>Home Value
                        </label>
                        <input type="number" id="homeValue" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-car me-1"></i>Vehicle Value
                        </label>
                        <input type="number" id="vehicleValue" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-university me-1"></i>Savings & Checking Accounts
                        </label>
                        <input type="number" id="savings" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-chart-line me-1"></i>Investments (Stocks, Bonds, etc.)
                        </label>
                        <input type="number" id="investments" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-piggy-bank me-1"></i>Retirement Accounts (401k, IRA, etc.)
                        </label>
                        <input type="number" id="retirement" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-coins me-1"></i>Other Assets
                        </label>
                        <input type="number" id="otherAssets" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3" style="color: var(--danger-color);">
                        <i class="fas fa-arrow-down me-2"></i>Liabilities (What You Owe)
                    </h4>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-home me-1"></i>Mortgage Balance
                        </label>
                        <input type="number" id="mortgage" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-car me-1"></i>Auto Loan Balance
                        </label>
                        <input type="number" id="autoLoan" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-credit-card me-1"></i>Credit Card Debt
                        </label>
                        <input type="number" id="creditCards" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-graduation-cap me-1"></i>Student Loans
                        </label>
                        <input type="number" id="studentLoans" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-invoice-dollar me-1"></i>Other Debts
                        </label>
                        <input type="number" id="otherDebts" class="form-control" placeholder="0.00" step="0.01" value="0">
                    </div>

                    <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem;">
                        <i class="fas fa-calculator me-2"></i>Calculate Net Worth
                    </button>
                </form>
            </div>
        </div>

        <div class="results-wrapper">
            <div class="results-section investment-results">
                <h3><i class="fas fa-chart-pie me-2"></i>Your Net Worth</h3>
                <div id="results">
                    <div class="text-center" style="opacity: 0.8;">
                        <i class="fas fa-calculator" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>Enter your assets and liabilities to calculate your net worth</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateNetWorth() {
            // Assets
            const homeValue = parseFloat(document.getElementById('homeValue').value) || 0;
            const vehicleValue = parseFloat(document.getElementById('vehicleValue').value) || 0;
            const savings = parseFloat(document.getElementById('savings').value) || 0;
            const investments = parseFloat(document.getElementById('investments').value) || 0;
            const retirement = parseFloat(document.getElementById('retirement').value) || 0;
            const otherAssets = parseFloat(document.getElementById('otherAssets').value) || 0;

            // Liabilities
            const mortgage = parseFloat(document.getElementById('mortgage').value) || 0;
            const autoLoan = parseFloat(document.getElementById('autoLoan').value) || 0;
            const creditCards = parseFloat(document.getElementById('creditCards').value) || 0;
            const studentLoans = parseFloat(document.getElementById('studentLoans').value) || 0;
            const otherDebts = parseFloat(document.getElementById('otherDebts').value) || 0;

            const totalAssets = homeValue + vehicleValue + savings + investments + retirement + otherAssets;
            const totalLiabilities = mortgage + autoLoan + creditCards + studentLoans + otherDebts;
            const netWorth = totalAssets - totalLiabilities;

            displayResults(totalAssets, totalLiabilities, netWorth);
        }

        function displayResults(assets, liabilities, netWorth) {
            const resultsDiv = document.getElementById('results');
            const isPositive = netWorth >= 0;
            
            let html = `
                <div class="result-item" style="background: rgba(255,255,255,0.3); margin-bottom: 1.5rem; border: 2px solid rgba(255,255,255,0.5);">
                    <div class="result-label">
                        <i class="fas fa-dollar-sign me-2"></i>Total Assets
                    </div>
                    <div class="result-value">$${assets.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="result-item" style="background: rgba(255,255,255,0.2); margin-bottom: 1.5rem;">
                    <div class="result-label">
                        <i class="fas fa-minus-circle me-2"></i>Total Liabilities
                    </div>
                    <div class="result-value">$${liabilities.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="result-item" style="background: ${isPositive ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)'}; margin-top: 1.5rem; border: 2px solid ${isPositive ? 'rgba(16, 185, 129, 0.5)' : 'rgba(239, 68, 68, 0.5)'};">
                    <div class="result-label">
                        <i class="fas fa-balance-scale me-2"></i>Net Worth
                    </div>
                    <div class="result-value" style="font-size: 2rem;">$${netWorth.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
            `;

            resultsDiv.innerHTML = html;
        }

        document.getElementById('netWorthForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateNetWorth();
        });

        // Real-time calculation
        document.querySelectorAll('#netWorthForm input').forEach(input => {
            input.addEventListener('input', calculateNetWorth);
        });
    </script>
@endpush

