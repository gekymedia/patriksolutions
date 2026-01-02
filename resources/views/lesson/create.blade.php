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

                        <form action="{{ route('lesson.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                
                                <label for="lesson_title" class="form-lable"> Lesson Title </label>
                                <input type="text" name="lesson_title" id="lesson_title" class="form-control"
                                    placeholder="Enter Lesson Title ...">
                                @if ($errors->has('lesson_title'))
                                    <span class="text-danger">{{ $errors->first('lesson_title') }}</span>
                                @endif
                            </div>
                            <div>

                                <label for="description" class="form-label">Description</label>
                                <textarea name="lesson_description" id="description" class="form-control rich-text"></textarea>

                                @if ($errors->has('lesson_description'))
                                    <span class="text-danger">{{ $errors->first('lesson_description') }}</span>
                                @endif
                            </div>
                            <div>
                                <label for="lesson_video" class="form-lable"> Lesson Videon </label>
                                <input type="file" name="lesson_video" id="lesson_video" class="form-control"
                                    placeholder="Upload Lesson Video Image ...">
                                @if ($errors->has('lesson_video'))
                                    <span class="text-danger">{{ $errors->first('lesson_video') }}</span>
                                @endif
                            </div>

                            <button class=" btn btn-primary"> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include the CKEditor 5 script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
