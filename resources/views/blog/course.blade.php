@extends('layouts.app')
@section('title', 'Patrik Solutions | Courses')

@section('content')

<section class="modern-section" style="background: var(--bg-light); padding-top: 3rem; padding-bottom: 3rem;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="section-title" style="margin-bottom: 1rem;">
                Available <span class="text-gradient">Courses</span>
            </h1>
            <p class="lead text-secondary" style="font-size: 1.25rem;">
                Enroll in our comprehensive financial education courses and take control of your financial future
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($courses->count() > 0)
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6">
                        <div class="modern-card h-100 d-flex flex-column">
                            @if($course->course_image_url)
                                <div class="mb-3" style="height: 200px; overflow: hidden; border-radius: 12px;">
                                    <img src="{{ asset('storage/' . $course->course_image_url) }}" 
                                         alt="{{ $course->course_name }}" 
                                         class="img-fluid w-100 h-100" 
                                         style="object-fit: cover;">
                                </div>
                            @else
                                <div class="mb-3" style="height: 200px; background: var(--gradient-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-graduation-cap text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            
                            <div class="flex-grow-1">
                                <h3 class="feature-title mb-3">{{ $course->course_name }}</h3>
                                <p class="feature-description mb-4">
                                    {{ Str::limit($course->course_description, 120) }}
                                </p>
                            </div>
                            
                            <div class="mt-auto">
                                @auth
                                    @if(in_array($course->id, $enrolledCourseIds))
                                        <a href="{{ route('mycourses') }}" class="btn btn-modern btn-modern-success w-100">
                                            <i class="fas fa-check-circle me-2"></i>Enrolled - View Course
                                        </a>
                                    @else
                                        <form action="{{ route('course.register.store') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" class="btn btn-modern btn-modern-primary w-100">
                                                <i class="fas fa-user-plus me-2"></i>Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-modern btn-modern-primary w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login to Enroll
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-graduation-cap text-muted" style="font-size: 5rem;"></i>
                </div>
                <h3 class="text-muted mb-3">No Courses Available</h3>
                <p class="text-secondary">Check back soon for new courses!</p>
            </div>
        @endif

        @auth
            <div class="text-center mt-5">
                <a href="{{ route('mycourses') }}" class="btn btn-modern btn-modern-outline">
                    <i class="fas fa-book me-2"></i>View My Enrolled Courses
                </a>
            </div>
        @endauth
    </div>
</section>

@endsection
