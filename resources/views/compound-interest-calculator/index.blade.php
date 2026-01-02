@extends('layouts.app')

@section('title', 'Compound Interest Calculator')
@section('page-title', 'Compound Interest Calculator')
@section('page-description', 'See how your money grows with compound interest')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Enter Your Details</h2>
                
                <form id="compoundForm">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign me-1"></i>Initial Investment ($)
                        </label>
                        <input type="number" id="principal" class="form-control" placeholder="0.00" step="0.01" value="10000" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave me-1"></i>Monthly Contribution ($)
                        </label>
                        <input type="number" id="monthlyContribution" class="form-control" placeholder="0.00" step="0.01" value="500">
                        <small class="text-muted">Amount you'll add each month (optional)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-percent me-1"></i>Annual Interest Rate (%)
                        </label>
                        <input type="number" id="rate" class="form-control" placeholder="0.00" step="0.01" value="7" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt me-1"></i>Time Period (Years)
                        </label>
                        <input type="number" id="years" class="form-control" placeholder="0" value="10" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-sync-alt me-1"></i>Compounding Frequency
                        </label>
                        <select id="compoundFrequency" class="form-control">
                            <option value="1">Annually</option>
                            <option value="2">Semi-Annually</option>
                            <option value="4" selected>Quarterly</option>
                            <option value="12">Monthly</option>
                            <option value="365">Daily</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem;">
                        <i class="fas fa-calculator me-2"></i>Calculate Compound Interest
                    </button>
                </form>
            </div>
        </div>

        <div class="results-wrapper">
            <div class="results-section investment-results">
                <h3><i class="fas fa-chart-line me-2"></i>Results</h3>
                <div id="results">
                    <div class="text-center" style="opacity: 0.8;">
                        <i class="fas fa-calculator" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>Enter your details to see how compound interest works</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function calculateCompoundInterest() {
            const principal = parseFloat(document.getElementById('principal').value) || 0;
            const monthlyContribution = parseFloat(document.getElementById('monthlyContribution').value) || 0;
            const annualRate = parseFloat(document.getElementById('rate').value) || 0;
            const years = parseFloat(document.getElementById('years').value) || 0;
            const compoundFrequency = parseFloat(document.getElementById('compoundFrequency').value) || 12;

            if (principal <= 0 || annualRate <= 0 || years <= 0) {
                return;
            }

            const monthlyRate = annualRate / 100 / 12;
            const months = years * 12;
            let balance = principal;
            let totalContributions = principal;

            // Calculate with monthly contributions
            for (let i = 0; i < months; i++) {
                balance = balance * (1 + monthlyRate) + monthlyContribution;
                totalContributions += monthlyContribution;
            }

            const interestEarned = balance - totalContributions;
            const totalContributionsAmount = principal + (monthlyContribution * months);

            displayResults(balance, totalContributionsAmount, interestEarned, years);
        }

        function displayResults(finalAmount, totalContributions, interestEarned, years) {
            const resultsDiv = document.getElementById('results');
            
            let html = `
                <div class="result-item" style="background: rgba(255,255,255,0.3); margin-bottom: 1.5rem; border: 2px solid rgba(255,255,255,0.5);">
                    <div class="result-label">
                        <i class="fas fa-piggy-bank me-2"></i>Total Contributions
                    </div>
                    <div class="result-value">$${totalContributions.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="result-item" style="background: rgba(255,255,255,0.2); margin-bottom: 1.5rem;">
                    <div class="result-label">
                        <i class="fas fa-chart-line me-2"></i>Interest Earned
                    </div>
                    <div class="result-value">$${interestEarned.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="result-item" style="background: rgba(255,255,255,0.3); margin-top: 1.5rem; border: 2px solid rgba(255,255,255,0.5);">
                    <div class="result-label">
                        <i class="fas fa-trophy me-2"></i>Final Balance
                    </div>
                    <div class="result-value" style="font-size: 2rem;">$${finalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="mt-4 p-3 rounded-modern" style="background: rgba(255,255,255,0.2);">
                    <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">
                        <i class="fas fa-info-circle me-2"></i>
                        After ${years} years, your investment will be worth <strong>$${finalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                    </p>
                </div>
            `;

            resultsDiv.innerHTML = html;
        }

        document.getElementById('compoundForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateCompoundInterest();
        });

        // Real-time calculation
        document.querySelectorAll('#compoundForm input, #compoundForm select').forEach(input => {
            input.addEventListener('input change', calculateCompoundInterest);
        });

        // Initial calculation
        calculateCompoundInterest();
    </script>
@endpush

