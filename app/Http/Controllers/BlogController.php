<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Events\BlogPublished;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        $data = ['blogs' => $blogs,];
        return view('admin.blog.index')->with(['blogs' => $blogs,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'blog_title' => ['required', 'string'],
            'blog_content' => ['nullable'],
            'blog_author' => ['required', 'string'],
            'blog_thumbnail' => ['required', 'mimes:png,jpg,jpeg,gif'],
            'blog_slug' => ['required', 'string'],
            'blog_status' => ['required', 'string'],
            'blog_view'  => ['required', 'integer'],
        ]);
        if ($request->hasFile('blog_thumbnail')) {
            $data['blog_thumbnail'] = $request->file('blog_thumbnail')->store('blog_thumbnail', 'public');
        }

        $blog = Blog::create($data);
        if (!$blog) {
            return redirect()->back() -> with('error', 'not success');
        }

        // Broadcast notification to subscribers if blog is published
        if ($blog->blog_status === 'published' || $blog->blog_status === 'Published') {
            event(new BlogPublished($blog));
        }

        return redirect()->route('blogs.create')->with('success', 'Blog Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        // $blog = Blog::find($blog);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'blog_title' => ['required', 'string'],
            'blog_content' => ['nullable'],
            'blog_author' => ['required', 'string'],
            'blog_thumbnail' => ['nullable', 'mimes:png,jpg,jpeg,gif'],
            'blog_slug' => ['required', 'string'],
            'blog_status' => ['required', 'string'],
            'blog_view'  => ['required', 'integer'],
        ]);
        if ($request->hasFile('blog_thumbnail')) {
            $data['blog_thumbnail'] = $request->file('blog_thumbnail')->store('blog_thumbnail', 'public');
        }

        $blogupdate = $blog->update($data);
        if (!$blogupdate) {
            return redirect()->back() - with('error', 'Not successful');
        }

        // Broadcast notification if blog status changed to published
        if (($blog->blog_status === 'published' || $blog->blog_status === 'Published') && $blog->wasChanged('blog_status')) {
            event(new BlogPublished($blog->fresh()));
        }

        return redirect()->route('blogs.create')->with('success', 'Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog Successfully Deleted');
    }
}
