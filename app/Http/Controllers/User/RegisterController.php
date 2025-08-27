<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $user_type)
    {
        //
        if($user_type == 'researcher' || $user_type == 'freelance' ){
            $request->validate([
               'name' => 'required|string',
               'age' => 'required|integer',
               'project' => 'required|string',
               'number' => 'required|string',
               'email' => 'required|email|unique:users,email',
               'address' => 'required|string',
               'rhm_number' => 'required'
           ]);
        }else{
           $request->validate([
               'name' => 'required|string',
               'age' => 'required|integer',
               'number' => 'required|string',
               'email' => 'required|email|unique:users,email',
               'address' => 'required|string',
               'rhm_number' => 'required'
           ]);
        }



        if($user_type == 'researcher'){
            $user_type = 2;
        }elseif($user_type == 'volunteer'){
            $user_type = 3;
        }elseif($user_type == 'admin'){
            $user_type = 1;
        }elseif($user_type == 'assignee'){
            $user_type = 5;
        }
        else{
            $user_type = 4;
        }
        // Store user
        User::create([
            'name' => $request->name,
            'age' => $request->age,
            'project' => $request->project ?? null,
            'phone' => $request->number,
            'email' => $request->email,
            'address' => $request->address,
            'user_type' => 1,
            'user_role' => $user_type,
            'rhm_number' => $request->rhm_number,
            'research_assistance' => $request->has('research_assistance'),
            // 'image' => $request->file('photo')->store('photos', 'public'),
            'password' => Hash::make('default-password'), // change as needed
        ]);

        return redirect()->route('user.login')->with('success', 'Registration successful!');

    }

    /**
     * Display the specified resource.
     */
    public function show($user_type)
    {
        $userTypes = [
            1 => 'RHM Club',
            2 => 'NCRH',
            3 => 'Freelance'
        ];

        $userTypes = [
            'researcher' => 'RHM Club',
            'volunteer' => 'NCRH',
            'freelance' => 'Freelance',
            'assignee' => 'Assignee'
        ];


        if (!array_key_exists($user_type, $userTypes)) {
            abort(404);
        }

        return view('user.register',compact('user_type', 'userTypes'));
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
