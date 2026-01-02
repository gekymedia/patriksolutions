@extends('layouts.app')

@section('title', 'Budget Calculator')
@section('page-title', 'Budget Calculator')
@section('page-description', 'Track your income and expenses with our comprehensive budget calculator')

@push('styles')
    <!-- Calculator Common CSS -->
    <link href="{{ asset('css/calculator-common.css') }}" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    
    <style>
        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
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
        }

        .form-section {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            padding: 2.5rem;
            flex: 1;
            position: relative;
        }

        .results-section {
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            padding: 2.5rem;
            position: sticky;
            top: 20px;
            height: fit-content;
            color: white;
            width: 380px;
            min-width: 320px;
        }
        
        @media (max-width: 992px) {
            .results-section {
                width: 100%;
                position: relative;
                top: 0;
                margin-top: 20px;
            }
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
        }
        
        .summary-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .summary-card label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
        }
        
        .summary-card .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            color: #333;
            font-weight: 600;
            font-size: 1.25rem;
            text-align: center;
            padding: 12px;
        }
        
        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-top: 8px;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
        }

        .show {
            display: inherit;
        }

        /* Hide Sidebar on Small Screens */
        @media only screen and (max-width: 600px) {
            .results-section {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
<div class="calculator-wrapper">
        <div class="form-wrapper">
            <div class="form-container">
                <h2><i class="fas fa-edit me-2"></i>Enter Your Budget Details</h2>

        <div class="flex-container">
            <!-- Form Section -->
            <div class="form-section">
                <form action="{{ route('budget_calculator.store') }}" method="POST" id="budgetForm">
                   <div class="row">
                    <div class="col-md-6">
                    <!-- Month Dropdown -->
                    <div class="form-group">
                        <label for="month">Select Month</label>
                        <select name="month" id="month" class="form-control" required>
                            <option value="">Choose a Month</option>
                            @php
                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                $currentMonth = date('n'); // 1-12
                                $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
                                $nextMonthName = $months[$nextMonth - 1];
                            @endphp
                            @foreach($months as $month)
                                <option value="{{ $month }}" {{ $month === $nextMonthName ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                   </div>
                   <div class="col-md-6">
<!-- Year Dropdown -->
                    <div class="form-group">
                        <label for="year">Select Year</label>
                        <select name="year" id="year" class="form-control" required>
                            <option value="">Choose a Year</option>
                            @php
                                $currentYear = date('Y');
                            @endphp
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                   </div>
                   </div>          
                    
                    @csrf
                    <div class="alert alert-info mb-4" style="border-left: 4px solid #667eea; background: linear-gradient(135deg, #f0f4ff 0%, #e8eef8 100%);">
                        <h5 class="mb-2"><i class="fas fa-piggy-bank"></i> Net Savings: <span id="net-savings" class="fw-bold" style="color: #667eea;">$0.00</span></h5>
                        <small class="text-muted">Income minus all expenses</small>
                    </div>

                    <!-- Income Section -->
                    <h2 class="btn btn-warning">List all your incomes</h2>
                    <div class="container">
                        <div id="incomes">
                            <div class="income row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="incomes[0][label]">Income for </label>
                                        <input type="text" name="incomes[0][label]" id="incomes[0][label]"
                                            value="Paycheck" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="incomes[0][planned]">Amount</label>
                                        <input type="number" name="incomes[0][planned]" id="incomes[0][planned]"
                                            class="form-control income-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-income"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="income row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Income</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totalincome" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-income" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Income</button>
                    </div>

                    <!-- Housing Section -->
                    <h2 class="btn btn-info">HOUSING</h2>
                    <div class="container">
                        <div id="expenses">
                            <div class="expense row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="expenses[0][label]">Expense for </label>
                                        <input type="text" name="expenses[0][label]" id="expenses[0][label]"
                                            value="Mortgage/Rent" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="expenses[0][budgeted]">Budgeted</label>
                                        <input type="number" name="expenses[0][budgeted]" id="expenses[0][budgeted]"
                                            class="form-control expense-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-expense"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>

                            <div class="expense row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="expenses[1][label]">Expense for </label>
                                        <input type="text" name="expenses[1][label]" id="expenses[1][label]"
                                            value="Real Estate Taxes" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="expenses[1][budgeted]">Budgeted</label>
                                        <input type="number" name="expenses[1][budgeted]" id="expenses[1][budgeted]"
                                            class="form-control expense-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-expense"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>

                            <div class="expense row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="expenses[2][label]">Expense for </label>
                                        <input type="text" name="expenses[2][label]" id="expenses[2][label]"
                                            value="Homeowner/Renter Ins." class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="expenses[2][budgeted]">Budgeted</label>
                                        <input type="number" name="expenses[2][budgeted]" id="expenses[2][budgeted]"
                                            class="form-control expense-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-expense"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="expense row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Expenses</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totalexpenses" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-expense" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Expense</button>
                    </div>

                    <!-- Food Section -->
                    <h2 class="btn btn-warning">FOOD</h2>
                    <div class="container">
                        <div id="food">
                            <div class="food row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="food[0][label]">Food for </label>
                                        <input type="text" name="food[0][label]" id="food[0][label]" value="Groceries"
                                            class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="food[0][budgeted]">Budgeted</label>
                                        <input type="number" name="food[0][budgeted]" id="food[0][budgeted]"
                                            class="form-control food-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-food"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                            <div class="food row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="food[1][label]">Food for </label>
                                        <input type="text" name="food[1][label]" id="food[1][label]" value="Restaurant"
                                            class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="food[1][budgeted]">Budgeted</label>
                                        <input type="number" name="food[1][budgeted]" id="food[1][budgeted]"
                                            class="form-control food-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-food"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="food row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Budgeted Food</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totalfood" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-food" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add
                            Food</button>
                    </div>

                    <!-- Personal Section -->
                    <h2 class="btn btn-danger">PERSONAL</h2>
                    <div class="container">
                        <div id="personal">
                            <div class="personal row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="personal[0][label]">Personal for </label>
                                        <input type="text" name="personal[0][label]" id="personal[0][label]"
                                            value="Clothing" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="personal[0][budgeted]">Budgeted</label>
                                        <input type="number" name="personal[0][budgeted]" id="personal[0][budgeted]"
                                            class="form-control personal-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-personal"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>

                            <div class="personal row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="personal[1][label]">Personal for </label>
                                        <input type="text" name="personal[1][label]" id="personal[1][label]"
                                            value="Entertainment" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="personal[1][budgeted]">Budgeted</label>
                                        <input type="number" name="personal[1][budgeted]" id="personal[1][budgeted]"
                                            class="form-control personal-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-personal"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="personal row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Budgeted Personal</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totalpersonal" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-personal" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Personal</button>
                    </div>

                    <!-- Lifestyle Section -->
                    <h2 class="btn btn-success">LIFESTYLE</h2>
                    <div class="container">
                        <div id="lifestyle">
                            <div class="lifestyle row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="lifestyle[0][label]">Lifestyle for </label>
                                        <input type="text" name="lifestyle[0][label]" id="lifestyle[0][label]"
                                            value="Gym Membership" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="lifestyle[0][budgeted]">Budgeted</label>
                                        <input type="number" name="lifestyle[0][budgeted]" id="lifestyle[0][budgeted]"
                                            class="form-control lifestyle-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-lifestyle"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>

                            <div class="lifestyle row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="lifestyle[1][label]">Lifestyle for </label>
                                        <input type="text" name="lifestyle[1][label]" id="lifestyle[1][label]"
                                            value="Hobbies" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="lifestyle[1][budgeted]">Budgeted</label>
                                        <input type="number" name="lifestyle[1][budgeted]" id="lifestyle[1][budgeted]"
                                            class="form-control lifestyle-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-lifestyle"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="lifestyle row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Budgeted Lifestyle</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totallifestyle" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-lifestyle" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Lifestyle</button>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h3>Net Savings: <span id="net-savings" class="text-success">0.00</span></h3>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save your Budget</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Results Section -->
        <div class="results-wrapper">
            <div class="results-section budget-results">
                <h3><i class="fas fa-chart-pie me-2"></i>Budget Summary</h3>
                <div id="your-results">

                    <div class="summary-card">
                        <label><i class="fas fa-arrow-up"></i> Total Income</label>
                        <div class="summary-value" id="totalincome2">$0.00</div>
                    </div>

                    <div class="summary-card">
                        <label><i class="fas fa-home"></i> Total Housing</label>
                        <div class="summary-value" id="totalexpenses-display">$0.00</div>
                    </div>

                    <div class="summary-card">
                        <label><i class="fas fa-utensils"></i> Total Food</label>
                        <div class="summary-value" id="totalfood-display">$0.00</div>
                    </div>

                    <div class="summary-card">
                        <label><i class="fas fa-user"></i> Total Personal</label>
                        <div class="summary-value" id="totalpersonal-display">$0.00</div>
                    </div>

                    <div class="summary-card">
                        <label><i class="fas fa-heart"></i> Total Lifestyle</label>
                        <div class="summary-value" id="totallifestyle-display">$0.00</div>
                    </div>

                    <div class="summary-card" style="background: rgba(255, 255, 255, 0.3); border: 2px solid rgba(255, 255, 255, 0.5);">
                        <label><i class="fas fa-piggy-bank"></i> Net Savings</label>
                        <div class="summary-value" id="net-savings2">$0.00</div>
                    </div>

                    <div class="mt-4">
                        <button id="convert-button" class="btn btn-light w-100" style="padding: 12px; font-weight: 600;">
                            <i class="fas fa-print"></i> Print Summary
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
    
    <script>
        function calculateTotals() {
            let totalIncome = 0;
            let totalExpenses = 0;
            let totalFood = 0;
            let totalPersonal = 0;
            let totalLifestyle = 0;

            // Calculate Total Income
            document.querySelectorAll('.income-amount').forEach(input => {
                totalIncome += parseFloat(input.value) || 0;
            });

            // Calculate Total Expenses
            document.querySelectorAll('.expense-amount').forEach(input => {
                totalExpenses += parseFloat(input.value) || 0;
            });

            // Calculate Total Food
            document.querySelectorAll('.food-amount').forEach(input => {
                totalFood += parseFloat(input.value) || 0;
            });

            // Calculate Total Personal
            document.querySelectorAll('.personal-amount').forEach(input => {
                totalPersonal += parseFloat(input.value) || 0;
            });

            // Calculate Total Lifestyle
            document.querySelectorAll('.lifestyle-amount').forEach(input => {
                totalLifestyle += parseFloat(input.value) || 0;
            });

            // Update total values in the DOM
            document.getElementById('totalincome').innerText = totalIncome.toFixed(2);
            document.getElementById('totalincome2').innerText = '$' + totalIncome.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totalexpenses').innerText = totalExpenses.toFixed(2);
            document.getElementById('totalexpenses-display').innerText = '$' + totalExpenses.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totalfood').innerText = totalFood.toFixed(2);
            document.getElementById('totalfood-display').innerText = '$' + totalFood.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totalpersonal').innerText = totalPersonal.toFixed(2);
            document.getElementById('totalpersonal-display').innerText = '$' + totalPersonal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('totallifestyle').innerText = totalLifestyle.toFixed(2);
            document.getElementById('totallifestyle-display').innerText = '$' + totalLifestyle.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // Calculate and update net savings
            const netSavings = totalIncome - (totalExpenses + totalFood + totalPersonal + totalLifestyle);

            document.getElementById('net-savings').innerText = netSavings.toFixed(2);
            document.getElementById('net-savings2').innerText = '$' + netSavings.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            const netSavingsElement = document.getElementById('net-savings');
            const netSavingsElement2 = document.getElementById('net-savings2');
            // Change text color based on value
            if (netSavings < 0) {
                netSavingsElement.classList.remove('text-success');
                netSavingsElement.classList.add('text-danger');
                netSavingsElement2.classList.remove('text-success');
                netSavingsElement2.classList.add('text-danger');
            } else {
                netSavingsElement.classList.remove('text-danger');
                netSavingsElement.classList.add('text-success');
                netSavingsElement2.classList.remove('text-danger');
                netSavingsElement2.classList.add('text-success');
            }
        }

        document.getElementById('budgetForm').addEventListener('input', calculateTotals);
        
        // Auto-save form data to localStorage on input
        function saveFormDataToLocalStorage() {
            const formData = new FormData(document.getElementById('budgetForm'));
            const data = {};
            
            // Save all form fields
            for (let [key, value] of formData.entries()) {
                if (data[key]) {
                    // Handle arrays
                    if (!Array.isArray(data[key])) {
                        data[key] = [data[key]];
                    }
                    data[key].push(value);
                } else {
                    data[key] = value;
                }
            }
            
            // Also save dynamic fields
            const incomes = [];
            document.querySelectorAll('.income').forEach((income, index) => {
                const label = income.querySelector('input[name*="[label]"]')?.value || '';
                const planned = income.querySelector('input[name*="[planned]"]')?.value || '0.00';
                if (label || planned !== '0.00') {
                    incomes.push({ label, planned });
                }
            });
            if (incomes.length > 0) data.incomes = incomes;
            
            const expenses = [];
            document.querySelectorAll('.expense').forEach((expense, index) => {
                const label = expense.querySelector('input[name*="[label]"]')?.value || '';
                const budgeted = expense.querySelector('input[name*="[budgeted]"]')?.value || '0.00';
                if (label || budgeted !== '0.00') {
                    expenses.push({ label, budgeted });
                }
            });
            if (expenses.length > 0) data.expenses = expenses;
            
            const food = [];
            document.querySelectorAll('.food').forEach((foodItem, index) => {
                const label = foodItem.querySelector('input[name*="[label]"]')?.value || '';
                const budgeted = foodItem.querySelector('input[name*="[budgeted]"]')?.value || '0.00';
                if (label || budgeted !== '0.00') {
                    food.push({ label, budgeted });
                }
            });
            if (food.length > 0) data.food = food;
            
            const personal = [];
            document.querySelectorAll('.personal').forEach((personalItem, index) => {
                const label = personalItem.querySelector('input[name*="[label]"]')?.value || '';
                const budgeted = personalItem.querySelector('input[name*="[budgeted]"]')?.value || '0.00';
                if (label || budgeted !== '0.00') {
                    personal.push({ label, budgeted });
                }
            });
            if (personal.length > 0) data.personal = personal;
            
            const lifestyle = [];
            document.querySelectorAll('.lifestyle').forEach((lifestyleItem, index) => {
                const label = lifestyleItem.querySelector('input[name*="[label]"]')?.value || '';
                const budgeted = lifestyleItem.querySelector('input[name*="[budgeted]"]')?.value || '0.00';
                if (label || budgeted !== '0.00') {
                    lifestyle.push({ label, budgeted });
                }
            });
            if (lifestyle.length > 0) data.lifestyle = lifestyle;
            
            localStorage.setItem('budget_calculator_draft', JSON.stringify(data));
        }
        
        // Restore form data from localStorage
        function restoreFormDataFromLocalStorage() {
            const savedData = localStorage.getItem('budget_calculator_draft');
            if (!savedData) return false;
            
            try {
                const data = JSON.parse(savedData);
                
                // Restore month and year
                if (data.month) document.getElementById('month').value = data.month;
                if (data.year) document.getElementById('year').value = data.year;
                
                // Restore incomes
                if (data.incomes && Array.isArray(data.incomes)) {
                    data.incomes.forEach((income, index) => {
                        if (index === 0) {
                            // Use existing first income field
                            const labelInput = document.querySelector('input[name="incomes[0][label]"]');
                            const plannedInput = document.querySelector('input[name="incomes[0][planned]"]');
                            if (labelInput) labelInput.value = income.label || '';
                            if (plannedInput) plannedInput.value = income.planned || '0.00';
                        } else {
                            // Add new income fields
                            addIncomeField();
                            const labelInput = document.querySelector(`input[name="incomes[${index}][label]"]`);
                            const plannedInput = document.querySelector(`input[name="incomes[${index}][planned]"]`);
                            if (labelInput) labelInput.value = income.label || '';
                            if (plannedInput) plannedInput.value = income.planned || '0.00';
                        }
                    });
                }
                
                // Similar for expenses, food, personal, lifestyle
                if (data.expenses && Array.isArray(data.expenses)) {
                    data.expenses.forEach((expense, index) => {
                        if (index < 3) {
                            // Use existing expense fields
                            const existingExpenses = document.querySelectorAll('.expense');
                            if (existingExpenses[index]) {
                                const labelInput = existingExpenses[index].querySelector('input[name*="[label]"]');
                                const budgetedInput = existingExpenses[index].querySelector('input[name*="[budgeted]"]');
                                if (labelInput) labelInput.value = expense.label || '';
                                if (budgetedInput) budgetedInput.value = expense.budgeted || '0.00';
                            }
                        } else {
                            addExpenseField();
                            const labelInput = document.querySelector(`input[name="expenses[${index}][label]"]`);
                            const budgetedInput = document.querySelector(`input[name="expenses[${index}][budgeted]"]`);
                            if (labelInput) labelInput.value = expense.label || '';
                            if (budgetedInput) budgetedInput.value = expense.budgeted || '0.00';
                        }
                    });
                }
                
                if (data.food && Array.isArray(data.food)) {
                    data.food.forEach((foodItem, index) => {
                        if (index < 2) {
                            const existingFood = document.querySelectorAll('.food');
                            if (existingFood[index]) {
                                const labelInput = existingFood[index].querySelector('input[name*="[label]"]');
                                const budgetedInput = existingFood[index].querySelector('input[name*="[budgeted]"]');
                                if (labelInput) labelInput.value = foodItem.label || '';
                                if (budgetedInput) budgetedInput.value = foodItem.budgeted || '0.00';
                            }
                        } else {
                            addFoodField();
                            const labelInput = document.querySelector(`input[name="food[${index}][label]"]`);
                            const budgetedInput = document.querySelector(`input[name="food[${index}][budgeted]"]`);
                            if (labelInput) labelInput.value = foodItem.label || '';
                            if (budgetedInput) budgetedInput.value = foodItem.budgeted || '0.00';
                        }
                    });
                }
                
                if (data.personal && Array.isArray(data.personal)) {
                    data.personal.forEach((personalItem, index) => {
                        if (index < 2) {
                            const existingPersonal = document.querySelectorAll('.personal');
                            if (existingPersonal[index]) {
                                const labelInput = existingPersonal[index].querySelector('input[name*="[label]"]');
                                const budgetedInput = existingPersonal[index].querySelector('input[name*="[budgeted]"]');
                                if (labelInput) labelInput.value = personalItem.label || '';
                                if (budgetedInput) budgetedInput.value = personalItem.budgeted || '0.00';
                            }
                        } else {
                            addPersonalField();
                            const labelInput = document.querySelector(`input[name="personal[${index}][label]"]`);
                            const budgetedInput = document.querySelector(`input[name="personal[${index}][budgeted]"]`);
                            if (labelInput) labelInput.value = personalItem.label || '';
                            if (budgetedInput) budgetedInput.value = personalItem.budgeted || '0.00';
                        }
                    });
                }
                
                if (data.lifestyle && Array.isArray(data.lifestyle)) {
                    data.lifestyle.forEach((lifestyleItem, index) => {
                        if (index < 2) {
                            const existingLifestyle = document.querySelectorAll('.lifestyle');
                            if (existingLifestyle[index]) {
                                const labelInput = existingLifestyle[index].querySelector('input[name*="[label]"]');
                                const budgetedInput = existingLifestyle[index].querySelector('input[name*="[budgeted]"]');
                                if (labelInput) labelInput.value = lifestyleItem.label || '';
                                if (budgetedInput) budgetedInput.value = lifestyleItem.budgeted || '0.00';
                            }
                        } else {
                            addLifestyleField();
                            const labelInput = document.querySelector(`input[name="lifestyle[${index}][label]"]`);
                            const budgetedInput = document.querySelector(`input[name="lifestyle[${index}][budgeted]"]`);
                            if (labelInput) labelInput.value = lifestyleItem.label || '';
                            if (budgetedInput) budgetedInput.value = lifestyleItem.budgeted || '0.00';
                        }
                    });
                }
                
                calculateTotals();
                
                // Reattach event listeners for newly added fields
                document.querySelectorAll('.income-amount, .expense-amount, .food-amount, .personal-amount, .lifestyle-amount').forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });
                
                return true;
            } catch (e) {
                console.error('Error restoring form data:', e);
                return false;
            }
        }
        
        // Auto-save on input (with debounce to avoid too many saves)
        let saveTimeout;
        document.getElementById('budgetForm').addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveFormDataToLocalStorage();
            }, 500); // Save after 500ms of no input
        });
        
        // Check if we should restore data (after login/register)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('restore_budget') === '1') {
            if (restoreFormDataFromLocalStorage()) {
                // Clear the saved data after restoring
                localStorage.removeItem('budget_calculator_draft');
                // Show success message
                alert('Your budget data has been restored! You can now save it.');
            }
        }
        
        // Intercept form submission if user is not logged in
        document.getElementById('budgetForm').addEventListener('submit', function(e) {
            @guest
            e.preventDefault();
            
            // Save form data before redirecting
            saveFormDataToLocalStorage();
            
            // Show confirmation
            if (confirm('You need to be logged in to save your budget. Would you like to sign in or create an account? Your data will be saved and restored after you log in.')) {
                // Redirect to login with restore flag
                window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname + '?restore_budget=1');
            }
            return false;
            @else
            // User is logged in, allow normal form submission
            // But still save to localStorage as backup
            saveFormDataToLocalStorage();
            @endguest
        });

        // Function to add income field (reusable)
        function addIncomeField() {
            const index = document.querySelectorAll('.income').length;
            const incomeRow = `
            <div class="income row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="incomes[${index}][label]">Income for </label>
                        <input type="text" name="incomes[${index}][label]" id="incomes[${index}][label]" class="form-control product-select">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group flex-grow-1">
                        <label for="incomes[${index}][planned]">Amount</label>
                        <input type="number" name="incomes[${index}][planned]" id="incomes[${index}][planned]" class="form-control income-amount" value="0.00">
                    </div>
                    <i class="fas fa-times-circle text-danger delete-income" style="cursor: pointer; margin-left: 10px;"></i>
                </div>
            </div>`;
            document.getElementById('incomes').insertAdjacentHTML('beforeend', incomeRow);
        }
        
        document.getElementById('add-income').addEventListener('click', addIncomeField);

        // Function to add expense field (reusable)
        function addExpenseField() {
            const index = document.querySelectorAll('.expense').length;
            const expenseRow = `
            <div class="expense row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="expenses[${index}][label]">Expense for </label>
                        <input type="text" name="expenses[${index}][label]" id="expenses[${index}][label]" class="form-control product-select">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group flex-grow-1">
                        <label for="expenses[${index}][budgeted]">Budgeted</label>
                        <input type="number" name="expenses[${index}][budgeted]" id="expenses[${index}][budgeted]" class="form-control expense-amount" value="0.00">
                    </div>
                    <i class="fas fa-times-circle text-danger delete-expense" style="cursor: pointer; margin-left: 10px;"></i>
                </div>
            </div>`;
            document.getElementById('expenses').insertAdjacentHTML('beforeend', expenseRow);
        }
        
        document.getElementById('add-expense').addEventListener('click', addExpenseField);

        // Function to add food field (reusable)
        function addFoodField() {
            const index = document.querySelectorAll('.food').length;
            const foodRow = `
            <div class="food row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="food[${index}][label]">Food for </label>
                        <input type="text" name="food[${index}][label]" id="food[${index}][label]" class="form-control product-select">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group flex-grow-1">
                        <label for="food[${index}][budgeted]">Budgeted</label>
                        <input type="number" name="food[${index}][budgeted]" id="food[${index}][budgeted]" class="form-control food-amount" value="0.00">
                    </div>
                    <i class="fas fa-times-circle text-danger delete-food" style="cursor: pointer; margin-left: 10px;"></i>
                </div>
            </div>`;
            document.getElementById('food').insertAdjacentHTML('beforeend', foodRow);
        }
        
        document.getElementById('add-food').addEventListener('click', addFoodField);

        // Function to add personal field (reusable)
        function addPersonalField() {
            const index = document.querySelectorAll('.personal').length;
            const personalRow = `
            <div class="personal row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="personal[${index}][label]">Personal for </label>
                        <input type="text" name="personal[${index}][label]" id="personal[${index}][label]" class="form-control product-select">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group flex-grow-1">
                        <label for="personal[${index}][budgeted]">Budgeted</label>
                        <input type="number" name="personal[${index}][budgeted]" id="personal[${index}][budgeted]" class="form-control personal-amount" value="0.00">
                    </div>
                    <i class="fas fa-times-circle text-danger delete-personal" style="cursor: pointer; margin-left: 10px;"></i>
                </div>
            </div>`;
            document.getElementById('personal').insertAdjacentHTML('beforeend', personalRow);
        }
        
        document.getElementById('add-personal').addEventListener('click', addPersonalField);

        // Function to add lifestyle field (reusable)
        function addLifestyleField() {
            const index = document.querySelectorAll('.lifestyle').length;
            const lifestyleRow = `
            <div class="lifestyle row mb-3">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="lifestyle[${index}][label]">Lifestyle for </label>
                        <input type="text" name="lifestyle[${index}][label]" id="lifestyle[${index}][label]" class="form-control product-select">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-group flex-grow-1">
                        <label for="lifestyle[${index}][budgeted]">Budgeted</label>
                        <input type="number" name="lifestyle[${index}][budgeted]" id="lifestyle[${index}][budgeted]" class="form-control lifestyle-amount" value="0.00">
                    </div>
                    <i class="fas fa-times-circle text-danger delete-lifestyle" style="cursor: pointer; margin-left: 10px;"></i>
                </div>
            </div>`;
            document.getElementById('lifestyle').insertAdjacentHTML('beforeend', lifestyleRow);
        }
        
        document.getElementById('add-lifestyle').addEventListener('click', addLifestyleField);

        document.getElementById('incomes').addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-income')) {
                event.target.closest('.income').remove();
                calculateTotals();
            }
        });

        document.getElementById('expenses').addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-expense')) {
                event.target.closest('.expense').remove();
                calculateTotals();
            }
        });

        document.getElementById('food').addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-food')) {
                event.target.closest('.food').remove();
                calculateTotals();
            }
        });

        document.getElementById('personal').addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-personal')) {
                event.target.closest('.personal').remove();
                calculateTotals();
            }
        });

        document.getElementById('lifestyle').addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-lifestyle')) {
                event.target.closest('.lifestyle').remove();
                calculateTotals();
            }
        });

        function myFunction() {
            const dropdown = document.getElementById("myDropdown");
            if (dropdown) {
                dropdown.classList.toggle("show");
            }
        }
    </script>
@endpush