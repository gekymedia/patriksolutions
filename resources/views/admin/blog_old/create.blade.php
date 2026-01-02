@extends('admin.components.base')
@section('title', 'Patrik Solutions | Add Create ')

@section('content')

    <form action="{{ route('blog.store') }}" method="post">
        @csrf
        <div class="col-md-4">
            <label for="blog_title" class="form-label"> Blog Title</label>
            <input type="text" name="blog_title" id="blog_title" class="form-control">
            @if($errors->has('blog_title'))
                <span class="text-danger">{{$errors->first('blog_title')}}</span>
            @endif
        </div>
        <div class="col-md-4">
            <label for="blog_content" class="form-label">Blog Content</label>
            <textarea name="blog_content" id="description" class="form-control rich-text"></textarea>
            @if($errors->has('blog_content'))
            <span class="text-danger">{{$errors->first('blog_content')}}</span>
        @endif
        </div>
        <div class="col-md-4">
            <label for="blog_author" class="form-label">Blog Author</label>
            <input type="text" name="blog_author" id="blog_author" class="form-control">
            @if($errors->has('blog_author'))
            <span class="text-danger">{{$errors->first('blog_author')}}</span>
        @endif
        </div>
        <div class="col-md-4">
            <label for="blog_thumbnail" class="form-label">Blog Thumbnail</label>
            <input type="file" name="blog_thumbnail" id="blog_thumbnail" class="form-control">
            @if($errors->has('blog_thumbnail'))
            <span class="text-danger">{{$errors->first('blog_thumbnail')}}</span>
        @endif
        </div>
        <div class="col-md-4">
            <label for="blog_slug" class="form-label">Blog Slug</label>
            <input type="text" name="blog_slug" id="blog_slug" class="form-control">
            @if($errors->has('blog_title'))
            <span class="text-danger">{{$errors->first('blog_slug')}}</span>
        @endif </div>
        <div class="col-md-4">
            <label for="blog_status" class="form-label">Blog Status</label>
            <input type="text" name="blog_status" id="blog_status" class="form-control">
            @if($errors->has('blog_title'))
            <span class="text-danger">{{errors->first('blog_status')}}</span>
        @endif</div>
        <div class="col-md-4">
            <label for="blog_view" class="form-label">Blog View</label>
            <input type="text" name="blog_view" id="blog_view" class="form-control">
            @if($errors->has('blog_view'))
            <span class="text-danger">{{$errors->first('blog_view')}}</span>
        @endif</div>
        <button type="submit">Submit</button>
    </form>
       <!-- Include the CKEditor 5 script -->
       <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
       <script>
           ClassicEditor
               .create(document.querySelector('#description'))
               .catch(error => {
                   console.error(error);
               });
       </script>
@endsection
