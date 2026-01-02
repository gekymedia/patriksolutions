<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = Auth::user();
        if ($user->role == "Admin") { // Admin
            $courseregistration = CourseRegistration::all();
        } else {
            $courseregistration = CourseRegistration::where('user_id', $user->id)->get();
        }
        
        return view('course_registration.index', compact('courseregistration'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $courseregistration = CourseRegistration::all();
        return view('course_registration.create', compact('courseregistration'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $userId = Auth::id();
        $courseId = $request->course_id;

        // Check if user is already enrolled
        $existingEnrollment = CourseRegistration::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses')->with('error', 'You are already enrolled in this course.');
        }

        $data = [
            'course_id' => $courseId,
            'payment_status' => 'paid',
            'user_id' => $userId,
        ];

        CourseRegistration::create($data);

        return redirect()->route('courses')->with('success', 'You have successfully enrolled in this course.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseRegistration $courseregistration)
    {
        CourseRegistration::find($courseregistration)->first();
        return view('course_registration.show' , compact('courseregistration'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseRegistration $courseregistration)
    {
        $courseregistration = CourseRegistration::all();
        return view('course_registration.edit', compact('courseregistration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseRegistration $courseregistration)
    {
        $data= $request->validate([
            'course_id'=> 'required|exists:courses,id', 
            'user_id'=> 'required|exists:users,id', 
            'payment_status'=> 'required|string', 

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseRegistration $courseregistration)
    {
        //
        $courseregistration->delete();
        return redirect()->route('course_registration.index')->with('success', 'Room deleted successfully.');


    }

    public function mycourses(){
        $user = Auth::user();
        $courses= Course::all();
        $mycourses= CourseRegistration::where('user_id',$user->id )->get();
        return view('course_registration.mycourses', compact('courses', 'mycourses'));
    }
}
