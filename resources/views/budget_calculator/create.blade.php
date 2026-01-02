@extends('layouts.app')
@section('title', 'Budget Calculator')

@push('styles')
    <!-- DataTables JavaScript & CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Poppins', sans-serif;
        }

        .logo-spacing {
            margin-right: 20px;
        }

        .navbar {
            padding-left: 30px;
            padding-right: 15px;
        }

        .nav-link {
            padding: 0.5rem 1rem;
        }

        @media (min-width: 992px) {
            .navbar .container-fluid {
                justify-content: center;
            }
        }

        .calculator-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .heading h1 {
            font-size: 2.5rem;
            color: #333;
        }

        .heading p {
            font-size: 1.2rem;
            color: #777;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
        }

        .form-section,
        .results-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
        }

        .form-section h4 {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
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
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        #your-results h4 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        #your-results h3 {
            color: #28a745;
            font-size: 2.5rem;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
        }

        .show {
            display: inherit;
        }
    </style>
@endpush

@section('content')
    <!-- Nav Start -->
    <!-- End of Nav -->

    <div class="calculator-container">
        <div class="heading">
            <h3>Budget Calculator</h3>
            {{-- <p>Owning a time machine isn’t the only way to predict what your investments could be worth in the
                future.
                Our investment calculator can give you an idea of your earning potential. Plug in your numbers to get
                started.</p> --}}
        </div>

        <div class="flex-container">
            <!-- Form Section -->
            <div class="form-section">

                <!-- <h4 class="mb-4 btn-secondary"> Income for the Month</h4> -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-warning">
                        List all your incomes</h2>
                    <div class="container">
                        <div id="incomes">
                            <div class="income row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="incomes[0][label]">Income for </label>
                                        <input type="text" name="incomes[0][label]" id="incomes[0][label]"
                                            value="Paycheck" class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="incomes[0][planned]">Planned</label>
                                        <input type="number" name="incomes[0][planned]" id="incomes[0][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="incomes[0][recieved]">Remaining</label>
                                        <input type="number" name="incomes[0][recieved]" id="incomes[0][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-income" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Income</button>
                    </div>
                    <div class="text-warning" class="btn btn-warning">Givings (eg. Church, Charity) <span id="giving-arrow">&#9660;</span>
                    </div>
                    <div class="container">
                        <div id="givings">
                            <div class="dropdown-content" id="myDropdown">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="givings[0][label]">Church </label>
                                        <input type="text" name="givings[0][label]" id="givings[0][label]"
                                            value="Paycheck 1" class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="givings[0][planned]">Planned</label>
                                        <input type="number" name="givings[0][planned]" id="givings[0][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="givings[0][recieved]">Remaining</label>
                                        <input type="number" name="givings[0][recieved]" id="givings[0][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-giving" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Giving</button>
                       
                    </div>
                    <div class="text-warning" class="btn btn-warning">Savings (eg. Emergency Fund) <span id="giving-arrow">&#9660;</span>
                    </div>
                    <div class="container">
                        <div id="savings">
                            <div class="dropdown-content" id="myDropdown">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="savings[0][label]">Church </label>
                                        <input type="text" name="savings[0][label]" id="savings[0][label]"
                                            value="Paycheck 1" class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="savings[0][planned]">Planned</label>
                                        <input type="number" name="savings[0][planned]" id="savings[0][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="savings[0][recieved]">Remaining</label>
                                        <input type="number" name="savings[0][recieved]" id="savings[0][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-saving" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Saving</button>
                       
                    </div>
                    <div class="text-warning" class="btn btn-warning">Housing (eg. Mortgage/Rent, Water, Natural Gas, Electricity, Cable, Trash etc) <span id="giving-arrow">&#9660;</span>
                    </div>
                    <div class="container">
                        <div id="housing">
                            <div class="dropdown-content" id="myDropdown">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="housings[0][label]">Church </label>
                                        <input type="text" name="housings[0][label]" id="housings[0][label]"
                                            value="Paycheck 1" class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="housings[0][planned]">Planned</label>
                                        <input type="number" name="housings[0][planned]" id="housings[0][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="housings[0][recieved]">Remaining</label>
                                        <input type="number" name="housings[0][recieved]" id="housings[0][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-housing" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Housing</button>
                        <button type="submit" id="calculateButton" class="btn btn-success"><i class="fa fa-check"></i>
                            Calculate</button>
                    </div>
                </form>

                <!-- <div id="custom-alert" class="custom-alert d-none">
    <div class="custom-alert-content">
        <p id="custom-alert-message"></p>
        <button id="close-alert" class="btn btn-danger"><i class="fa fa-times"></i> Close</button>
    </div>
