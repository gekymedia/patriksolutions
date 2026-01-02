<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Youtube;

class YoutubeController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $youtube = Youtube::all();
        return view('admin.youtube.index')->with(['youtubes'=> $youtube,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.youtube.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>['required', 'string'],
            'url'=>['required', 'string'],
            
        ]);
       
        $youtube = Youtube::create($data);
        if(!$youtube){
            return redirect()->back()-with('error', 'not success');         
        }
        return redirect()->route('youtube.create')->with('success', 'Youtube Created Successfully');


        
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
    public function edit(Youtube $youtube)
    {
        // $blog = Blog::find($blog);
        return view('admin.youtube.edit', compact('youtube'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Youtube $youtube)
    {
        $data = $request->validate([
            'title'=>['required', 'string'],
            'url'=>['required', 'string'],
            
        ]);
       
        $youtube = Youtube::update($data);
        if(!$youtube){
            return redirect()->back()-with('error', 'not success');         
        }
        return redirect()->route('youtube.create')->with('success', 'Youtube Created Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Youtube $youtube)
    {
        $youtube->delete();
        return redirect()->route('youtube.index')->with('success', 'Youtube Successfully Deleted');
    }
}
