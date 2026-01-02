@extends('layouts.app')

@section('title', 'Mortgage Calculator')
@section('page-title', 'Mortgage Calculator')
@section('page-description', 'Calculate your monthly mortgage payment')

@push('styles')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-primary);
            padding: 0;
        }

        .calculator-wrapper {
            display: flex;
            gap: 24px;
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            flex-wrap: wrap;
        }
        
        .form-wrapper {
            flex: 1;
            min-width: 400px;
        }
        
        .results-wrapper {
            width: 400px;
            min-width: 350px;
        }
        
        @media (max-width: 992px) {
            .calculator-wrapper {
                flex-direction: column;
                margin: 20px auto;
            }
            
            .results-wrapper {
                width: 100%;
            }
        }

        .form-container {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .form-container h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        #results {
            margin-top: 0;
            padding: 2.5rem;
            background: var(--gradient-warm);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            color: white;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        #results h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .result-item {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .result-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(5px);
        }
        
        .result-item:last-child {
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }

        .result-label {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .result-value {
            font-weight: 700;
            color: white;
            font-size: 1.25rem;
        }
        
        .result-item:last-child .result-value {
            font-size: 1.75rem;
        }

        #mortgage-calculator-description {
            background: var(--gradient-primary);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        #mortgage-calculator-description h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: white;
        }

        #mortgage-calculator-description p {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.95);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .mortgage-terms {
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            background: var(--bg-light);
        }

        .mortgage-terms h2 {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            color: var(--text-primary);
            margin-bottom: 3rem;
        }

        .mortgage-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .mortgage-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .term-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .term-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .term-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .term-card h3::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .term-card p {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 1rem;
        }

        .mortgage-uses {
            background: white;
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .mortgage-uses h2 {
            font-size: 2.25rem;
            font-weight: 800;
            text-align: center;
            color: var(--text-primary);
            margin-bottom: 2.5rem;
        }

        .accordion-item {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 1rem;
            overflow: hidden;
            background: white;
        }

        .accordion-button {
            background: white;
            color: var(--text-primary);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            border: none;
            width: 100%;
            text-align: left;
            transition: all 0.3s ease;
        }

        .accordion-button:not(.collapsed) {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .accordion-body {
            padding: 1.5rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .accordion-body ul {
            margin-top: 1rem;
            padding-left: 1.5rem;
        }

        .accordion-body li {
            margin-bottom: 0.5rem;
        }

        .btn-cta {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }
    </style>
@endpush

@section('content')
<div id="mortgage-calculator-description" class="mb-4">
    <p>Use our mortgage calculator to get an idea of your monthly payment by adjusting the interest rate, down payment, home price and more. To find out how you can pay off your mortgage faster, try our <a href="{{ route('mortgage.payoff') }}" style="color: var(--primary-color); text-decoration: underline;">mortgage payoff calculator</a>.</p>
</div>

    <div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-calculator me-2"></i>Calculate Your Mortgage</h2>

                <form id="mortgage-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_value"><i class="fas fa-dollar-sign me-1"></i>Home Value ($)</label>
                                <input type="number" id="home_value" name="home_value" value="200000" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="down_payment_amount"><i class="fas fa-money-bill-wave me-1"></i>Down Payment Amount ($)</label>
                                <input type="number" id="down_payment_amount" name="down_payment_amount" value="40000" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="down_payment_percentage"><i class="fas fa-percent me-1"></i>Down Payment Percentage (%)</label>
                                <input type="number" id="down_payment_percentage" name="down_payment_percentage" value="20" min="0" max="100" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="interest_rate"><i class="fas fa-chart-line me-1"></i>Interest Rate (%)</label>
                                <input type="number" id="interest_rate" name="interest_rate" value="6.5" min="0" max="100" step="0.01" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mortgage_type"><i class="fas fa-calendar-alt me-1"></i>Mortgage Type</label>
                        <select id="mortgage_type" name="mortgage_type">
                            <option value="15_year" selected>15-year Fixed</option>
                            <option value="30_year">30-year Fixed</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="property_taxes"><i class="fas fa-building me-1"></i>Property Taxes ($)</label>
                                <input type="number" id="property_taxes" name="property_taxes" value="183" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_insurance"><i class="fas fa-shield-alt me-1"></i>Home Insurance ($)</label>
                                <input type="number" id="home_insurance" name="home_insurance" value="125" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hoa_dues"><i class="fas fa-home me-1"></i>HOA Dues ($)</label>
                        <input type="number" id="hoa_dues" name="hoa_dues" value="100" />
                    </div>

                    <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem;">
                        <i class="fas fa-calculator me-2"></i> Calculate Mortgage
                    </button>
                </form>
            </div>
        </div>

        <div class="results-wrapper">
            <div id="results">
                <h3><i class="fas fa-chart-line"></i> Payment Breakdown</h3>
                <div class="result-item">
                    <span class="result-label"><i class="fas fa-money-bill-wave"></i> Principal & Interest</span>
                    <span class="result-value" id="principal_interest">$0.00</span>
                </div>
                <div class="result-item">
                    <span class="result-label"><i class="fas fa-building"></i> Property Taxes</span>
                    <span class="result-value" id="property_taxes_result">$0.00</span>
                </div>
                <div class="result-item">
                    <span class="result-label"><i class="fas fa-shield-alt"></i> Home Insurance</span>
                    <span class="result-value" id="home_insurance_result">$0.00</span>
                </div>
                <div class="result-item">
                    <span class="result-label"><i class="fas fa-home"></i> HOA Dues</span>
                    <span class="result-value" id="hoa_dues_result">$0.00</span>
                </div>
                <div class="result-item">
                    <span class="result-label"><i class="fas fa-coins"></i> Total Monthly Payment</span>
                    <span class="result-value" id="total_payment">$0.00</span>
                </div>
            </div>
        </div>
    </div>
    <div class="mortgage-terms">
        <h2><i class="fas fa-book me-2"></i>Explanation of Mortgage Terms</h2>
        <div class="mortgage-grid">
            <div class="term-card">
                <h3><i class="fas fa-home"></i>Home Price</h3>
                <p>
                    Across the country, average home prices have been going up. Despite the rise in home prices, you can
                    still find a perfect home that's within your budget! As you begin to house hunt, just make sure to
                    consider the most important question: <strong>How much house can I afford?</strong>
                </p>
            </div>

            <div class="term-card">
                <h3><i class="fas fa-money-bill-wave"></i>Down Payment</h3>
                <p>
                    The initial cash payment, usually represented as a percentage of the total purchase price, a home
                    buyer makes when purchasing a home. For example, a 20% down payment on a $200,000 house is $40,000.
                </p>
            </div>

            <div class="term-card">
                <h3><i class="fas fa-calendar-check"></i>Mortgage Types</h3>
                <p>
                    Learn the differences between <strong>15-Year Fixed-Rate Mortgage</strong>, <strong>30-Year
                        Fixed-Rate Mortgage</strong>, and <strong>5/1 Adjustable-Rate Mortgage (ARM)</strong>.
                </p>
            </div>

            <div class="term-card">
                <h3><i class="fas fa-percentage"></i>Interest Rate</h3>
                <p>
                    The ongoing cost of financing a home purchase, generally shown as an annual percentage of the
                    outstanding loan.
                </p>
            </div>

            <div class="term-card">
                <h3><i class="fas fa-shield-alt"></i>Private Mortgage Insurance (PMI)</h3>
                <p>
                    This extra cost is added to your monthly payment to protect the lender if you don't pay your
                    mortgage. Avoid PMI with at least 20% down.
                </p>
            </div>

            <div class="term-card">
                <h3><i class="fas fa-umbrella"></i>Homeowner's Insurance</h3>
                <p>
                    Covers damages to your home from events like fire, windstorms, or theft, as well as possessions
                    inside your home.
                </p>
            </div>
        </div>
    </div>


    <div class="mortgage-uses">
        <h2><i class="fas fa-lightbulb me-2"></i>How to Make the Most of Your Mortgage Calculator</h2>
        <div class="accordion" id="mortgageUsesAccordion">
            <!-- Understand Your Mortgage Payment -->
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button"
                        data-bs-toggle="collapse" data-bs-target="#paymentBreakdown" aria-expanded="true"
                        aria-controls="paymentBreakdown">
                        <i class="fas fa-info-circle me-2"></i>Understand Your Mortgage Payment
                    </button>
                </h3>
                <div id="paymentBreakdown" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        A monthly mortgage payment is made up of several costs:
                        <ul>
                            <li><strong>Principal & Interest (P&I):</strong> The repayment of your loan and interest.</li>
                            <li><strong>Taxes:</strong> Property taxes based on your home's value.</li>
                            <li><strong>Insurance:</strong> Homeowner's insurance to protect your property.</li>
                            <li><strong>PMI:</strong> Private Mortgage Insurance, if applicable.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Compare Different Mortgage Types -->
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#compareMortgages" aria-expanded="false"
                        aria-controls="compareMortgages">
                        <i class="fas fa-balance-scale me-2"></i>Compare Different Mortgage Types
                    </button>
                </h3>
                <div id="compareMortgages" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Compare the costs of different loan types:
                        <ul>
                            <li>Estimate total interest paid for a 15-year vs. 30-year mortgage.</li>
                            <li>See how shorter loan durations save you money over time.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Calculate Your Down Payment -->
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#downPaymentImpact"
                        aria-expanded="false" aria-controls="downPaymentImpact">
                        <i class="fas fa-calculator me-2"></i>Calculate Your Down Payment
                    </button>
                </h3>
                <div id="downPaymentImpact" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Adjust your down payment to see how it affects:
                        <ul>
                            <li>Your monthly payment.</li>
                            <li>Private Mortgage Insurance (PMI) requirements.</li>
                            <li>Loan qualification criteria.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="#" class="btn-cta">
                <i class="fas fa-check-circle me-2"></i>Get Pre-Approved Now
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            function calculateMortgage() {
                const homeValue = parseFloat($('#home_value').val()) || 0;
                const downPaymentAmount = parseFloat($('#down_payment_amount').val()) || 0;
                const interestRate = parseFloat($('#interest_rate').val()) || 0;
                const mortgageType = $('#mortgage_type').val();
                const propertyTaxes = parseFloat($('#property_taxes').val()) || 0;
                const homeInsurance = parseFloat($('#home_insurance').val()) || 0;
                const hoaDues = parseFloat($('#hoa_dues').val()) || 0;

                if (homeValue <= 0 || interestRate <= 0) {
                    return;
                }

                // Calculate the loan amount
                const loanAmount = homeValue - downPaymentAmount;
                const loanTerm = mortgageType === '15_year' ? 15 * 12 : 30 * 12;
                const monthlyRate = (interestRate / 100) / 12;

                // Calculate the monthly payment (Principal + Interest)
                let principalAndInterest = 0;
                if (loanAmount > 0 && monthlyRate > 0) {
                    principalAndInterest = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, loanTerm)) / (Math.pow(1 + monthlyRate, loanTerm) - 1);
                }

                // Calculate total payment
                const totalMonthlyPayment = principalAndInterest + propertyTaxes + homeInsurance + hoaDues;

                // Update results
                $('#principal_interest').text('$' + principalAndInterest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#property_taxes_result').text('$' + propertyTaxes.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#home_insurance_result').text('$' + homeInsurance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#hoa_dues_result').text('$' + hoaDues.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#total_payment').text('$' + totalMonthlyPayment.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            // Real-time calculation on input change
            $('#mortgage-form input, #mortgage-form select').on('input change', function() {
                calculateMortgage();
            });

            // Handle form submission
            $('#mortgage-form').on('submit', function (event) {
                event.preventDefault();
                calculateMortgage();
            });
            
            // Initial calculation
            calculateMortgage();
        });
    </script>
@endpush