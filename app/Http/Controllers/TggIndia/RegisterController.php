<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSecondary;
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
        if($user_type == 'researcher'){
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
               'email' => 'required|email|unique:mysql2.users,email',
               'address' => 'required|string',
               'rhm_number' => 'required'
           ]);
        }



        if($user_type == 'trainer'){
            $user_type = 2;
        }elseif($user_type == 'members'){
            $user_type = 3;
        }elseif($user_type == 'admin'){
            $user_type = 1;
        }
        elseif($user_type == 'rhm-club'){
            $user_type = 4;
        }
        elseif($user_type == 'nomad-community'){
            $user_type = 5;
        }else{
            $user_type = 6;
        }
        // Store user
        UserSecondary::create([
            'name' => $request->name,
            'age' => $request->age,
            'project' => $request->project ?? null,
            'phone' => $request->number,
            'email' => $request->email,
            'address' => $request->address,
            'user_role' => $user_type,
            'rhm_number' => $request->rhm_number,
            'password' => Hash::make('default-password'), // change as needed
        ]);

        return redirect()->route('tgg-india.login')->with('success', 'Registration successful!');

    }

    /**
     * Display the specified resource.
     */
    public function show($user_type)
    {
        $user_types = collect(UserSecondary::$user_types);

        // Find the ID where the name matches (case-insensitive)
        $foundKey = $user_types
            ->search(fn ($info) => strcasecmp($info['key'], $user_type) === 0);

        if ($foundKey === false) {
            abort(404);
        }

        return view('tgg-india.register',compact('user_type', 'user_types'));
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
