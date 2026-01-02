<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;

class LessonController extends Controller
{
   
   /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $lesson = Lesson::where('course_id', $course);
        return view('lesson.index', compact( 'lesson'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {

        return view('lesson.create', compact( 'course'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses, course_id'],
            'lesson_title'=>['required', 'string'],
            'lesson_description'=>['required', 'string'],
            'lesson_video'=>['nullable', ],
        ]);
        // $data['course_id']= $course;
        if ($request->hasFile('lesson_video')) {
            $data['lesson_video'] = $request->file('lesson_video')->store('lesson_video', 'public');
        }
        $lesson = Lesson::create($data);

        if(!$lesson){
            return redirect()->back()-with('error', 'not success');         
        }
        return redirect()->route('course.index', )->with('success', 'Lesson Successfully created');

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
