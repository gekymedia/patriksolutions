@extends('layouts.app')
@section('title', 'Financial Assessment - Patrik Solutions')

@push('styles')
<style>
        .assessment-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }

        .question-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            display: none;
        }

        .question-card.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .question-number {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .question-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .option-btn {
            width: 100%;
            padding: 1rem 1.5rem;
            margin-bottom: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            background: white;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .option-btn:hover {
            border-color: var(--primary-color);
            background: rgba(102, 126, 234, 0.05);
            transform: translateX(5px);
        }

        .option-btn.selected {
            border-color: var(--primary-color);
            background: var(--gradient-primary);
            color: white;
        }

        .progress-bar-container {
            background: var(--bg-light);
            border-radius: 12px;
            height: 8px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
            border-radius: 12px;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
    </style>
@endpush

@section('content')
<div class="modern-section" style="padding-top: 3rem; padding-bottom: 3rem; background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title" style="margin-bottom: 1rem;">
                <i class="fas fa-clipboard-check me-2"></i><span class="text-gradient">Financial Assessment</span>
            </h1>
            <p class="lead text-secondary" style="font-size: 1.25rem;">
                Discover your financial health and get a personalized plan to achieve your money goals
            </p>
        </div>

        <div class="assessment-container">
        <div class="progress-bar-container">
            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
        </div>

        <form id="assessmentForm" action="{{ route('financial-assessment.store') }}" method="POST">
            @csrf
            
            @if(!Auth::check())
            <div class="question-card active" data-question="0">
                <div class="question-number">Optional</div>
                <div class="question-title">What's your email? (We'll send you your personalized plan)</div>
                <input type="email" name="email" id="emailInput" class="form-control" placeholder="your@email.com" style="padding: 1rem; border-radius: 12px; border: 2px solid var(--border-color);">
            </div>
            @endif

            <div class="question-card {{ !Auth::check() ? '' : 'active' }}" data-question="{{ Auth::check() ? '0' : '1' }}">
                <div class="question-number">Question 1 of 5</div>
                <div class="question-title">What's your current debt situation?</div>
                <button type="button" class="option-btn" data-value="no_debt">
                    <i class="fas fa-check-circle me-2"></i>I'm debt-free!
                </button>
                <button type="button" class="option-btn" data-value="managing">
                    <i class="fas fa-balance-scale me-2"></i>I have debt but I'm managing it well
                </button>
                <button type="button" class="option-btn" data-value="struggling">
                    <i class="fas fa-exclamation-triangle me-2"></i>I'm struggling with debt payments
                </button>
                <button type="button" class="option-btn" data-value="not_sure">
                    <i class="fas fa-question-circle me-2"></i>I'm not sure about my total debt
                </button>
            </div>

            <div class="question-card" data-question="{{ Auth::check() ? '1' : '2' }}">
                <div class="question-number">Question 2 of 5</div>
                <div class="question-title">Do you have an emergency fund?</div>
                <button type="button" class="option-btn" data-value="yes_6months">
                    <i class="fas fa-shield-alt me-2"></i>Yes, 6+ months of expenses
                </button>
                <button type="button" class="option-btn" data-value="yes_3months">
                    <i class="fas fa-shield-alt me-2"></i>Yes, 3-6 months of expenses
                </button>
                <button type="button" class="option-btn" data-value="yes_1month">
                    <i class="fas fa-shield-alt me-2"></i>Yes, 1-3 months of expenses
                </button>
                <button type="button" class="option-btn" data-value="no">
                    <i class="fas fa-times-circle me-2"></i>No emergency fund yet
                </button>
            </div>

            <div class="question-card" data-question="{{ Auth::check() ? '2' : '3' }}">
                <div class="question-number">Question 3 of 5</div>
                <div class="question-title">How often do you save money?</div>
                <button type="button" class="option-btn" data-value="always">
                    <i class="fas fa-piggy-bank me-2"></i>I save money every month
                </button>
                <button type="button" class="option-btn" data-value="sometimes">
                    <i class="fas fa-piggy-bank me-2"></i>I save money sometimes
                </button>
                <button type="button" class="option-btn" data-value="rarely">
                    <i class="fas fa-piggy-bank me-2"></i>I rarely save money
                </button>
                <button type="button" class="option-btn" data-value="never">
                    <i class="fas fa-piggy-bank me-2"></i>I don't save money
                </button>
            </div>

            <div class="question-card" data-question="{{ Auth::check() ? '3' : '4' }}">
                <div class="question-number">Question 4 of 5</div>
                <div class="question-title">Are you currently investing?</div>
                <button type="button" class="option-btn" data-value="yes_regular">
                    <i class="fas fa-chart-line me-2"></i>Yes, I invest regularly
                </button>
                <button type="button" class="option-btn" data-value="yes_occasional">
                    <i class="fas fa-chart-line me-2"></i>Yes, occasionally
                </button>
                <button type="button" class="option-btn" data-value="planning">
                    <i class="fas fa-chart-line me-2"></i>I'm planning to start
                </button>
                <button type="button" class="option-btn" data-value="no">
                    <i class="fas fa-times-circle me-2"></i>No, not yet
                </button>
            </div>

            <div class="question-card" data-question="{{ Auth::check() ? '4' : '5' }}">
                <div class="question-number">Question 5 of 5</div>
                <div class="question-title">What's your biggest financial goal right now?</div>
                <button type="button" class="option-btn" data-value="debt_free">
                    <i class="fas fa-key me-2"></i>Become debt-free
                </button>
                <button type="button" class="option-btn" data-value="emergency_fund">
                    <i class="fas fa-shield-alt me-2"></i>Build an emergency fund
                </button>
                <button type="button" class="option-btn" data-value="retirement">
                    <i class="fas fa-piggy-bank me-2"></i>Save for retirement
                </button>
                <button type="button" class="option-btn" data-value="home">
                    <i class="fas fa-home me-2"></i>Buy a home
                </button>
            </div>

            <input type="hidden" name="answers" id="answersInput">
        </form>

        <div class="nav-buttons">
            <button type="button" class="btn btn-modern" id="prevBtn" style="display: none;">
                <i class="fas fa-arrow-left me-2"></i>Previous
            </button>
            <button type="button" class="btn btn-modern btn-modern-primary" id="nextBtn">
                Next <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <button type="submit" form="assessmentForm" class="btn btn-modern btn-modern-primary" id="submitBtn" style="display: none;">
                <i class="fas fa-check me-2"></i>Get My Plan
            </button>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
        let currentQuestion = 0;
        const answers = {};
        const totalQuestions = document.querySelectorAll('.question-card').length;
        const startQuestion = {{ Auth::check() ? 0 : 1 }};

        function showQuestion(n) {
            const questions = document.querySelectorAll('.question-card');
            questions.forEach((q, i) => {
                q.classList.remove('active');
                if (i === n) q.classList.add('active');
            });

            // Update progress
            const progress = ((n + 1) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = progress + '%';

            // Show/hide buttons
            document.getElementById('prevBtn').style.display = n > startQuestion ? 'block' : 'none';
            document.getElementById('nextBtn').style.display = n < totalQuestions - 1 ? 'block' : 'none';
            document.getElementById('submitBtn').style.display = n === totalQuestions - 1 ? 'block' : 'none';
        }

        document.querySelectorAll('.option-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const questionCard = this.closest('.question-card');
                const questionNum = parseInt(questionCard.dataset.question);
                
                // Remove selected from siblings
                questionCard.querySelectorAll('.option-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');

                // Store answer - map question numbers to answer keys
                // When logged out: 0=email, 1=debt, 2=emergency, 3=saving, 4=investing, 5=goal
                // When logged in: 0=debt, 1=emergency, 2=saving, 3=investing, 4=goal
                let questionKey;
                const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                
                if (isLoggedIn) {
                    // Logged in - no email question, question cards start at 0
                    questionKey = questionNum === 0 ? 'debt_situation' :
                        questionNum === 1 ? 'emergency_fund' :
                        questionNum === 2 ? 'saving_habit' :
                        questionNum === 3 ? 'investing' : 
                        questionNum === 4 ? 'goal' : null;
                } else {
                    // Logged out - email is question 0
                    questionKey = questionNum === 0 ? 'email' :
                        questionNum === 1 ? 'debt_situation' :
                        questionNum === 2 ? 'emergency_fund' :
                        questionNum === 3 ? 'saving_habit' :
                        questionNum === 4 ? 'investing' : 
                        questionNum === 5 ? 'goal' : null;
                }
                
                // Store answer (skip email as it's handled separately)
                if (questionKey && questionKey !== 'email') {
                    answers[questionKey] = this.dataset.value;
                    console.log('Stored answer:', questionKey, this.dataset.value);
                    console.log('Current answers:', answers);
                }
            });
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentQuestion < totalQuestions - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentQuestion > startQuestion) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        });

        document.getElementById('assessmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // First, collect all answers from visible selected buttons to ensure we have them
            const allQuestionCards = document.querySelectorAll('.question-card');
            allQuestionCards.forEach(card => {
                const questionNum = parseInt(card.dataset.question);
                const selectedBtn = card.querySelector('.option-btn.selected');
                if (selectedBtn) {
                    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                    let questionKey;
                    
                    if (isLoggedIn) {
                        questionKey = questionNum === 0 ? 'debt_situation' :
                            questionNum === 1 ? 'emergency_fund' :
                            questionNum === 2 ? 'saving_habit' :
                            questionNum === 3 ? 'investing' : 
                            questionNum === 4 ? 'goal' : null;
                    } else {
                        questionKey = questionNum === 1 ? 'debt_situation' :
                            questionNum === 2 ? 'emergency_fund' :
                            questionNum === 3 ? 'saving_habit' :
                            questionNum === 4 ? 'investing' : 
                            questionNum === 5 ? 'goal' : null;
                    }
                    
                    if (questionKey) {
                        answers[questionKey] = selectedBtn.dataset.value;
                    }
                }
            });
            
            // Validate all questions are answered
            const requiredAnswers = ['debt_situation', 'emergency_fund', 'saving_habit', 'investing', 'goal'];
            const missingAnswers = requiredAnswers.filter(key => !answers[key] || answers[key] === '');
            
            console.log('Validating answers:', answers);
            console.log('Required keys:', requiredAnswers);
            console.log('Missing answers:', missingAnswers);
            
            if (missingAnswers.length > 0) {
                alert('Please answer all questions before submitting.');
                // Go to first unanswered question
                const firstMissingKey = missingAnswers[0];
                let questionIndex = 0;
                const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                
                // Map answer key to question index
                if (isLoggedIn) {
                    // Logged in: 0=debt, 1=emergency, 2=saving, 3=investing, 4=goal
                    questionIndex = firstMissingKey === 'debt_situation' ? 0 :
                        firstMissingKey === 'emergency_fund' ? 1 :
                        firstMissingKey === 'saving_habit' ? 2 :
                        firstMissingKey === 'investing' ? 3 : 4;
                } else {
                    // Logged out: 1=debt, 2=emergency, 3=saving, 4=investing, 5=goal
                    questionIndex = firstMissingKey === 'debt_situation' ? 1 :
                        firstMissingKey === 'emergency_fund' ? 2 :
                        firstMissingKey === 'saving_habit' ? 3 :
                        firstMissingKey === 'investing' ? 4 : 5;
                }
                
                currentQuestion = questionIndex;
                showQuestion(currentQuestion);
                return;
            }

            // Capture email if not logged in
            @if(!Auth::check())
            const emailInput = document.querySelector('input[name="email"]');
            if (emailInput && emailInput.value) {
                answers.email = emailInput.value;
            }
            @endif

            // Set the answers in the hidden input
            document.getElementById('answersInput').value = JSON.stringify(answers);
            
            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            // Submit the form
            this.submit();
        });

        showQuestion(startQuestion);
    </script>
@endpush

