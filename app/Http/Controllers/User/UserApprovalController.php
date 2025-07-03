<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HandlesAiResearch;


class UserApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HandlesAiResearch;

    public function index()
    {
        $users = User::where('user_role', 4)->get();
        return view('user.user-approval', compact('users'));
    }

    public function updateApproval(Request $request, $id)
    {
        

        $request->validate([
            'approval' => 'required|in:pending,accepted,rejected',
        ]);

        $user = User::findOrFail($id);
        $user->approval = $request->approval;
        $user->save();
        

        if($user->approval == 'accepted'){
            $result = $this->generateResearchForUser($user); // ✅ Call from Trait
            if (!$result['success']) {
                return back()->with('error', 'User approved, but AI generation failed: ' . ($result['error'] ?? 'Unknown error'));
            }
        }
        return back()->with('success', 'User approval status updated.');
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'project' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->project = $request->project;
        $user->save();

        return back()->with('success', 'Project details updated.');
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
