@extends('layouts.app')

@section('title', 'Debt Snowball Calculator')
@section('page-title', 'Debt Snowball Calculator')
@section('page-description', 'Pay off your debts faster using the debt snowball method')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
@endpush

@section('content')

    <div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Enter Your Debts</h2>
                
                <form id="debtForm">
                    <div id="debtsContainer">
                        <div class="debt-item mb-4 p-3 rounded-modern" style="background: var(--bg-light); border: 1px solid var(--border-color);">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-tag me-1"></i>Debt Name
                                    </label>
                                    <input type="text" class="form-control debt-name" placeholder="e.g., Credit Card" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-dollar-sign me-1"></i>Current Balance ($)
                                    </label>
                                    <input type="number" class="form-control debt-balance" placeholder="0.00" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-percent me-1"></i>Interest Rate (%)
                                    </label>
                                    <input type="number" class="form-control debt-rate" placeholder="0.00" step="0.01" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-calendar me-1"></i>Minimum Payment ($)
                                    </label>
                                    <input type="number" class="form-control debt-payment" placeholder="0.00" step="0.01" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-modern mb-3" id="addDebtBtn" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2);">
                        <i class="fas fa-plus me-2"></i>Add Another Debt
                    </button>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave me-1"></i>Extra Payment Available ($)
                        </label>
                        <input type="number" id="extraPayment" class="form-control" placeholder="0.00" step="0.01" value="0">
                        <small class="text-muted">Any extra money you can put toward debt each month</small>
                    </div>

                    <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem;">
                        <i class="fas fa-calculator me-2"></i>Calculate Debt Payoff Plan
                    </button>
                </form>
            </div>
        </div>

        <div class="results-wrapper">
            <div class="results-section budget-results">
                <h3><i class="fas fa-chart-line me-2"></i>Payoff Plan</h3>
                <div id="results">
                    <p class="text-center" style="opacity: 0.8;">Enter your debts and click calculate to see your payoff plan</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let debtCount = 1;

        document.getElementById('addDebtBtn').addEventListener('click', function() {
            debtCount++;
            const container = document.getElementById('debtsContainer');
            const newDebt = document.querySelector('.debt-item').cloneNode(true);
            newDebt.querySelectorAll('input').forEach(input => input.value = '');
            container.appendChild(newDebt);
        });

        document.getElementById('debtForm').addEventListener('submit', function(e) {
            e.preventDefault();
            calculateDebtSnowball();
        });

        function calculateDebtSnowball() {
            const debts = [];
            document.querySelectorAll('.debt-item').forEach(item => {
                const name = item.querySelector('.debt-name').value;
                const balance = parseFloat(item.querySelector('.debt-balance').value) || 0;
                const rate = parseFloat(item.querySelector('.debt-rate').value) || 0;
                const payment = parseFloat(item.querySelector('.debt-payment').value) || 0;

                if (name && balance > 0) {
                    debts.push({ name, balance, rate, payment });
                }
            });

            if (debts.length === 0) {
                alert('Please enter at least one debt');
                return;
            }

            // Sort by balance (smallest first - snowball method)
            debts.sort((a, b) => a.balance - b.balance);

            const extraPayment = parseFloat(document.getElementById('extraPayment').value) || 0;
            let totalMonths = 0;
            let totalInterest = 0;
            let currentExtra = extraPayment;
            const payoffPlan = [];

            debts.forEach((debt, index) => {
                let remaining = debt.balance;
                let months = 0;
                let interestPaid = 0;
                const monthlyRate = debt.rate / 100 / 12;

                while (remaining > 0.01 && months < 600) {
                    const interest = remaining * monthlyRate;
                    interestPaid += interest;
                    let payment = debt.payment + (index === 0 ? currentExtra : 0);
                    
                    if (payment > remaining + interest) {
                        payment = remaining + interest;
                    }

                    remaining = remaining + interest - payment;
                    months++;
                }

                totalMonths += months;
                totalInterest += interestPaid;
                payoffPlan.push({
                    name: debt.name,
                    months: months,
                    interest: interestPaid,
                    totalPaid: debt.balance + interestPaid
                });

                // After first debt is paid, add its payment to extra
                if (index === 0) {
                    currentExtra += debt.payment;
                }
            });

            displayResults(payoffPlan, totalMonths, totalInterest, debts.reduce((sum, d) => sum + d.balance, 0));
        }

        function displayResults(plan, totalMonths, totalInterest, totalDebt) {
            const resultsDiv = document.getElementById('results');
            let html = '';

            plan.forEach((item, index) => {
                html += `
                    <div class="result-item ${index === 0 ? 'border-warning' : ''}" style="margin-bottom: 1rem;">
                        <div>
                            <div class="result-label">
                                <i class="fas fa-credit-card me-2"></i>${item.name}
                            </div>
                            <div style="font-size: 0.875rem; opacity: 0.8; margin-top: 0.25rem;">
                                ${item.months} months • $${item.totalPaid.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} total
                            </div>
                        </div>
                        <div class="result-value">$${item.interest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                    </div>
                `;
            });

            html += `
                <div class="result-item" style="background: rgba(255,255,255,0.3); margin-top: 1.5rem; border: 2px solid rgba(255,255,255,0.5);">
                    <div class="result-label">
                        <i class="fas fa-calendar-alt me-2"></i>Total Time
                    </div>
                    <div class="result-value">${Math.floor(totalMonths / 12)} years ${totalMonths % 12} months</div>
                </div>
                <div class="result-item" style="background: rgba(255,255,255,0.3);">
                    <div class="result-label">
                        <i class="fas fa-dollar-sign me-2"></i>Total Interest
                    </div>
                    <div class="result-value">$${totalInterest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
                <div class="result-item" style="background: rgba(255,255,255,0.3);">
                    <div class="result-label">
                        <i class="fas fa-coins me-2"></i>Total Paid
                    </div>
                    <div class="result-value">$${(totalDebt + totalInterest).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                </div>
            `;

            resultsDiv.innerHTML = html;
        }
    </script>
@endpush

