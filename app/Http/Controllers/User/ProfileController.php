<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $user = Auth::user();
        return view('user.profile', compact('user'));
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
    public function update(Request $request)
    {
        //
        $user = Auth::user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'nullable|string|max:255',
            'address'         => 'nullable|string',
            'document_type'   => 'nullable|string',
            'document_number' => 'nullable|string',
            'rhm_number'      => 'nullable|string',
            'project'         => 'nullable|string|max:255',
            'image'           => 'nullable|image|max:50',

            // Password validation
            'current_password'          => 'nullable|required_with:new_password',
            'new_password'              => 'nullable|string|min:6|confirmed',
        ]);

        // Update profile info
        $user->update([
            'name'            => $request->name,
            'phone'           => $request->phone,
            'address'         => $request->address,
            'document_type'   => $request->document_type,
            'document_number' => $request->document_number,
            'rhm_number'      => $request->rhm_number,
            'project'         => $request->project,
        ]);

        // Update image
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('photos', 'public');
            $user->save();
        }

        // Update password if needed
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
