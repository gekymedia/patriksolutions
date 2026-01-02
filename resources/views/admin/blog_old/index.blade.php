@extends('admin.components.base')
@section('title', 'Patrik Solutions | Blog ')
@section ('content-action')
<a href="{{ route('blog.create') }}" class="btn btn-info">Add New</a>
@endsection
@section ('content')

<div class="card-body">
    <div class="table-responsive-lg">
        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Author.</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Status</th>
                <th>View</th>
            </tr>    
            </thead>
            <tbody>
                @foreach($blogs as $blog)
            <tr>
                <th>
                    {{$blog->id}}
                </th>
                <td>
                    {{$blog->blog_title}}
                </td>
                <td>
                    {{$blog->blog_author}}
                </td>
                <td>
                    {!!$blog->blog_content!!}
                </td>
                <td>
                    <img src="{{ $blog->blog_thumbnail }}" alt="Blog Thumbnail">
                    
                </td>
                <td>
                    {{$blog->blog_status}}
                </td>
                <td>
                    {{$blog->blog_view}}
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection