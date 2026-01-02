<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses at Patrik Solutions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('course.create') }}" class="btn btn-primary mb-4">Add a New Course</a>
                @endif
                <a href="#" class="btn btn-primary mb-4"><i class="fas fa-dashboard"></i> My Courses</a>

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
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach ($courses as $course)
                    
                        <div class="col">
                            <div class="card">
                                @if ($course->course_image_url)
                                    <img height="40px" src="{{ asset('storage/' . $course->course_image_url) }}" alt="Course Image"
                                        class="card-img-top ">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->course_name }}</h5>
                                    <p class="card-text">{{ $course->course_description }}</p>
                                    <a href="{{ route('course.show', $course) }}" class="btn btn-primary">View
                                        Lessons</a>
                                    {{-- <form action="{{ route('course.register.store', $course->id ) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <input type="text" name="course_id"value="{{ $course->id}}">
                                        <button type="submit" class="btn btn-warning dropdown-item"><i
                                                class="fas fa-airoplane"></i> Join Course</button>
                                    </form> --}}
                                    @if (Auth::user()->role == 'admin')
                                        <a class="dropdown-item btn btn-success"
                                            href="{{ route('course.edit', $course->id) }}"><i class="fas fa-pen"></i>
                                            Update
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('course.destroy', $course) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger dropdown-item"><i
                                                    class="fas fa-trash"></i> Delete</button>
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
</x-app-layout>
