<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Youtube;
use App\Models\Contact;
use App\Models\Blog;
use App\Models\Course;
use App\Models\User;
class AdminController extends Controller
{
    public function dashboard(){
        $courses = Course::all();
        $blogs = Blog::all();
        $users = User::all();
        $youtube = Youtube::all();
        // $data = ;
        return view ('admin.dashboard')->with(['courses'=> $courses,'blogs'=> $blogs, 'users'=> $users ]);
    }

    public function youtubeindex(){
        $youtube = Youtube::all();
    }
    public function contacts(){
        $contact = Contact::all();
        return view('admin.dashboard');
    }

    public function youtubecreate(Request $request){
        $request->validate([
            'url'=> 'required',
            'title'=> 'required',
        ]);
        $youtube = Youtube::create($request->all());
        if(!$youtube){
            return redirect()->back()->with('error','Youtube link added succcesffuly');
        }
    }
    
}
