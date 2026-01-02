@extends('layouts.app')
@section('title', 'Your Financial Plan - Patrik Solutions')

@section('content')
<section class="modern-section" style="padding-top: 3rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Score Card -->
                    <div class="modern-card text-center mb-4" style="background: var(--gradient-primary); color: white;">
                        <h1 class="mb-3" style="color: white;">
                            <i class="fas fa-trophy me-2"></i>Your Financial Health Score
                        </h1>
                        <div style="font-size: 4rem; font-weight: 800; margin: 1rem 0;">
                            {{ $assessment->score }}/100
                        </div>
                        <p style="font-size: 1.25rem; opacity: 0.95;">
                            @if($assessment->score >= 80)
                                Excellent! You're on the path to financial freedom.
                            @elseif($assessment->score >= 60)
                                Good progress! Keep building your financial foundation.
                            @elseif($assessment->score >= 40)
                                You're getting started. Every step counts!
                            @else
                                Don't worry, everyone starts somewhere. Let's build your plan!
                            @endif
                        </p>
                    </div>

                    <!-- Current Stage -->
                    <div class="modern-card mb-4">
                        <h3 class="mb-3">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>
                            Your Current Stage
                        </h3>
                        <div class="alert alert-info" style="background: rgba(102, 126, 234, 0.1); border-left: 4px solid var(--primary-color);">
                            <strong>{{ ucfirst(str_replace('_', ' ', $assessment->current_stage)) }}</strong>
                            <p class="mb-0 mt-2">
                                @if($assessment->current_stage === 'emergency_mode')
                                    Focus on building your emergency fund and getting control of your finances.
                                @elseif($assessment->current_stage === 'getting_started')
                                    You're taking the first steps. Build your emergency fund and create a budget.
                                @elseif($assessment->current_stage === 'building_foundation')
                                    Great foundation! Continue building your emergency fund and paying off debt.
                                @elseif($assessment->current_stage === 'building_wealth')
                                    Excellent! Focus on investing and growing your wealth.
                                @else
                                    Outstanding! You're in advanced territory. Focus on wealth preservation and giving back.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Recommended Milestone -->
                    <div class="modern-card mb-4">
                        <h3 class="mb-3">
                            <i class="fas fa-flag-checkered me-2" style="color: var(--success-color);"></i>
                            Your Next Milestone
                        </h3>
                        <div class="p-4 rounded-modern" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid var(--success-color);">
                            <h4 style="color: var(--success-color); margin-bottom: 1rem;">
                                {{ ucfirst(str_replace('_', ' ', $assessment->recommended_milestone)) }}
                            </h4>
                            <p class="mb-0">
                                This is your recommended next step based on your current financial situation.
                            </p>
                        </div>
                    </div>

                    <!-- Personalized Plan -->
                    <div class="modern-card mb-4">
                        <h3 class="mb-4">
                            <i class="fas fa-list-check me-2" style="color: var(--primary-color);"></i>
                            Your Personalized Action Plan
                        </h3>
                        @php
                            $plan = is_string($assessment->personalized_plan) 
                                ? json_decode($assessment->personalized_plan, true) 
                                : $assessment->personalized_plan;
                        @endphp
                        @if(is_array($plan))
                            <ul class="list-unstyled">
                                @foreach($plan as $index => $action)
                                <li class="mb-3 p-3 rounded-modern" style="background: var(--bg-light); border-left: 4px solid var(--primary-color);">
                                    <div class="d-flex align-items-start">
                                        <span class="badge rounded-circle d-flex align-items-center justify-content-center me-3" 
                                              style="width: 32px; height: 32px; background: var(--gradient-primary); color: white; font-weight: 600;">
                                            {{ $index + 1 }}
                                        </span>
                                        <span style="font-size: 1.1rem; line-height: 1.6;">{{ $action }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem;">
                                <i class="fas fa-calculator me-2"></i>Start Budgeting
                            </a>
                        </div>
                        <div class="col-md-6">
                            @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-modern w-100" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2); padding: 1rem;">
                                <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                            </a>
                            @else
                            <a href="{{ route('register') }}" class="btn btn-modern w-100" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2); padding: 1rem;">
                                <i class="fas fa-user-plus me-2"></i>Create Free Account
                            </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Related Resources -->
                    <div class="modern-card">
                        <h4 class="mb-3">
                            <i class="fas fa-book me-2"></i>Recommended Resources
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('course.index') }}" class="text-decoration-none">
                                    <div class="p-3 rounded-modern" style="background: var(--bg-light); border: 1px solid var(--border-color); transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)'">
                                        <i class="fas fa-graduation-cap me-2" style="color: var(--primary-color);"></i>
                                        <strong>Financial Courses</strong>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('blog-posts') }}" class="text-decoration-none">
                                    <div class="p-3 rounded-modern" style="background: var(--bg-light); border: 1px solid var(--border-color); transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='translateY(0)'">
                                        <i class="fas fa-blog me-2" style="color: var(--primary-color);"></i>
                                        <strong>Financial Articles</strong>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

