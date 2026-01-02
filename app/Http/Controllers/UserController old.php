<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->select('id','name','role','email', )->get();
        // $data = ;
        return view('admin.user.index')->with(['users'=> $users,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
                return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10'],
            'photo' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required',],
        ]);

        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'phone' => $request->phone,
            'photo' => $request->photo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user){
            return redirect()->back()->with('error' , 'not success');
           }
           return redirect()->route('users.create')->with('success', 'save Successfully');
    
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
