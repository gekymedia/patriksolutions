@extends('layouts.app')

@section('title', 'Financial Coaching')
@section('page-title', 'Financial Coaching')
@section('page-description', 'Get personalized financial advice from our experts')

@section('content')
<section class="modern-section" style="background: var(--bg-light); padding-top: 2rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <div class="modern-card mb-4">
                        <h3 class="mb-4">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-color);"></i>
                            What is Financial Coaching?
                        </h3>
                        <p style="line-height: 1.8; color: var(--text-secondary);">
                            Our financial coaching service provides personalized guidance to help you achieve your financial goals. 
                            Whether you're struggling with debt, planning for retirement, or looking to build wealth, our experts 
                            can help you create a customized plan that works for your unique situation.
                        </p>
                    </div>

                    <div class="modern-card">
                        <h3 class="mb-4">
                            <i class="fas fa-edit me-2" style="color: var(--primary-color);"></i>
                            Request a Coaching Session
                        </h3>
                        <form action="{{ route('financial-coaching.store') }}" method="POST">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-1"></i>Full Name *
                                    </label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Email Address *
                                    </label>
                                    <input type="email" name="email" class="form-control" 
                                           value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-phone me-1"></i>Phone Number
                                    </label>
                                    <input type="tel" name="phone" class="form-control" 
                                           value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-tag me-1"></i>Coaching Type
                                    </label>
                                    <select name="coaching_type" class="form-control">
                                        <option value="general">General Financial Planning</option>
                                        <option value="debt">Debt Management</option>
                                        <option value="investing">Investing & Wealth Building</option>
                                        <option value="retirement">Retirement Planning</option>
                                        <option value="budgeting">Budgeting & Saving</option>
                                        <option value="home">Home Buying</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-heading me-1"></i>Subject
                                </label>
                                <input type="text" name="subject" class="form-control" 
                                       placeholder="Brief summary of what you'd like help with">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-comment-alt me-1"></i>Message *
                                </label>
                                <textarea name="message" class="form-control" rows="6" required 
                                          placeholder="Tell us about your financial situation and what you'd like to achieve..."></textarea>
                                <small class="text-muted">Please provide as much detail as possible so we can better assist you.</small>
                            </div>

                            <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem; font-size: 1.1rem;">
                                <i class="fas fa-paper-plane me-2"></i>Submit Coaching Request
                            </button>
                        </form>
                    </div>

                    <div class="modern-card mt-4" style="background: rgba(102, 126, 234, 0.1); border-left: 4px solid var(--primary-color);">
                        <h5 class="mb-3">
                            <i class="fas fa-question-circle me-2"></i>What to Expect
                        </h5>
                        <ul style="line-height: 2; color: var(--text-secondary);">
                            <li>We'll review your request within 24-48 hours</li>
                            <li>One of our financial experts will contact you</li>
                            <li>We'll schedule a consultation at your convenience</li>
                            <li>You'll receive a personalized action plan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