</div> -->

                <style>
                    .custom-alert {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0, 0, 0, 0.5);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 1000;
                    }

                    .custom-alert-content {
                        background: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        text-align: center;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var now = new Date();
                        var year = now.getFullYear();
                        var month = ('0' + (now.getMonth() + 1)).slice(-2);
                        var day = ('0' + now.getDate()).slice(-2);
                        var hours = ('0' + now.getHours()).slice(-2);
                        var minutes = ('0' + now.getMinutes()).slice(-2);

                        var formattedDate = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes;
                        document.getElementById('timestamp').value = formattedDate;
                    });

                    document.getElementById('add-income').addEventListener('click', function () {
                        var productCount = document.getElementsByClassName('income').length;
                        var newProduct = document.createElement('div');
                        newProduct.classList.add('income', 'row', 'mb-3');
                        newProduct.innerHTML = `

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="incomes[${productCount}][label]">Income for </label>
                                        <input autofocus type="text" name="incomes[${productCount}][label]" id="incomes[0][label]" value="Label"
                                            class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="incomes[${productCount}][planned]">Planned</label>
                                        <input type="number" name="incomes[${productCount}][planned]" id="incomes[${productCount}][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="incomes[${productCount}][recieved]">Remaining</label>
                                        <input type="number" name="incomes[${productCount}][recieved]" id="incomes[${productCount}][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>        
        `;
                        document.getElementById('incomes').appendChild(newProduct);
                    });

                    document.getElementById('giving-arrow').addEventListener('click', function () {
                        document.getElementById("myDropdown").classList.toggle("show");
                    });
                    window.addEventListener("DOMContentLoaded", (event) => {
                        function myFunction() {
                            document.getElementById("myDropdown").classList.toggle("show");

                        }
                    });
                    document.getElementById('add-giving').addEventListener('click', function () {
                        var productCount = document.getElementsByClassName('giving').length;
                        var newProduct = document.createElement('div');
                        newProduct.classList.add('giving', 'row', 'mb-3');
                        newProduct.innerHTML = `

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="givings[${productCount}][label]">Income for </label>
                                        <input autofocus type="text" auto name="givings[${productCount}][label]" id="givings[${productCount}][label]" value="Label"
                                            class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="givings[${productCount}][planned]">Planned</label>
                                        <input type="number" name="givings[${productCount}][planned]" id="givings[${productCount}][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="givings[${productCount}][recieved]">Remaining</label>
                                        <input type="number" name="givings[${productCount}][recieved]" id="givings[${productCount}][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>        
        `;
                        document.getElementById('givings').appendChild(newProduct);


                    });
                    document.getElementById('add-saving').addEventListener('click', function () {
                        var productCount = document.getElementsByClassName('saving').length;
                        var newProduct = document.createElement('div');
                        newProduct.classList.add('saving', 'row', 'mb-3');
                        newProduct.innerHTML = `

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="savings[${productCount}][label]">Income for </label>
                                        <input autofocus type="text" auto name="savings[${productCount}][label]" id="savings[${productCount}][label]" value="Label"
                                            class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="savings[${productCount}][planned]">Planned</label>
                                        <input type="number" name="savings[${productCount}][planned]" id="savings[${productCount}][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="savings[${productCount}][recieved]">Remaining</label>
                                        <input type="number" name="savings[${productCount}][recieved]" id="savings[${productCount}][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>        
        `;
                        document.getElementById('savings').appendChild(newProduct);
                    });
                    document.getElementById('add-housing').addEventListener('click', function () {
                        var productCount = document.getElementsByClassName('housing').length;
                        var newProduct = document.createElement('div');
                        newProduct.classList.add('housing', 'row', 'mb-3');
                        newProduct.innerHTML = `

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="housings[${productCount}][label]">Income for </label>
                                        <input autofocus type="text" auto name="housings[${productCount}][label]" id="housings[${productCount}][label]" value="Label"
                                            class="form-control product-select">
                                        </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="housings[${productCount}][planned]">Planned</label>
                                        <input type="number" name="housings[${productCount}][planned]" id="housings[${productCount}][planned]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="housings[${productCount}][recieved]">Remaining</label>
                                        <input type="number" name="housings[${productCount}][recieved]" id="housings[${productCount}][recieved]"
                                            class="form-control" value="0.00">
                                        <span class="error-message text-danger d-none">Quantity exceeds stock</span>
                                    </div>
                                </div>        
        `;
                        document.getElementById('housing').appendChild(newProduct);
                    });

                    document.getElementById('sale-form').addEventListener('submit', function (event) {
                        let valid = true;
                        document.querySelectorAll('.product').forEach(function (productDiv) {
                            const select = productDiv.querySelector('.product-select');
                            const quantityInput = productDiv.querySelector('input[type="number"]');
                            const errorMessage = productDiv.querySelector('.error-message');
                            const selectedOption = select.options[select.selectedIndex];
                            const availableQuantity = parseInt(selectedOption.getAttribute('data-quantity'));
                            const requestedQuantity = parseInt(quantityInput.value);

                            if (requestedQuantity > availableQuantity) {
                                valid = false;
                                errorMessage.classList.remove('d-none');
                            } else {
                                errorMessage.classList.add('d-none');
                            }
                        });

                        if (!valid) {
                            event.preventDefault();
                            showCustomAlert('Please fix the errors in the form.');
                        }
                    });

                    function showCustomAlert(message) {
                        document.getElementById('custom-alert-message').textContent = message;
                        document.getElementById('custom-alert').classList.remove('d-none');
                    }

                    document.getElementById('close-alert').addEventListener('click', function () {
                        document.getElementById('custom-alert').classList.add('d-none');
                    });
                </script>


            </div>

            <!-- Results Section -->
            <div class="results-section">
                <div id="your-results">
                    <h4>Here is your Budget Sumary</h4>
                    <p>Spend within your income</p>
                    <p>Your Income</p><h3 id="result">${{$incomeplanned}}</h3>
                    <p>You've spent</p><h3 id="result">${{$incomerecieved - ($incomerecieved + $givingsrecieved)}}</h3>

                    <div class="py-12 col-md-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                                <div class="table-responsive" style="">
                    <div class="data-table-area">
                        <div class="data-table-list">
                            <table id="data-table-basic" class="table table-striped">                
                        <thead>
                        <tr class="text-success">
                            <th class="text-warning">No.</th>
                            <th class="text-success">Results</th>
                            <th class="text-warning">Planned</th>
                            <th class="text-success">Remaining</th>
                            
                        </tr>    
                        </thead>
                        <tbody>
                        <tr>
                            <td>Incomes</td>
                            <td>{{$incomeplanned}}</td>
                            <td>{{$incomerecieved}}</td>
                            <td>{{$incomerecieved-$incomeplanned}}</td>
                        </tr>
                        <tr>
                            <td>Givings</td>
                            <td>{{$givingsplanned}}</td>
                            <td>{{$givingsrecieved}}</td>
                            <td>{{$givingsrecieved-$givingsplanned}}</td>
                        </tr>
                        <tr>
                            <td>Savings</td>
                            <td>{{$savingsplanned}}</td>
                            <td>{{$savingsrecieved}}</td>
                            <td>{{$savingsrecieved-$savingsplanned}}</td>
                        </tr>
                        <tr>
                            <td>Housing</td>
                            <td>{{$housingsplanned}}</td>
                            <td>{{$housingsrecieved}}</td>
                            <td>{{$housingsrecieved-$housingsplanned}}</td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
                    </div>
                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="convert-button" class="btn btn-secondary mt-2">Print</button>
                        <p id="converted-result" class="mt-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
