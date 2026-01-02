<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Youtube;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\SuccessStory;
use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FrontendController extends Controller
{
    public function index(){
        $youtube = Youtube::take(3)->get(); // Limit to 3 for homepage
        $blogs = Blog::latest()->take(6)->get(); // Latest 6 blogs
        $successStories = SuccessStory::where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('order')
            ->take(3)
            ->get();
        return view('modern-welcome')->with([
            'youtubes'=> $youtube, 
            'blogs'=>$blogs,
            'successStories' => $successStories
        ]);
    }
    function blogposts(){
        $blogs = Blog::all();
         return view('blog.blog-posts')->with('blogs', $blogs);
        }
    function blogdetails(int $id){

       $blog = Blog::find($id);
    
         return view('blog.blog-post-details')->with('blog', $blog);
        }
    function courses(){
         $courses = Course::all();
         $enrolledCourseIds = [];
         
         if (Auth::check()) {
             $enrolledCourseIds = CourseRegistration::where('user_id', Auth::id())
                 ->pluck('course_id')
                 ->toArray();
         }
         
         return view('blog.course', compact('courses', 'enrolledCourseIds'));
        }
    function aboutus(){
         return view('blog.about-us');
        }
   public function contact(){
         return view('blog.contact');
        }
   public function contactus(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        Contact::create($data);
        
        return redirect()->route('contact');
        }

}
