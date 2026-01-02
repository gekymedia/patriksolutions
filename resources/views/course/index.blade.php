@extends('layouts.app')

@section('title', 'Courses')
@section('page-title', 'Courses at Patrik Solutions')
@section('page-description', 'Learn financial literacy with our comprehensive courses')

@section('content')
<div class="modern-section" style="background: var(--bg-light); padding: 2rem 0;">
    <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-2">Available Courses</h2>
                        <p class="text-muted mb-0">Enroll in courses to improve your financial literacy</p>
                    </div>
                    <div class="d-flex gap-2">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('course.create') }}" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-plus me-2"></i>Add New Course
                            </a>
                        @endif
                        <a href="{{ route('mycourses') }}" class="btn btn-modern btn-modern-outline">
                            <i class="fas fa-list me-2"></i>My Courses
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="toast toast-custom bg-success text-white" role="alert" aria-live="assertive"
                        aria-atomic="true" data-delay="5000">
                        <div class="toast-header">
                            <strong class="me-auto">Success</strong>
                            <small>Just now</small>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                <div class="row g-4">
                    @foreach ($courses as $course)
                        <div class="col-md-6 col-lg-4">
                            <div class="modern-card h-100">
                                @if ($course->course_image_url)
                                    <img src="{{ asset('storage/' . $course->course_image_url) }}" alt="Course Image"
                                        class="img-fluid rounded-modern mb-3" style="width: 100%; height: 200px; object-fit: cover;">
                                @else
                                    <div class="rounded-modern mb-3" style="height: 200px; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-graduation-cap" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                                    </div>
                                @endif
                                <div class="modern-card-header" style="border-bottom: none; padding: 0; margin-bottom: 1rem;">
                                    <h4 class="modern-card-title">{{ $course->course_name }}</h4>
                                </div>
                                <p class="text-muted mb-3">{{ Str::limit($course->course_description, 120) }}</p>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('course.show', $course) }}" class="btn btn-modern btn-modern-primary flex-fill">
                                        <i class="fas fa-book me-2"></i>View Lessons
                                    </a>
                                    <form action="{{ route('course.register.store', $course->id) }}" method="POST" class="flex-fill">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" class="btn btn-modern btn-modern-success w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>Join Course
                                        </button>
                                    </form>
                                    @if (Auth::user()->role == 'admin')
                                        <a href="{{ route('course.edit', $course->id) }}" class="btn btn-modern btn-modern-outline">
                                            <i class="fas fa-edit me-2"></i>Edit
                                        </a>
                                        <form action="{{ route('course.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-modern" style="background: rgba(239,68,68,0.1); color: var(--danger-color); border: 1px solid rgba(239,68,68,0.2);">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