</script>
<script>
        $(document).ready(function () {
            $('#data-table-basic').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('budget_calculator.index') }}',
                columns: [
                    { data: 'label', name: 'label' },
                    { data: 'planned', name: 'planned' },
                    { data: 'recieved', name: 'recieved' },

                ],
                responsive: true
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentAgeInput = document.getElementById('current_age');
            const retirementAgeInput = document.getElementById('retirement_age');
            const currentAgeError = document.getElementById('currentAgeError');
            const retirementAgeError = document.getElementById('retirementAgeError');
            const yearsDisplay = document.getElementById('years-display');
            const calculateButton = document.getElementById('calculateButton');
            const budgetForm = document.getElementById('budgetForm');
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
                    success: function (data) {
                        exchangeRates = data.rates;
                        populateCurrencySelect();
                    },
                    error: function () {
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
            currencySearch.addEventListener('input', function () {
                const searchQuery = currencySearch.value.toLowerCase();
                const options = currencySelect.options;
                for (let i = 0; i < options.length; i++) {
                    const optionText = options[i].textContent.toLowerCase();
                    options[i].style.display = optionText.includes(searchQuery) ? '' : 'none';
                }
            });

            // Handle the conversion
            convertButton.addEventListener('click', function () {
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

                if (retirementAge < 67) {
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

            currentAgeInput.addEventListener('input', function () {
                validateAges();
                calculateYears();
            });

            retirementAgeInput.addEventListener('input', function () {
                validateAges();
                calculateYears();
            });

            calculateButton.addEventListener('click', function () {
                event.preventDefault();
                if ($('#budgetForm')[0].checkValidity()) {
                    event.preventDefault();

                    $.ajax({
                        url: budgetForm.action,
                        method: budgetForm.method,
                        data: $(budgetForm).serialize(),
                        success: function (response) {
                            alert('It worked');
                            const futureValue = response.future_value;
                            resultElement.textContent =
                                ;
                        },
                        error: function () {
                            alert('An error occurred while calculating the investment.');
                        }
                    });
                } else {
                    $('#budgetForm')[0].reportValidity();
                }
            });

            // Initialize the currency converter
            fetchCurrencies();


            //BUDGETING
            income1 = $('');
            const income = parseInt(income1.value);
            const retirementAge = parseInt(retirementAgeInput.value);
            const years = retirementAge - currentAge;
            let incomes = 
            .addEventListener('input', function () {
                checkIncomes();
                checkRemainings();
            });
        });
    </script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
@endpush
@endsection