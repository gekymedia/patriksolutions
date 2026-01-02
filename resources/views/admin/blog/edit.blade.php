<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Blog Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-4 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('blogs.update', $blog) }}" method="post" enctype="multipart/form-data">
                   @method('PUT')
                    @csrf
                    <div class=" col-md-12">
                        <label for="blog_title" class="form-label"> Blog Title</label>
                        <input type="text" name="blog_title" value="{{$blog->blog_title}}" id="blog_title" class="form-control">
                        @if($errors->has('blog_title'))
                            <span class="text-danger">{{$errors->first('blog_title')}}</span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label for="blog_content" class="form-label">Blog Content</label>
                        <textarea name="blog_content" id="description" value="{{$blog->blog_content}}"  class="form-control rich-text"></textarea>
                        @if($errors->has('blog_content'))
                        <span class="text-danger">{{$errors->first('blog_content')}}</span>
                    @endif
                    </div>
                    <div class="col-md-12">
                        <label for="blog_author" class="form-label">Blog Author</label>
                        <input type="text" name="blog_author" id="blog_author"  value="{{$blog->blog_author}}" class="form-control">
                        @if($errors->has('blog_author'))
                        <span class="text-danger">{{$errors->first('blog_author')}}</span>
                    @endif
                    </div>
                    <div class="col-md-12">
                        <label for="blog_thumbnail" class="form-label">Blog Thumbnail</label>
                        <input type="file" name="blog_thumbnail" id="blog_thumbnail" class="form-control">
                        @if($errors->has('blog_thumbnail'))
                        <span class="text-danger">{{$errors->first('blog_thumbnail')}}</span>
                    @endif
                    </div>
                    <div class="col-md-12">
                        <label for="blog_slug" class="form-label">Blog Slug</label>
                        <input type="text" name="blog_slug" id="blog_slug"   value="{{$blog->blog_slug}}" class="form-control">
                        @if($errors->has('blog_title'))
                        <span class="text-danger">{{$errors->first('blog_slug')}}</span>
                    @endif </div>
                    <div class="col-md-12">
                        <label for="blog_status" class="form-label">Blog Status</label>
                        <select name="blog_status" id="blog_status" class="form-control">
                            <option value="live">Live</option>
                            <option value="draft">Draft</option>
                        </select>
                        @if($errors->has('blog_status'))
                        <span class="text-danger">{{$errors->first('blog_status')}}</span>
                    @endif</div>
                    <div class="col-md-12">
                        <label for="blog_view" class="form-label">Blog View</label>
                        <input type="number" name="blog_view" id="blog_view" value="{{$blog->blog_view}}"  class="form-control">
                        @if($errors->has('blog_view'))
                        <span class="text-danger">{{$errors->first('blog_view')}}</span>
                    @endif</div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
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
