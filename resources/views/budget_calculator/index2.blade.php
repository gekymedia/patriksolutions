@extends('layouts.app')
@section('title', 'Budget Calculator')

@push('styles')
    <!-- DataTables CSS -->
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
    </style>
@endpush

@section('content')
    <!-- Nav Start -->
    <!-- End of Nav -->

    <div class="calculator-container">
        <div class="heading">
            <h3>Budget Calculator</h3>
        </div>

        <div class="flex-container">
            <!-- Form Section -->
            <div class="form-section">
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
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
                </form>

                <script>
                    let incomeIndex = 1;

                    // Function to calculate the total income
                    function calculateTotal() {
                        let total = 0;
                        const incomeFields = document.querySelectorAll('.income-amount');
                        incomeFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the planned incomes
                        });
                        document.getElementById('totalincome').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing input field for changes
                    document.querySelectorAll('.income-amount').forEach(function (input) {
                        input.addEventListener('input', calculateTotal);
                    });

                    // Event listener for adding new income
                    document.getElementById('add-income').addEventListener('click', function () {
                        const productCount = document.getElementsByClassName('income').length;
                        const newProduct = document.createElement('div');
                        newProduct.classList.add('income', 'row', 'mb-3');
                        newProduct.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="incomes[${productCount}][label]">Income for </label>
                    <input autofocus type="text" name="incomes[${productCount}][label]" id="incomes[${productCount}][label]" value="New Income" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="incomes[${productCount}][planned]">Amount</label>
                    <input type="number" name="incomes[${productCount}][planned]" id="incomes[${productCount}][planned]" class="form-control income-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-income" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('incomes').appendChild(newProduct);

                        // Attach event listener to the new input field for changes
                        newProduct.querySelector('.income-amount').addEventListener('input', calculateTotal);

                        // Recalculate the total in case default value changes
                        calculateTotal();
                    });

                    // Initial calculation on page load
                    calculateTotal();
                </script>

                <!-- Housing Section -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-info">HOUSING</h2>
                    <div class="container">
                        <div id="expenses">
                            <!-- Default Expense 1: Mortgage/Rent -->
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

                            <!-- Default Expense 2: Real Estate Taxes -->
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

                            <!-- Default Expense 3: Homeowner/Renter Ins. -->
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

                        <!-- Total Budgeted Expenses -->
                        <div class="expense row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Budgeted Expenses</label>
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
                </form>

                <script>
                    let expenseIndex = 3; // Start from 3 because the first 3 default expenses are already added

                    // Function to calculate the total expenses
                    function calculateExpenseTotal() {
                        let total = 0;
                        const expenseFields = document.querySelectorAll('.expense-amount');
                        expenseFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the budgeted expenses
                        });
                        document.getElementById('totalexpenses').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing expense input fields for changes
                    document.querySelectorAll('.expense-amount').forEach(function (input) {
                        input.addEventListener('input', calculateExpenseTotal);
                    });

                    // Event listener for adding new expense rows
                    document.getElementById('add-expense').addEventListener('click', function () {
                        const expenseCount = document.getElementsByClassName('expense').length;
                        const newExpense = document.createElement('div');
                        newExpense.classList.add('expense', 'row', 'mb-3');
                        newExpense.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="expenses[${expenseCount}][label]">Expense for </label>
                    <input autofocus type="text" name="expenses[${expenseCount}][label]" id="expenses[${expenseCount}][label]" value="New Expense" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="expenses[${expenseCount}][budgeted]">Budgeted</label>
                    <input type="number" name="expenses[${expenseCount}][budgeted]" id="expenses[${expenseCount}][budgeted]" class="form-control expense-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-expense" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('expenses').appendChild(newExpense);

                        // Attach event listener to the new input field for changes
                        newExpense.querySelector('.expense-amount').addEventListener('input', calculateExpenseTotal);

                        // Recalculate the total in case default value changes
                        calculateExpenseTotal();
                    });

                    // Function to remove expense rows
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('delete-expense')) {
                            e.target.closest('.expense').remove();
                            calculateExpenseTotal();
                        }
                    });

                    // Initial calculation on page load
                    calculateExpenseTotal();
                </script>
                <!-- Savings Section -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-success">SAVINGS</h2>
                    <div class="container">
                        <div id="savings">
                            <!-- Default Savings: Emergency Fund -->
                            <div class="savings row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="savings[0][label]">Savings for </label>
                                        <input type="text" name="savings[0][label]" id="savings[0][label]"
                                            value="Emergency Fund" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="savings[0][budgeted]">Budgeted</label>
                                        <input type="number" name="savings[0][budgeted]" id="savings[0][budgeted]"
                                            class="form-control savings-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-savings"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Savings -->
                        <div class="savings row mb-3">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Total Budgeted Savings</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p id="totalsavings" class="form-control">0.00</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-savings" class="btn btn-primary mb-3"><i class="fa fa-plus"></i>
                            Add Savings</button>
                    </div>
                </form>

                <script>
                    let savingsIndex = 1; // Start from 1 for savings

                    // Function to calculate the total savings
                    function calculateSavingsTotal() {
                        let total = 0;
                        const savingsFields = document.querySelectorAll('.savings-amount');
                        savingsFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the budgeted savings
                        });
                        document.getElementById('totalsavings').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing savings input fields for changes
                    document.querySelectorAll('.savings-amount').forEach(function (input) {
                        input.addEventListener('input', calculateSavingsTotal);
                    });

                    // Event listener for adding new savings rows
                    document.getElementById('add-savings').addEventListener('click', function () {
                        const savingsCount = document.getElementsByClassName('savings').length;
                        const newSavings = document.createElement('div');
                        newSavings.classList.add('savings', 'row', 'mb-3');
                        newSavings.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="savings[${savingsCount}][label]">Savings for </label>
                    <input autofocus type="text" name="savings[${savingsCount}][label]" id="savings[${savingsCount}][label]" value="New Savings" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="savings[${savingsCount}][budgeted]">Budgeted</label>
                    <input type="number" name="savings[${savingsCount}][budgeted]" id="savings[${savingsCount}][budgeted]" class="form-control savings-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-savings" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('savings').appendChild(newSavings);

                        // Attach event listener to the new input field for changes
                        newSavings.querySelector('.savings-amount').addEventListener('input', calculateSavingsTotal);

                        // Recalculate the total in case default value changes
                        calculateSavingsTotal();
                    });

                    // Function to remove savings rows
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('delete-savings')) {
                            e.target.closest('.savings').remove();
                            calculateSavingsTotal();
                        }
                    });

                    // Initial calculation on page load
                    calculateSavingsTotal();
                </script>

                <!-- Food Section -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-warning">FOOD</h2>
                    <div class="container">
                        <div id="food">
                            <!-- Default Food: Groceries -->
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
                            <!-- Default Food: Restaurant -->
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

                        <!-- Total Food -->
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
                </form>

                <script>
                    let foodIndex = 2; // Start from 2 for food since we have 2 default items

                    // Function to calculate the total food
                    function calculateFoodTotal() {
                        let total = 0;
                        const foodFields = document.querySelectorAll('.food-amount');
                        foodFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the budgeted food
                        });
                        document.getElementById('totalfood').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing food input fields for changes
                    document.querySelectorAll('.food-amount').forEach(function (input) {
                        input.addEventListener('input', calculateFoodTotal);
                    });

                    // Event listener for adding new food rows
                    document.getElementById('add-food').addEventListener('click', function () {
                        const foodCount = document.getElementsByClassName('food').length;
                        const newFood = document.createElement('div');
                        newFood.classList.add('food', 'row', 'mb-3');
                        newFood.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="food[${foodCount}][label]">Food for </label>
                    <input autofocus type="text" name="food[${foodCount}][label]" id="food[${foodCount}][label]" value="New Food" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="food[${foodCount}][budgeted]">Budgeted</label>
                    <input type="number" name="food[${foodCount}][budgeted]" id="food[${foodCount}][budgeted]" class="form-control food-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-food" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('food').appendChild(newFood);

                        // Attach event listener to the new input field for changes
                        newFood.querySelector('.food-amount').addEventListener('input', calculateFoodTotal);

                        // Recalculate the total in case default value changes
                        calculateFoodTotal();
                    });

                    // Function to remove food rows
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('delete-food')) {
                            e.target.closest('.food').remove();
                            calculateFoodTotal();
                        }
                    });

                    // Initial calculation on page load
                    calculateFoodTotal();
                </script>

                <!-- Personal Section -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-danger">PERSONAL</h2>
                    <div class="container">
                        <div id="personal">
                            <!-- Default Personal: Clothing -->
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
                            <!-- Default Personal: Phone -->
                            <div class="personal row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="personal[1][label]">Personal for </label>
                                        <input type="text" name="personal[1][label]" id="personal[1][label]"
                                            value="Phone" class="form-control product-select">
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
                            <!-- Default Personal: Subscriptions -->
                            <div class="personal row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="personal[2][label]">Personal for </label>
                                        <input type="text" name="personal[2][label]" id="personal[2][label]"
                                            value="Subscriptions" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="personal[2][budgeted]">Budgeted</label>
                                        <input type="number" name="personal[2][budgeted]" id="personal[2][budgeted]"
                                            class="form-control personal-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-personal"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Personal -->
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
                </form>

                <script>
                    let personalIndex = 3; // Start from 3 for personal since we have 3 default items

                    // Function to calculate the total personal
                    function calculatePersonalTotal() {
                        let total = 0;
                        const personalFields = document.querySelectorAll('.personal-amount');
                        personalFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the budgeted personal
                        });
                        document.getElementById('totalpersonal').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing personal input fields for changes
                    document.querySelectorAll('.personal-amount').forEach(function (input) {
                        input.addEventListener('input', calculatePersonalTotal);
                    });

                    // Event listener for adding new personal rows
                    document.getElementById('add-personal').addEventListener('click', function () {
                        const personalCount = document.getElementsByClassName('personal').length;
                        const newPersonal = document.createElement('div');
                        newPersonal.classList.add('personal', 'row', 'mb-3');
                        newPersonal.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="personal[${personalCount}][label]">Personal for </label>
                    <input autofocus type="text" name="personal[${personalCount}][label]" id="personal[${personalCount}][label]" value="New Personal" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="personal[${personalCount}][budgeted]">Budgeted</label>
                    <input type="number" name="personal[${personalCount}][budgeted]" id="personal[${personalCount}][budgeted]" class="form-control personal-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-personal" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('personal').appendChild(newPersonal);

                        // Attach event listener to the new input field for changes
                        newPersonal.querySelector('.personal-amount').addEventListener('input', calculatePersonalTotal);

                        // Recalculate the total in case default value changes
                        calculatePersonalTotal();
                    });

                    // Function to remove personal rows
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('delete-personal')) {
                            e.target.closest('.personal').remove();
                            calculatePersonalTotal();
                        }
                    });

                    // Initial calculation on page load
                    calculatePersonalTotal();
                </script>

                <!-- Lifestyle Section -->
                <form action="{{ route('budget_calculator.calculate') }}" method="POST" id="budgetForm">
                    @csrf
                    <h2 class="btn btn-info">LIFESTYLE</h2>
                    <div class="container">
                        <div id="lifestyle">
                            <!-- Default Lifestyle: Child Care -->
                            <div class="lifestyle row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="lifestyle[0][label]">Lifestyle for </label>
                                        <input type="text" name="lifestyle[0][label]" id="lifestyle[0][label]"
                                            value="Child Care" class="form-control product-select">
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
                            <!-- Default Lifestyle: Entertainment -->
                            <div class="lifestyle row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="lifestyle[1][label]">Lifestyle for </label>
                                        <input type="text" name="lifestyle[1][label]" id="lifestyle[1][label]"
                                            value="Entertainment" class="form-control product-select">
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
                            <!-- Default Lifestyle: Miscellaneous -->
                            <div class="lifestyle row mb-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="lifestyle[2][label]">Lifestyle for </label>
                                        <input type="text" name="lifestyle[2][label]" id="lifestyle[2][label]"
                                            value="Miscellaneous" class="form-control product-select">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="form-group flex-grow-1">
                                        <label for="lifestyle[2][budgeted]">Budgeted</label>
                                        <input type="number" name="lifestyle[2][budgeted]" id="lifestyle[2][budgeted]"
                                            class="form-control lifestyle-amount" value="0.00">
                                    </div>
                                    <i class="fas fa-times-circle text-danger delete-lifestyle"
                                        style="cursor: pointer; margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Lifestyle -->
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
                </form>

                <script>
                    let lifestyleIndex = 3; // Start from 3 for lifestyle since we have 3 default items

                    // Function to calculate the total lifestyle
                    function calculateLifestyleTotal() {
                        let total = 0;
                        const lifestyleFields = document.querySelectorAll('.lifestyle-amount');
                        lifestyleFields.forEach(function (input) {
                            total += parseFloat(input.value) || 0;  // Sum up all the budgeted lifestyle
                        });
                        document.getElementById('totallifestyle').textContent = total.toFixed(2);  // Display the total
                    }

                    // Add event listener to existing lifestyle input fields for changes
                    document.querySelectorAll('.lifestyle-amount').forEach(function (input) {
                        input.addEventListener('input', calculateLifestyleTotal);
                    });

                    // Event listener for adding new lifestyle rows
                    document.getElementById('add-lifestyle').addEventListener('click', function () {
                        const lifestyleCount = document.getElementsByClassName('lifestyle').length;
                        const newLifestyle = document.createElement('div');
                        newLifestyle.classList.add('lifestyle', 'row', 'mb-3');
                        newLifestyle.innerHTML = `
            <div class="col-md-8">
                <div class="form-group">
                    <label for="lifestyle[${lifestyleCount}][label]">Lifestyle for </label>
                    <input autofocus type="text" name="lifestyle[${lifestyleCount}][label]" id="lifestyle[${lifestyleCount}][label]" value="New Lifestyle" class="form-control product-select">
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="form-group flex-grow-1">
                    <label for="lifestyle[${lifestyleCount}][budgeted]">Budgeted</label>
                    <input type="number" name="lifestyle[${lifestyleCount}][budgeted]" id="lifestyle[${lifestyleCount}][budgeted]" class="form-control lifestyle-amount" value="0.00">
                </div>
                <i class="fas fa-times-circle text-danger delete-lifestyle" style="cursor: pointer; margin-left: 10px;"></i>
            </div>
        `;

                        document.getElementById('lifestyle').appendChild(newLifestyle);

                        // Attach event listener to the new input field for changes
                        newLifestyle.querySelector('.lifestyle-amount').addEventListener('input', calculateLifestyleTotal);

                        // Recalculate the total in case default value changes
                        calculateLifestyleTotal();
                    });

                    // Function to remove lifestyle rows
                    document.addEventListener('click', function (e) {
                        if (e.target.classList.contains('delete-lifestyle')) {
                            e.target.closest('.lifestyle').remove();
                            calculateLifestyleTotal();
                        }
                    });

                    // Initial calculation on page load
                    calculateLifestyleTotal();
                </script>
            </div>
            <!-- Results Section -->
            <div class="results-section">
                <div id="your-results">
                    <h4> Budget Summary</h4>

                    <div class="form-group">
                        <label for="income">Total Income</label>
                        <input type="number" id="income" class="form-control" value="0.00">
                    </div>

                    <div class="form-group">
                        <label>Net Savings</label>
                        <p id="netSavings" class="form-control">0.00</p>
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
@endpush
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
    </script> -->
@endpush
@endsection