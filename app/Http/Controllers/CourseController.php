<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        // $data = ['courses'=> $courses,];
        return view('course.index')->with(['courses'=> $courses,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_name'=>['required', 'string'],
            'course_description'=>['required', 'string'],
            'course_image_url'=>['required', 'mimes:png,jpg,jpeg'],
        ]);
        if ($request->hasFile('course_image_url')) {
            $data['course_image_url'] = $request->file('course_image_url')->store('course_image_url', 'public');
        }
        $course = Course::create($data);

        if(!$course){
            return redirect()->back()-with('error', 'not success');         
        }
        return redirect()->route('course.create')->with('success', 'Course Successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $lessons = Lesson::where('course_id', $course);
        return view('course.show', compact('course', 'lessons')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // $course = Course::find($course);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
        $data = $request->validate([
            'course_name'=>['required', 'string'],
            'course_description'=>['required', 'string'],
            'course_image_url'=>['nullable', 'mimes:png,jpg,jpeg'],
        ]);
        if ($request->hasFile('course_image_url')) {
            $data['course_image_url'] = $request->file('course_image_url')->store('course_image_url', 'public');
        }
        $course->update($data);
        if(!$course){
            return redirect()->back()-with('error', 'not success');         
        }
        return redirect()->route('course.index')->with('success', 'Course Updated Successfully');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');

    }
}
