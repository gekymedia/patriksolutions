@extends('layouts.app')

@section('title', 'Retirement Calculator')
@section('page-title', 'Retirement Calculator')
@section('page-description', 'Plan your retirement and calculate how much you need to save')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
    
    <style>
        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
        }

        .form-section {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            padding: 2.5rem;
            flex: 1;
        }
        
        .results-section {
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            padding: 2.5rem;
            flex: 1;
            color: white;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .form-section h4 {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            color: white;
            padding: 16px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #007BFF;
            border: none;
            width: 100%;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }

        #your-results {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 24px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        #your-results h4 {
            color: white;
            margin-bottom: 24px;
            font-size: 1.5rem;
            font-weight: 600;
        }

        #your-results h3 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 16px 0;
        }
        
        #your-results p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }
        
        #years-display {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 12px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #2c5364;
            box-shadow: 0 0 0 0.2rem rgba(44, 83, 100, 0.25);
        }
        
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }
        
        @media (max-width: 992px) {
            .flex-container {
                flex-direction: column;
            }
            
            .results-section {
                position: relative;
                top: 0;
            }
        }
    </style>
@endpush

@section('content')
<div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Enter Your Retirement Details</h2>
                {{-- <p>Owning a time machine isn't the only way to predict what your investments could be worth in the future.
                Our investment calculator can give you an idea of your earning potential. Plug in your numbers to get
                started.</p> --}}
        </div>

        <div class="flex-container">
            <!-- Form Section -->
            <div class="form-section">
                <h4><i class="fas fa-calculator"></i> Enter Your Information </h4>
                <form id="investmentForm" method="POST" action="{{ route('retirement_calculator.calculate') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_age" class="form-label">Enter your current age:</label>
                        <input type="number" class="form-control" id="current_age" name="current_age" required>
                        <div id="currentAgeError" class="error-message">Current age cannot be higher than retirement
                            age.</div>
                    </div>
                    <div class="mb-3">
                        <label for="retirement_age" class="form-label">Enter the age you plan to retire:</label>
                        <input type="number" class="form-control" id="retirement_age" name="retirement_age" required>
                        <div id="retirementAgeError" class="error-message">Retirement age cannot be less than 0.</div>
                    </div>
                    <div class="mb-3">
                        <label for="current_investment" class="form-label">How much do you currently have in
                            investments?</label>
                        <input type="number" class="form-control" id="current_investment" name="current_investment"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="monthly_contribution" class="form-label">How much will you contribute
                            monthly?</label>
                        <input type="number" class="form-control" id="monthly_contribution" name="monthly_contribution"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="annual_return" class="form-label">What do you think your annual return will be? (in
                            %)</label>
                        <input type="number" class="form-control" id="annual_return" name="annual_return" required>
                    </div>
                    <button type="button" class="btn btn-modern btn-modern-primary w-100" id="calculateButton" style="padding: 1rem; font-size: 1.1rem;">
                        <i class="fas fa-calculator me-2"></i> Calculate
                    </button>
                </form>
            </div>
        </div>

        <!-- Results Section -->
        <div class="results-wrapper">
            <div class="results-section retirement-results">
                <h3><i class="fas fa-piggy-bank me-2"></i>Your Results</h3>
                <div id="your-results">
                    <p>Estimated Retirement Savings</p>
                    <p id="years-display"></p>
                    <h3 id="result">$0.00</h3>
                    <div class="mt-3">
                        <label for="currency-select" class="form-label">Convert to another currency:</label>
                        <input type="text" id="currency-search" class="form-control"
                            placeholder="Search currency or country">
                        <select id="currency-select" class="form-control mt-2"></select>
                        <button id="convert-button" class="btn btn-secondary mt-2">Convert</button>
                        <p id="converted-result" class="mt-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentAgeInput = document.getElementById('current_age');
            const retirementAgeInput = document.getElementById('retirement_age');
            const currentAgeError = document.getElementById('currentAgeError');
            const retirementAgeError = document.getElementById('retirementAgeError');
            const yearsDisplay = document.getElementById('years-display');
            const calculateButton = document.getElementById('calculateButton');
            const investmentForm = document.getElementById('investmentForm');
            const resultElement = document.getElementById('result');
            const currencySelect = document.getElementById('currency-select');
            const currencySearch = document.getElementById('currency-search');
            const convertButton = document.getElementById('convert-button');
            const convertedResult = document.getElementById('converted-result');

            let exchangeRates = {};

            // Fetch currency list and exchange rates
            function fetchCurrencies() {
                $.ajax({
                    url: 'https://api.exchangerate-api.com/v4/latest/USD', // You can use any reliable API
                    method: 'GET',
                    success: function(data) {
                        exchangeRates = data.rates;
                        populateCurrencySelect();
                    },
                    error: function() {
                        alert('Failed to load currency data.');
                    }
                });
            }

            // Populate the currency select dropdown
            function populateCurrencySelect() {
                for (const [currency, rate] of Object.entries(exchangeRates)) {
                    const option = document.createElement('option');
                    option.value = currency;
                    option.textContent = `${currency} - ${getCurrencyName(currency)}`;
                    currencySelect.appendChild(option);
                }
            }

            // Get currency name from code
            function getCurrencyName(currencyCode) {
                const currencyNames = {
                    "USD": "United States Dollar",
                    "EUR": "Euro",
                    "JPY": "Japanese Yen",
                    "GBP": "British Pound Sterling",
                    "AUD": "Australian Dollar",
                    "CAD": "Canadian Dollar",
                    "CHF": "Swiss Franc",
                    "CNY": "Chinese Yuan",
                    "SEK": "Swedish Krona",
                    "NZD": "New Zealand Dollar",
                    "MXN": "Mexican Peso",
                    "SGD": "Singapore Dollar",
                    "HKD": "Hong Kong Dollar",
                    "NOK": "Norwegian Krone",
                    "KRW": "South Korean Won",
                    "TRY": "Turkish Lira",
                    "INR": "Indian Rupee",
                    "RUB": "Russian Ruble",
                    "BRL": "Brazilian Real",
                    "ZAR": "South African Rand",
                    "DKK": "Danish Krone",
                    "PLN": "Polish Zloty",
                    "TWD": "New Taiwan Dollar",
                    "THB": "Thai Baht",
                    "IDR": "Indonesian Rupiah",
                    "HUF": "Hungarian Forint",
                    "CZK": "Czech Koruna",
                    "ILS": "Israeli New Shekel",
                    "CLP": "Chilean Peso",
                    "PHP": "Philippine Peso",
                    "AED": "United Arab Emirates Dirham",
                    "COP": "Colombian Peso",
                    "SAR": "Saudi Riyal",
                    "MYR": "Malaysian Ringgit",
                    "RON": "Romanian Leu",
                    "BGN": "Bulgarian Lev",
                    "ARS": "Argentine Peso",
                    "HRK": "Croatian Kuna",
                    "PEN": "Peruvian Sol",
                    "EGP": "Egyptian Pound",
                    "PKR": "Pakistani Rupee",
                    "VND": "Vietnamese Dong",
                    "KWD": "Kuwaiti Dinar",
                    "BHD": "Bahraini Dinar",
                    "OMR": "Omani Rial",
                    "QAR": "Qatari Riyal",
                    "IRR": "Iranian Rial",
                    "NGN": "Nigerian Naira",
                    "GHS": "Ghanaian Cedi",
                    "KES": "Kenyan Shilling",
                    "TZS": "Tanzanian Shilling",
                    "UGX": "Ugandan Shilling",
                    "MAD": "Moroccan Dirham",
                    "DZD": "Algerian Dinar",
                    "TND": "Tunisian Dinar",
                    "LBP": "Lebanese Pound",
                    "JOD": "Jordanian Dinar",
                    "IQD": "Iraqi Dinar",
                    "LYD": "Libyan Dinar",
                    "AFN": "Afghan Afghani",
                    "XOF": "West African CFA Franc",
                    "XAF": "Central African CFA Franc",
                    "XCD": "East Caribbean Dollar",
                    "BBD": "Barbadian Dollar",
                    "BMD": "Bermudian Dollar",
                    "BND": "Brunei Dollar",
                    "BWP": "Botswana Pula",
                    "BZD": "Belize Dollar",
                    "CDF": "Congolese Franc",
                    "DJF": "Djiboutian Franc",
                    "FJD": "Fijian Dollar",
                    "GIP": "Gibraltar Pound",
                    "GTQ": "Guatemalan Quetzal",
                    "GYD": "Guyanese Dollar",
                    "HTG": "Haitian Gourde",
                    "ISK": "Icelandic Krona",
                    "JMD": "Jamaican Dollar",
                    "KYD": "Cayman Islands Dollar",
                    "LRD": "Liberian Dollar",
                    "LSL": "Lesotho Loti",
                    "MGA": "Malagasy Ariary",
                    "MRO": "Mauritanian Ouguiya",
                    "MUR": "Mauritian Rupee",
                    "MVR": "Maldivian Rufiyaa",
                    "MWK": "Malawian Kwacha",
                    "NAD": "Namibian Dollar",
                    "NIO": "Nicaraguan Cordoba",
                    "PGK": "Papua New Guinean Kina",
                    "PYG": "Paraguayan Guarani",
                    "SBD": "Solomon Islands Dollar",
                    "SCR": "Seychellois Rupee",
                    "SLL": "Sierra Leonean Leone",
                    "SZL": "Swazi Lilangeni",
                    "TOP": "Tongan Pa'anga",
                    "TTD": "Trinidad and Tobago Dollar",
                    "VUV": "Vanuatu Vatu",
                    "WST": "Samoan Tala",
                    "YER": "Yemeni Rial",
                    "ZMW": "Zambian Kwacha"
                };

                return currencyNames[currencyCode] || currencyCode;
            }

            // Filter currencies based on search input
            currencySearch.addEventListener('input', function() {
                const searchQuery = currencySearch.value.toLowerCase();
                const options = currencySelect.options;
                for (let i = 0; i < options.length; i++) {
                    const optionText = options[i].textContent.toLowerCase();
                    options[i].style.display = optionText.includes(searchQuery) ? '' : 'none';
                }
            });

            // Handle the conversion
            convertButton.addEventListener('click', function() {
                const selectedCurrency = currencySelect.value;
                const futureValue = parseFloat(resultElement.textContent.replace(/[^0-9.-]+/g,
                    '')); // Extract numeric value

                if (selectedCurrency && !isNaN(futureValue)) {
                    const conversionRate = exchangeRates[selectedCurrency];
                    const convertedValue = futureValue * conversionRate;
                    convertedResult.textContent =
                        `Converted amount: ${convertedValue.toLocaleString('en-US', { style: 'currency', currency: selectedCurrency })}`;
                } else {
                    alert('Please select a valid currency.');
                }
            });

            function validateAges() {
                const currentAge = parseInt(currentAgeInput.value);
                const retirementAge = parseInt(retirementAgeInput.value);
                let valid = true;

                if (currentAge > retirementAge) {
                    currentAgeError.style.display = 'block';
                    valid = false;
                } else {
                    currentAgeError.style.display = 'none';
                }

                if (retirementAge < 7) {
                    retirementAgeError.style.display = 'block';
                    valid = false;
                } else {
                    retirementAgeError.style.display = 'none';
                }

                return valid;
            }

            function calculateYears() {
                const currentAge = parseInt(currentAgeInput.value);
                const retirementAge = parseInt(retirementAgeInput.value);
                const years = retirementAge - currentAge;

                if (!isNaN(years) && years > 0) {
                    yearsDisplay.textContent = `In ${years} years, your investment could be worth:`;
                } else {
                    yearsDisplay.textContent = '';
                }
            }

            currentAgeInput.addEventListener('input', function() {
                validateAges();
                calculateYears();
            });

            retirementAgeInput.addEventListener('input', function() {
                validateAges();
                calculateYears();
            });

            function calculateRetirement() {
                if ($('#investmentForm')[0].checkValidity() && validateAges()) {
                    $.ajax({
                        url: investmentForm.action,
                        method: investmentForm.method,
                        data: $(investmentForm).serialize(),
                        success: function(response) {
                            const futureValue = response.future_value;
                            resultElement.textContent =
                                `$${futureValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                        },
                        error: function() {
                            alert('An error occurred while calculating your retirement savings.');
                        }
                    });
                }
            }

            calculateButton.addEventListener('click', function() {
                if ($('#investmentForm')[0].checkValidity() && validateAges()) {
                    calculateRetirement();
                } else {
                    $('#investmentForm')[0].reportValidity();
                }
            });
            
            // Real-time calculation on input change
            $('#current_age, #retirement_age, #current_investment, #monthly_contribution, #annual_return').on('input', function() {
                if (validateAges()) {
                    // Small delay to avoid too many requests
                    clearTimeout(window.retirementCalcTimeout);
                    window.retirementCalcTimeout = setTimeout(calculateRetirement, 500);
                }
            });

            // Initialize the currency converter
            fetchCurrencies();
        });
    </script>
@endpush
