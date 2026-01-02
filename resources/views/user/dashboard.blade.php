@extends('layouts.user-dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Welcome back, ' . Auth::user()->name . '!')
@section('page-description', 'Manage your finances and explore our tools')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem;">
                <i class="fas fa-calculator"></i>
            </div>
            <h4 class="mb-2">Calculators</h4>
            <p class="text-muted mb-3">Access all financial calculators</p>
            <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern btn-modern-primary w-100">
                Get Started
            </a>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-success);">
                <i class="fas fa-list"></i>
            </div>
            <h4 class="mb-2">My Budgets</h4>
            <p class="text-muted mb-3">View your saved budgets</p>
            <a href="{{ route('budget_calculator.list') }}" class="btn btn-modern btn-modern-success w-100">
                View Budgets
            </a>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-info);">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h4 class="mb-2">Courses</h4>
            <p class="text-muted mb-3">Learn financial literacy</p>
            <a href="{{ route('course.index') }}" class="btn btn-modern btn-modern-primary w-100">
                Browse Courses
            </a>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-warm);">
                <i class="fas fa-blog"></i>
            </div>
            <h4 class="mb-2">Blog Posts</h4>
            <p class="text-muted mb-3">Read financial articles</p>
            <a href="{{ route('blog-posts') }}" class="btn btn-modern btn-modern-primary w-100">
                Read Blog
            </a>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-primary);">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <h4 class="mb-2">My Milestones</h4>
            <p class="text-muted mb-3">Track your financial goals</p>
            <a href="{{ route('financial-milestones.index') }}" class="btn btn-modern btn-modern-primary w-100">
                View Milestones
            </a>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="modern-card text-center">
            <div class="feature-icon mx-auto mb-3" style="width: 56px; height: 56px; font-size: 1.5rem; background: var(--gradient-info);">
                <i class="fas fa-user-tie"></i>
            </div>
            <h4 class="mb-2">Get Coaching</h4>
            <p class="text-muted mb-3">Personalized financial advice</p>
            <a href="{{ route('financial-coaching.index') }}" class="btn btn-modern btn-modern-primary w-100">
                Request Coaching
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="modern-card-header">
                <h3 class="modern-card-title">Quick Access</h3>
                <p class="modern-card-subtitle">Most used calculators and tools</p>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('budget_calculator.index') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Budget Calculator</h5>
                                <p class="text-muted mb-0 small">Track income & expenses</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('investment_calculator.index') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: var(--gradient-success);">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Investment Calculator</h5>
                                <p class="text-muted mb-0 small">Plan your investments</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('retirement_calculator.index') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: var(--gradient-info);">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Retirement Calculator</h5>
                                <p class="text-muted mb-0 small">Plan for retirement</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('mortgage-calculator') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: var(--gradient-warm);">
                                <i class="fas fa-home"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Mortgage Calculator</h5>
                                <p class="text-muted mb-0 small">Calculate payments</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('financial-milestones.index') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: var(--gradient-primary);">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Financial Milestones</h5>
                                <p class="text-muted mb-0 small">Track your goals</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('financial-assessment.index') }}" class="modern-card d-block text-decoration-none" style="padding: 1.5rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="feature-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: var(--gradient-warm);">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Financial Assessment</h5>
                                <p class="text-muted mb-0 small">Get your score</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="modern-card bg-gradient-primary text-white">
            <h4 class="text-white mb-3">
                <i class="fas fa-lightbulb"></i> Tip of the Day
            </h4>
            <p style="opacity: 0.95;">
                Start tracking your expenses today. Even small amounts add up over time. 
                Use our budget calculator to get a clear picture of where your money is going.
            </p>
            <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern mt-3" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3);">
                Create Budget <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        @if(Auth::user()->role == 'admin')
        <div class="modern-card mt-4">
            <h5 class="mb-3">Admin Actions</h5>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('blogs.index') }}" class="btn btn-modern btn-modern-outline">
                    <i class="fas fa-blog"></i> Manage Blogs
                </a>
                <a href="{{ route('admin.blog-notifications.index') }}" class="btn btn-modern btn-modern-outline">
                    <i class="fas fa-bell"></i> Blog Subscribers
                </a>
                <a href="{{ route('youtube.index') }}" class="btn btn-modern btn-modern-outline">
                    <i class="fab fa-youtube"></i> Manage Videos
                </a>
                <a href="{{ route('contact.index') }}" class="btn btn-modern btn-modern-outline">
                    <i class="fas fa-envelope"></i> View Messages
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
