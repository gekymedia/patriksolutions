@extends('layouts.app')
@section('title', 'Patrik Solutions - Financial Literacy, AI Training & Tools')

@section('content')
<!-- Hero Section -->
    <section class="modern-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 modern-hero-content fade-in-up">
                    <h1 class="hero-title">
                        Master Your Finances with 
                        <span class="text-gradient" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Patrik Solutions</span>
                    </h1>
                    <p class="hero-subtitle">
                        Your ultimate destination for financial literacy and AI training. Explore powerful calculators, 
                        educational resources, expert guidance, and hands-on AI learning to take control of your financial future.
                    </p>
                           <div class="hero-buttons">
                               <a href="{{ route('financial-assessment.index') }}" class="btn btn-modern btn-lg" style="background: rgba(255,255,255,0.95); color: var(--primary-color); border: 2px solid rgba(255,255,255,0.3);">
                                   <i class="fas fa-clipboard-check"></i>
                                   Take Free Assessment
                               </a>
                               <a href="#ai-training" class="btn btn-modern btn-lg" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3);">
                                   <i class="fas fa-robot"></i>
                                   AI Training &amp; Register
                               </a>
                               @auth
                                   <a href="{{ route('dashboard') }}" class="btn btn-modern btn-modern-primary btn-lg">
                                       <i class="fas fa-tachometer-alt"></i>
                                       Go to Dashboard
                                   </a>
                               @else
                                   <a href="{{ route('login') }}" class="btn btn-modern btn-modern-primary btn-lg">
                                       <i class="fas fa-sign-in-alt"></i>
                                       Get Started
                                   </a>
                                   <a href="{{ route('register') }}" class="btn btn-modern btn-lg" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3);">
                                       <i class="fas fa-user-plus"></i>
                                       Sign Up
                                   </a>
                               @endauth
                               <a href="#calculators" class="btn btn-modern btn-lg" style="background: rgba(255,255,255,0.2); color: white; border: 2px solid rgba(255,255,255,0.3);">
                                   <i class="fas fa-calculator"></i>
                                   Try Calculators
                               </a>
                           </div>
                </div>
                <div class="col-lg-6 text-center fade-in-up" style="animation-delay: 0.2s;">
                    <div class="modern-card glass" style="margin-top: 2rem;">
                        <i class="fas fa-chart-line" style="font-size: 8rem; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="modern-section" id="calculators">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Financial Tools</h2>
                <p>Discover your financial health and make informed decisions with our comprehensive suite of tools</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3 class="feature-title">AI Training</h3>
                        <p class="feature-description">
                            Join our live AI training sessions via Zoom. Learn practical AI skills alongside 
                            financial tools—register for upcoming events and stay ahead.
                        </p>
                        <a href="#ai-training" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Register for AI Training <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-warm);">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3 class="feature-title">Financial Assessment</h3>
                        <p class="feature-description">
                            Take our free assessment to discover your financial health score and get a personalized 
                            action plan tailored to your situation.
                        </p>
                        <a href="{{ route('financial-assessment.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Take Assessment <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h3 class="feature-title">Budget Calculator</h3>
                        <p class="feature-description">
                            Track your income and expenses with our comprehensive budget calculator. 
                            Plan your finances effectively and achieve your financial goals.
                        </p>
                        <a href="{{ route('budget_calculator.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-success);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Investment Calculator</h3>
                        <p class="feature-description">
                            Calculate your potential returns on investments. Plan your retirement 
                            and see how your money can grow over time.
                        </p>
                        <a href="{{ route('investment_calculator.index') }}" class="btn btn-modern btn-modern-success w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-info);">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h3 class="feature-title">Retirement Calculator</h3>
                        <p class="feature-description">
                            Plan for your golden years. Calculate how much you need to save 
                            to retire comfortably and achieve financial independence.
                        </p>
                        <a href="{{ route('retirement_calculator.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-warm);">
                            <i class="fas fa-home"></i>
                        </div>
                        <h3 class="feature-title">Mortgage Calculator</h3>
                        <p class="feature-description">
                            Calculate your monthly mortgage payments. Compare different loan terms 
                            and find the best mortgage option for your needs.
                        </p>
                        <a href="{{ route('mortgage-calculator') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-cool);">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3 class="feature-title">Mortgage Payoff</h3>
                        <p class="feature-description">
                            See how quickly you can pay off your mortgage. Calculate payoff dates 
                            and strategies to become debt-free faster.
                        </p>
                        <a href="{{ route('mortgage.payoff') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-warm);">
                            <i class="fas fa-snowflake"></i>
                        </div>
                        <h3 class="feature-title">Debt Snowball</h3>
                        <p class="feature-description">
                            Pay off your debts faster using the debt snowball method. Start with 
                            your smallest debt and build momentum toward financial freedom.
                        </p>
                        <a href="{{ route('debt-snowball-calculator.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-info);">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3 class="feature-title">Net Worth</h3>
                        <p class="feature-description">
                            Calculate your net worth by tracking your assets and liabilities. 
                            Know exactly where you stand financially.
                        </p>
                        <a href="{{ route('net-worth-calculator.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-success);">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <h3 class="feature-title">Compound Interest</h3>
                        <p class="feature-description">
                            See how your money grows with compound interest. Time and consistency 
                            are your greatest assets in building wealth.
                        </p>
                        <a href="{{ route('compound-interest-calculator.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Use Calculator <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--gradient-dark);">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="feature-title">Financial Courses</h3>
                        <p class="feature-description">
                            Learn from experts with our comprehensive financial literacy courses. 
                            Build the knowledge you need for financial success.
                        </p>
                        <a href="{{ route('course.index') }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            View Courses <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Training & Event Registration Section -->
    <section class="modern-section" id="ai-training" style="background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);">
        <div class="container">
            <div class="section-title">
                <h2><i class="fas fa-robot me-2" style="color: #6366f1;"></i>AI Training &amp; Event Registration</h2>
                <p>Register for our AI training sessions—delivered live on Zoom. Master AI alongside our financial services. Contact us at <a href="tel:7039811910" style="color: var(--primary-color); font-weight: 600;">(703) 981-1910</a>.</p>
            </div>
            <div class="row align-items-start">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="modern-card h-100 p-4">
                        <h4 class="mb-3" style="font-weight: 700; color: var(--text-primary);">Why join our AI training?</h4>
                        <ul class="list-unstyled mb-0" style="line-height: 2;">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Live sessions via Zoom</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Practical, hands-on AI skills</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Expert-led workshops</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Financial literacy + AI in one place</li>
                        </ul>
                        <hr class="my-4">
                        <p class="mb-2 small text-muted"><i class="fas fa-video me-1"></i> Location: Zoom</p>
                        <p class="mb-0 small text-muted"><i class="fas fa-phone me-1"></i> <a href="tel:7039811910" style="color: var(--primary-color);">(703) 981-1910</a></p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="modern-card p-0 overflow-hidden">
                        <div class="p-3 px-4" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white;">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Event registration</h5>
                            <p class="mb-0 small opacity-90">Complete the form below to register. We&rsquo;ll send you details for the Zoom session.</p>
                        </div>
                        <div class="p-2 p-lg-3">
                            <iframe
                                src="https://docs.google.com/forms/d/1uBWEHO8vTvV5OqYtnneQ1lIYQkym2qi0Uk4M_SU3LEc/viewform?embedded=true"
                                width="100%"
                                height="650"
                                frameborder="0"
                                marginheight="0"
                                marginwidth="0"
                                title="AI Training Event Registration"
                                style="min-height: 600px; border-radius: 8px;"
                            >Loading…</iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="modern-section" style="background: white;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title text-start mb-4">
                        <span style="color: var(--primary-color);">About</span> Patrik Solutions
                    </h2>
                    <p style="font-size: 1.125rem; color: var(--text-secondary); line-height: 1.8; margin-bottom: 1.5rem;">
                        At Patrik Solutions, we believe in the power of financial literacy to transform lives. 
                        Our platform is dedicated to providing individuals with the knowledge, tools, and support 
                        they need to take control of their finances and build a secure future.
                    </p>
                    <p style="font-size: 1.125rem; color: var(--text-secondary); line-height: 1.8; margin-bottom: 1.5rem;">
                        Whether you're looking to master the basics of budgeting, explore investment opportunities, 
                        or tackle debt, we're here to guide you every step of the way. With expert advice, 
                        interactive tools, and a vibrant community, Patrik Solutions is your trusted partner 
                        on the journey to financial empowerment.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <div class="text-center p-3 rounded-modern" style="background: rgba(102, 126, 234, 0.1); flex: 1; min-width: 150px;">
                            <h3 class="mb-0" style="font-size: 2rem; font-weight: 800; color: var(--primary-color);">500+</h3>
                            <p class="mb-0 text-muted">Active Users</p>
                        </div>
                        <div class="text-center p-3 rounded-modern" style="background: rgba(16, 185, 129, 0.1); flex: 1; min-width: 150px;">
                            <h3 class="mb-0" style="font-size: 2rem; font-weight: 800; color: var(--success-color);">1000+</h3>
                            <p class="mb-0 text-muted">Calculations Done</p>
                        </div>
                        <div class="text-center p-3 rounded-modern" style="background: rgba(59, 130, 246, 0.1); flex: 1; min-width: 150px;">
                            <h3 class="mb-0" style="font-size: 2rem; font-weight: 800; color: var(--info-color);">50+</h3>
                            <p class="mb-0 text-muted">Blog Articles</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card shadow-modern">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-4 rounded-modern text-center" style="background: var(--gradient-primary); color: white;">
                                    <i class="fas fa-calculator fa-3x mb-3"></i>
                                    <h5>Easy to Use</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-4 rounded-modern text-center" style="background: var(--gradient-success); color: white;">
                                    <i class="fas fa-shield-alt fa-3x mb-3"></i>
                                    <h5>Secure & Safe</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-4 rounded-modern text-center" style="background: var(--gradient-info); color: white;">
                                    <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                    <h5>Educational</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-4 rounded-modern text-center" style="background: var(--gradient-warm); color: white;">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>Community</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories Section -->
    @if(isset($successStories) && $successStories->count() > 0)
    <section class="modern-section" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-title">
                <h2>Real People. <span class="text-gradient">Real Success.</span></h2>
                <p>See how others have transformed their financial lives using our tools and resources</p>
            </div>
            <div class="row g-4">
                @foreach($successStories as $story)
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        @if($story->image)
                        <img src="{{ asset('storage/' . $story->image) }}" 
                             alt="{{ $story->name }}"
                             class="img-fluid rounded-modern mb-3"
                             style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                        <div class="rounded-modern mb-3" style="height: 200px; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-circle" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                        </div>
                        @endif
                        <h3 class="feature-title" style="font-size: 1.25rem;">{{ $story->name }}</h3>
                        @if($story->title)
                        <p class="text-primary mb-2" style="font-weight: 600;">
                            <i class="fas fa-trophy me-1"></i>{{ $story->title }}
                        </p>
                        @endif
                        <p class="feature-description">{{ Str::limit($story->story, 120) }}</p>
                        @if($story->amount)
                        <div class="mb-3">
                            <span class="badge rounded-pill" style="background: var(--gradient-success); color: white; padding: 0.5rem 1rem; font-size: 1rem;">
                                <i class="fas fa-dollar-sign me-1"></i>{{ number_format($story->amount, 0) }}
                            </span>
                        </div>
                        @endif
                        <a href="{{ route('success-stories.show', $story->id) }}" class="btn btn-modern btn-modern-primary w-100 mt-3">
                            Read Full Story <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('success-stories.index') }}" class="btn btn-modern btn-modern-primary btn-lg">
                    View All Success Stories <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Blogs Section -->
    @if(isset($blogs) && $blogs->count() > 0)
    <section class="modern-section" style="background: #f9fafb;">
        <div class="container">
            <div class="section-title">
                <h2>Latest Blog Posts</h2>
                <p>Stay informed with our latest financial insights and tips</p>
            </div>
            <div class="row g-4">
                @foreach($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card h-100">
                        @if($blog->blog_thumbnail)
                        <img src="{{ asset('storage/' . $blog->blog_thumbnail) }}" 
                             alt="{{ $blog->blog_title }}" 
                             class="img-fluid rounded-modern mb-3"
                             style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="modern-card-header" style="border-bottom: none; padding: 0; margin: 0;">
                            <h3 class="modern-card-title" style="font-size: 1.25rem;">
                                <a href="{{ route('blog-details', $blog->id) }}" 
                                   style="color: var(--text-primary); text-decoration: none;">
                                    {{ Str::limit($blog->blog_title, 60) }}
                                </a>
                            </h3>
                            <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.875rem;">
                                <span><i class="fas fa-user"></i> {{ $blog->blog_author }}</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                <span><i class="fas fa-eye"></i> {{ $blog->blog_view }}</span>
                            </div>
                        </div>
                        <a href="{{ route('blog-details', $blog->id) }}" 
                           class="btn btn-modern btn-modern-outline w-100">
                            Read More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('blog-posts') }}" class="btn btn-modern btn-modern-primary btn-lg">
                    View All Blog Posts <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- YouTube Videos Section -->
    @if(isset($youtubes) && $youtubes->count() > 0)
    <section class="modern-section" style="background: white;">
        <div class="container">
            <div class="section-title">
                <h2>Educational Videos</h2>
                <p>Watch our latest financial education videos</p>
            </div>
            <div class="row g-4">
                @foreach($youtubes as $youtube)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card">
                        <div class="ratio ratio-16x9">
                            {!! $youtube->url !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Blogs Section -->
    @if(isset($blogs) && $blogs->count() > 0)
    <section class="modern-section" style="background: #f9fafb;">
        <div class="container">
            <div class="section-title">
                <h2>Latest Blog Posts</h2>
                <p>Stay informed with our latest financial insights and tips</p>
            </div>
            <div class="row g-4">
                @foreach($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card h-100">
                        @if($blog->blog_thumbnail)
                        <img src="{{ asset('storage/' . $blog->blog_thumbnail) }}" 
                             alt="{{ $blog->blog_title }}" 
                             class="img-fluid rounded-modern mb-3"
                             style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="modern-card-header" style="border-bottom: none; padding: 0; margin: 0;">
                            <h3 class="modern-card-title" style="font-size: 1.25rem;">
                                <a href="{{ route('blog-details', $blog->id) }}" 
                                   style="color: var(--text-primary); text-decoration: none;">
                                    {{ Str::limit($blog->blog_title, 60) }}
                                </a>
                            </h3>
                            <div class="d-flex gap-3 text-muted mb-3" style="font-size: 0.875rem; flex-wrap: wrap;">
                                <span><i class="fas fa-user"></i> {{ $blog->blog_author }}</span>
                                <span><i class="fas fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                <span><i class="fas fa-eye"></i> {{ $blog->blog_view }}</span>
                            </div>
                        </div>
                        <a href="{{ route('blog-details', $blog->id) }}" 
                           class="btn btn-modern btn-modern-outline w-100">
                            Read More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('blog-posts') }}" class="btn btn-modern btn-modern-primary btn-lg">
                    View All Blog Posts <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- YouTube Videos Section -->
    @if(isset($youtubes) && $youtubes->count() > 0)
    <section class="modern-section" style="background: white;">
        <div class="container">
            <div class="section-title">
                <h2>Educational Videos</h2>
                <p>Watch our latest financial education videos</p>
            </div>
            <div class="row g-4">
                @foreach($youtubes as $youtube)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-card">
                        <div class="ratio ratio-16x9">
                            {!! $youtube->url !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <section class="modern-section" style="background: var(--gradient-primary); color: white; padding: 4rem 0; width: 100%; margin: 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 style="font-size: 2.5rem; font-weight: 800; color: white; margin-bottom: 1rem;">
                        <i class="fas fa-envelope-open-text me-2"></i>Stay Updated
                    </h2>
                    <p style="font-size: 1.25rem; opacity: 0.95; line-height: 1.7;">
                        Get weekly financial tips, calculator updates, and exclusive content delivered to your inbox. 
                        Join our community of financially empowered individuals.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="modern-card" style="background: rgba(255,255,255,0.95);">
                        <form id="newsletterForm" class="p-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 600; color: var(--text-primary);">
                                    <i class="fas fa-user me-2"></i>Your Name (Optional)
                                </label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" style="padding: 0.75rem; border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 600; color: var(--text-primary);">
                                    <i class="fas fa-envelope me-2"></i>Email Address *
                                </label>
                                <input type="email" name="email" class="form-control" placeholder="your@email.com" required style="padding: 0.75rem; border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 600; color: var(--text-primary);">
                                    <i class="fas fa-heart me-2"></i>Interests (Optional)
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="interests[]" value="budgeting" class="form-check-input me-1"> Budgeting
                                    </label>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="interests[]" value="investing" class="form-check-input me-1"> Investing
                                    </label>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="interests[]" value="debt" class="form-check-input me-1"> Debt Management
                                    </label>
                                    <label class="form-check-label">
                                        <input type="checkbox" name="interests[]" value="retirement" class="form-check-input me-1"> Retirement
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-modern btn-modern-primary w-100" style="padding: 1rem;">
                                <i class="fas fa-paper-plane me-2"></i>Subscribe to Newsletter
                            </button>
                            <p class="text-muted mt-3 mb-0" style="font-size: 0.875rem;">
                                <i class="fas fa-shield-alt me-1"></i>We respect your privacy. Unsubscribe anytime.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="modern-section" style="background: var(--bg-light); width: 100%; margin: 0;">
        <div class="container text-center">
            <h2 class="mb-4" style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary);">Ready to Transform Your Finances &amp; Build AI Skills?</h2>
            <p class="mb-5" style="font-size: 1.25rem; color: var(--text-secondary);">
                Join thousands of users taking control of their financial future—and register for our AI training events.
            </p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('financial-assessment.index') }}" class="btn btn-modern btn-modern-primary btn-lg">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Take Free Assessment
                </a>
                <a href="#ai-training" class="btn btn-modern btn-lg" style="background: linear-gradient(135deg, rgba(139,92,246,0.15) 0%, rgba(99,102,241,0.15) 100%); color: #6366f1; border: 1px solid rgba(99,102,241,0.3);">
                    <i class="fas fa-robot me-2"></i>
                    Register for AI Training
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-modern btn-lg" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2);">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-modern btn-lg" style="background: rgba(102,126,234,0.1); color: var(--primary-color); border: 1px solid rgba(102,126,234,0.2);">
                        <i class="fas fa-user-plus me-2"></i>
                        Get Started Free
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="full-width-section" style="background: var(--dark-color); color: white; padding: 4rem 0 2rem; margin-top: 4rem;">
        <div class="container">
            <div class="row g-4 mb-4">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('assets/logos/patrick_logo.png') }}" alt="Patrik Solutions Logo" class="me-3" style="height: 50px; width: 50px; border-radius: 8px;">
                    <h4 class="mb-0" style="font-weight: 700; font-size: 1.5rem;">Patrik Solutions</h4>
                </div>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 1.5rem; font-size: 15px;">
                    Your trusted partner in financial literacy and empowerment. We provide the tools, knowledge, and support you need to achieve your financial goals.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(102,126,234,0.8)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(102,126,234,0.8)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(102,126,234,0.8)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(102,126,234,0.8)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; color: white; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(102,126,234,0.8)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; color: white;">Quick Links</h5>
                <ul class="list-unstyled" style="line-height: 2.2;">
                    <li>
                        <a href="{{ route('index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog-posts') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Blog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('courses') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Courses
                        </a>
                    </li>
                    @if(Route::has('financial-assessment.index'))
                    <li>
                        <a href="{{ route('financial-assessment.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Financial Assessment
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('index') }}#ai-training" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>AI Training
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tools Column -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; color: white;">Free Tools</h5>
                <ul class="list-unstyled" style="line-height: 2.2;">
                    <li>
                        <a href="{{ route('budget_calculator.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Budget Calculator
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('investment_calculator.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Investment Calculator
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('retirement_calculator.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Retirement Calculator
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mortgage-calculator') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Mortgage Calculator
                        </a>
                    </li>
                    @if(Route::has('debt-snowball-calculator.index'))
                    <li>
                        <a href="{{ route('debt-snowball-calculator.index') }}" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease; font-size: 15px;" onmouseover="this.style.color='white'; this.style.paddingLeft='5px'" onmouseout="this.style.color='rgba(255,255,255,0.8)'; this.style.paddingLeft='0'">
                            <i class="fas fa-chevron-right me-2" style="font-size: 0.75rem;"></i>Debt Snowball Calculator
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3" style="font-weight: 700; font-size: 1.125rem; color: white;">Contact Us</h5>
                <ul class="list-unstyled" style="line-height: 2.2;">
                    <li style="color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 0.75rem;">
                        <i class="fas fa-phone me-2" style="color: var(--primary-color);"></i>
                        <a href="tel:2025901404" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">202-590-1404</a>
                    </li>
                    <li style="color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 0.75rem;">
                        <i class="fas fa-envelope me-2" style="color: var(--primary-color);"></i>
                        <a href="mailto:patriksolutions@gmail.com" style="color: rgba(255,255,255,0.8); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">patriksolutions@gmail.com</a>
                    </li>
                    <li style="color: rgba(255,255,255,0.8); font-size: 15px; margin-bottom: 0.75rem;">
                        <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>
                        <span>United States</span>
                    </li>
                </ul>
                
                <!-- Newsletter Signup -->
                <div class="mt-4">
                    <h6 class="mb-2" style="font-weight: 600; font-size: 1rem; color: white;">Newsletter</h6>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.875rem; margin-bottom: 1rem;">Get financial tips delivered to your inbox</p>
                    <form action="#" method="POST" class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Your email" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 8px; padding: 0.625rem 1rem; font-size: 15px;" onfocus="this.style.background='rgba(255,255,255,0.15)'; this.style.borderColor='var(--primary-color)'" onblur="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'">
                        <button type="submit" class="btn" style="background: var(--gradient-primary); color: white; border: none; border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(102,126,234,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 3rem; padding-top: 2rem;">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p style="color: rgba(255,255,255,0.7); margin: 0; font-size: 15px;">
                        © {{ date('Y') }} Patrik Solutions. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex gap-4 justify-content-md-end justify-content-start flex-wrap" style="font-size: 15px;">
                        <a href="#" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Privacy Policy</a>
                        <a href="#" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Terms of Service</a>
                        <a href="#" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s ease;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </footer>

@push('scripts')
<script>
        // Ensure navbar is always visible
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.modern-navbar');
            if (navbar) {
                navbar.style.display = 'block';
                navbar.style.visibility = 'visible';
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.modern-navbar');
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                navbar.style.display = 'block';
                navbar.style.visibility = 'visible';
            }
        });

        // Handle dropdown hover on desktop
        if (window.innerWidth >= 992) {
            document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu-modern');
                
                if (toggle && menu) {
                    let hoverTimeout;
                    
                    dropdown.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                        dropdown.classList.add('show');
                        toggle.setAttribute('aria-expanded', 'true');
                        menu.style.display = 'block';
                    });
                    
                    dropdown.addEventListener('mouseleave', function() {
                        hoverTimeout = setTimeout(function() {
                            dropdown.classList.remove('show');
                            toggle.setAttribute('aria-expanded', 'false');
                        }, 150);
                    });
                    
                    menu.addEventListener('mouseenter', function() {
                        clearTimeout(hoverTimeout);
                    });
                    
                    menu.addEventListener('mouseleave', function() {
                        dropdown.classList.remove('show');
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        }
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                const navDropdowns = document.querySelectorAll('.nav-dropdown');
                navDropdowns.forEach(function(dropdown) {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                    dropdown.classList.remove('show');
                });
            }, 250);
        });
        
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endpush
@endsection

