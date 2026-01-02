<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Patrik Solutions</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/logos/patrick_logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Modern UI CSS -->
    <link href="{{ asset('css/modern-ui.css') }}" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
            padding: 2rem 0;
        }

        .auth-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .auth-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1.25rem;
            font-size: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            z-index: 10;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            z-index: 10;
            padding: 0.5rem;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }

        .password-strength-bar {
            height: 4px;
            border-radius: 2px;
            margin-top: 0.5rem;
            transition: all 0.3s ease;
        }

        .strength-weak { background: var(--danger-color); width: 33%; }
        .strength-medium { background: var(--warning-color); width: 66%; }
        .strength-strong { background: var(--success-color); width: 100%; }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .login-link p {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .benefits-list li {
            padding: 0.5rem 0;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .benefits-list li i {
            color: var(--success-color);
        }

        .alert {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions">
                </a>
                <h1>Create Account</h1>
                <p>Start your journey to financial freedom</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                @if(request('redirect'))
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                @endif

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1"></i>Full Name
                    </label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="John Doe">
                    </div>
                    @error('name')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-1"></i>Email Address
                    </label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="username"
                               placeholder="your@email.com">
                    </div>
                    @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-1"></i>Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Create a strong password"
                               oninput="checkPasswordStrength(this.value)">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    <div id="passwordStrength" class="password-strength" style="display: none;">
                        <div class="password-strength-bar" id="strengthBar"></div>
                        <small id="strengthText" class="text-muted"></small>
                    </div>
                    @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-1"></i>Confirm Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password_confirmation" 
                               class="form-control" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Confirm your password"
                               oninput="checkPasswordMatch()">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                    <div id="passwordMatch" style="display: none; margin-top: 0.5rem;">
                        <small id="matchText"></small>
                    </div>
                </div>

                <!-- Benefits -->
                <div style="background: rgba(102, 126, 234, 0.05); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
                    <h6 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.75rem;">
                        <i class="fas fa-gift me-2" style="color: var(--primary-color);"></i>What you'll get:
                    </h6>
                    <ul class="benefits-list">
                        <li><i class="fas fa-check-circle"></i> Access to all financial calculators</li>
                        <li><i class="fas fa-check-circle"></i> Track your financial milestones</li>
                        <li><i class="fas fa-check-circle"></i> Save and manage your budgets</li>
                        <li><i class="fas fa-check-circle"></i> Personalized financial assessment</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem; font-weight: 600;">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                <p>Already have an account?</p>
                <a href="{{ route('login') }}" class="btn btn-modern w-100" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2);">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In Instead
                </a>
            </div>

            <!-- Quick Links -->
            <div class="text-center mt-4">
                <a href="{{ route('index') }}" class="text-muted text-decoration-none" style="font-size: 0.875rem;">
                    <i class="fas fa-arrow-left me-1"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(inputId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                return;
            }
            
            strengthDiv.style.display = 'block';
            
            let strength = 0;
            let feedback = [];
            
            if (password.length >= 8) strength++;
            else feedback.push('at least 8 characters');
            
            if (/[a-z]/.test(password)) strength++;
            else feedback.push('lowercase letter');
            
            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('uppercase letter');
            
            if (/[0-9]/.test(password)) strength++;
            else feedback.push('number');
            
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            else feedback.push('special character');
            
            strengthBar.className = 'password-strength-bar';
            
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Weak password. Add: ' + feedback.slice(0, 2).join(', ');
                strengthText.style.color = 'var(--danger-color)';
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Medium password. Add: ' + feedback[0];
                strengthText.style.color = 'var(--warning-color)';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Strong password!';
                strengthText.style.color = 'var(--success-color)';
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('passwordMatch');
            const matchText = document.getElementById('matchText');
            
            if (confirmPassword.length === 0) {
                matchDiv.style.display = 'none';
                return;
            }
            
            matchDiv.style.display = 'block';
            
            if (password === confirmPassword) {
                matchText.innerHTML = '<i class="fas fa-check-circle me-1"></i>Passwords match';
                matchText.style.color = 'var(--success-color)';
            } else {
                matchText.innerHTML = '<i class="fas fa-times-circle me-1"></i>Passwords do not match';
                matchText.style.color = 'var(--danger-color)';
            }
        }
    </script>
</body>
</html>
