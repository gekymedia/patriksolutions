<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses at Patrik Solutions') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <p class="login-box-msg">@include('message.flash-message')</p>

                        <form action="{{ route('course.update', $course->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div >
                                <label for="course_name" class="form-lable"> Course Name </label>
                                <input type="text" name="course_name" value="{{$course->course_name}}" id="course_name" class="form-control"
                                    placeholder="Enter Course Name ...">
                                @if ($errors->has('course_name'))
                                    <span class="text-danger">{{ $errors->first('course_name') }}</span>
                                @endif
                            </div>
                            <div>
                                <label for="course_description" class="form-lable"> Course Description </label>
                                <input type="text" name="course_description"  value="{{$course->course_description}}" id="course_description"
                                    class="form-control" placeholder="Enter Course Description ...">
                                @if ($errors->has('course_description'))
                                    <span class="text-danger">{{ $errors->first('course_description') }}</span>
                                @endif
                            </div>
                            <div>
                                <label for="course_image_url" class="form-lable"> Course Thumbnail </label>
                                <input type="file" name="course_image_url" id="course_image_url" class="form-control"
                                    placeholder="Upload Course Image ...">
                                @if ($errors->has('course_image_url'))
                                    <span class="text-danger">{{ $errors->first('course_image_url') }}</span>
                                @endif
                            </div>

                            <button class=" btn btn-primary"> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
