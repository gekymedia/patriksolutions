@extends('layouts.app')
@section('title', 'PS Budget Calculator')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
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

        .form-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            /* Allow the form to grow */
            position: relative;
        }

        .results-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: sticky;
            top: 20px;
            /* Space from the top when scrolling */
            height: calc(100vh - 40px);
            /* Full height minus margins */
            overflow-y: auto;
            /* Allow scrolling */
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

        /* Hide Sidebar on Small Screens */
        @media only screen and (max-width: 600px) {
            .results-section {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Nav Start -->
    <nav class="navbar navbar-expand bg-body-tertiary">
        <div class="container-fluid d-flex justify-content-between">
            <a href="{{ route('index') }}">
                <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Logo" class="logo-spacing"
                    style="width: 50px; height: auto;">
            </a>
            <div id="navbarScroll" class="d-flex flex-grow-1 justify-content-center justify-content-lg-between">
                <div class="d-flex flex-row align-items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="nav-link me-3">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('investment_calculator.index')"
                        :active="request()->routeIs('investment_calculator.index')" class="nav-link me-3">
                        {{ __('Free Tools') }}
                    </x-nav-link>
                    <x-nav-link :href="route('budget_calculator.list')"
                        :active="request()->routeIs('budget_calculator.list')" class="nav-link me-3">
                        {{ __('My Budgets') }}
                    </x-nav-link>
                    @auth
                        @if (Auth::user()->role == 'admin')
                            <x-nav-link :href="route('blogs.index')" :active="request()->routeIs('blogs.index')"
                                class="nav-link me-3">
                                {{ __('Blogs') }}
                            </x-nav-link>
                            <x-nav-link :href="route('youtube.index')" :active="request()->routeIs('youtube.index')"
                                class="nav-link me-3">
                                {{ __('Youtube') }}
                            </x-nav-link>
                            <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.index')"
                                class="nav-link me-3">
                                {{ __('Contact us') }}
                            </x-nav-link>
                        @endif
                    @endauth
                    <x-nav-link :href="route('course.index')" :active="request()->routeIs('course.index')"
                        class="nav-link me-3">
                        {{ __('Courses') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>
    <!-- End of Nav -->

    <div class="calculator-container">
        <div class="heading">
            <h3>PS Budget Calculator</h3>
        </div>

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
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                   </div>
                   <div class="col-md-6">
<!-- Year Dropdown -->
                    <div class="form-group">
                        <label for="year">Select Year</label>
                        <select name="year" id="year" class="form-control" required>
                            <option value="">Choose a Year</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                   </div>
                   </div>          
                    
                    @csrf
                    <h3><i class="fas fa-piggy-bank"></i>Net Savings: <span id="net-savings"
                            class="text-success">0.00</span></h3>

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
                        document.getElementById('totalincome2').innerText = totalIncome.toFixed(2);
                        document.getElementById('totalexpenses').innerText = totalExpenses.toFixed(2);
                        document.getElementById('totalfood').innerText = totalFood.toFixed(2);
                        document.getElementById('totalpersonal').innerText = totalPersonal.toFixed(2);
                        document.getElementById('totallifestyle').innerText = totalLifestyle.toFixed(2);

                        // Calculate and update net savings
                        const netSavings = totalIncome - (totalExpenses + totalFood + totalPersonal + totalLifestyle);

                        document.getElementById('net-savings').innerText = netSavings.toFixed(2);
                        document.getElementById('net-savings2').innerText = netSavings.toFixed(2);
                        netSavingsElement = document.getElementById('net-savings');
                        netSavingsElement2 = document.getElementById('net-savings2');
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

                    document.getElementById('add-income').addEventListener('click', () => {
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
                    });

                    document.getElementById('add-expense').addEventListener('click', () => {
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
                    });

                    document.getElementById('add-food').addEventListener('click', () => {
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
                    });

                    document.getElementById('add-personal').addEventListener('click', () => {
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
                    });

                    document.getElementById('add-lifestyle').addEventListener('click', () => {
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
                    });

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
                </script>
            </div>
            <!-- Results Section -->
            <div class="results-section">
                <div id="your-results">
                    <h4> <i class="fas fa-coins"></i> Budget Summary</h4>

                    <div class="form-group">
                        <label for="income"> <i class="fas fa-coins"></i>Total Income</label>
                        <p id="totalincome2" class="form-control">0.00</p>
                    </div>

                    <div class="form-group">
                        <label> <i class="fas fa-hand-holding-usd"></i>Net Savings</label>
                        <p id="net-savings2" class="form-control">0.00</p>
                    </div>
                    <!-- Summary Icon -->
                    <p>Your Income</p>
                    <!-- <h3 id="income">10.00</h3>
                    <p>Your Expenditure</p>
                    <h3 id="expenditure">0.00</h3>
                    If sum income 
                    <h2>$ <span id="netSavings">0.00</span></h2> -->

                    <div class="mt-3">
                        <button id="convert-button" class="btn btn-secondary mt-2">Print</button>
                        <p id="converted-result" class="mt-3"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateTotalExpenditures() {
            const housingTotal = parseFloat(document.getElementById('totalhousing').textContent) || 0;
            const foodTotal = parseFloat(document.getElementById('totalfood').textContent) || 0;
            const personalTotal = parseFloat(document.getElementById('totalpersonal').textContent) || 0;
            const lifestyleTotal = parseFloat(document.getElementById('totallifestyle').textContent) || 0;

            return housingTotal + foodTotal + personalTotal + lifestyleTotal;
        }

        function calculateNetSavings() {
            const income = parseFloat(document.getElementById('income').value) || 0;
            const totalExpenditures = calculateTotalExpenditures();
            const netSavings = income - totalExpenditures;
            alert(income);
            document.getElementById('netSavings').textContent = netSavings.toFixed(2);
        }

        // Add event listeners for all sections
        document.querySelectorAll('.food-amount').forEach(function (input) {
            input.addEventListener('input', function () {
                calculateFoodTotal();

                calculateNetSavings();
            });
        });

        document.querySelectorAll('.personal-amount').forEach(function (input) {
            input.addEventListener('input', function () {
                calculatePersonalTotal();
                calculateNetSavings();
            });
        });

        document.querySelectorAll('.lifestyle-amount').forEach(function (input) {
            input.addEventListener('input', function () {
                calculateLifestyleTotal();
                calculateNetSavings();
            });
        });

        // Call calculateNetSavings on income input change
        document.getElementById('income').addEventListener('input', calculateNetSavings);
    </script>
@endsection

@push('scripts')
    <script>
        // Additional scripts if needed
    </script>
@endpush