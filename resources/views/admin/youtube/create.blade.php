<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Youtube Post') }}
        </h2>
    </x-slot>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button " class="close" data-dismiss='alert'> x
        </button>
        <strong>{{ $message }}</strong>
    </div>
@endif
    <div class="container py-12">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('youtube.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class=" col-md-12">
                                <label for="title" class="form-label"> Youtube Video Title</label>
                                <input type="text" name="title" id="title" class="form-control">
                                @if($errors->has('title'))
                                    <span class="text-danger">{{$errors->first('title')}}</span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <label for="url" class="form-label">Youtube Embedded Link</label>
                                <textarea name="url" id="description" class="form-control rich-text" placeholder="Copy youtube Iframe link and change the width to 100%"></textarea>
                                @if($errors->has('url'))
                                <span class="text-danger">{{$errors->first('url')}}</span>
                            @endif
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the CKEditor 5 script -->
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script> --}}
</x-app-layout>
