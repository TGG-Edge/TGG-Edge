<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\User;
use App\Models\UserSecondary;
use App\Services\AIService;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use App\Traits\HandlesAiResearch;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HandlesAiResearch;

    public function index()
    {
        $users = UserSecondary::where('user_role', 2)->latest()->paginate(5);
        return view('user.user-approval', compact('users'));
    }

    public function  newApplication()
    {
        $newApplications = UserSecondary::whereIn('user_role', [2,3,4,5,6])->where('approval','pending')->latest()->paginate(10);
        return view('tgg-india.admin.applications.new-application', compact('newApplications'));
    }

    public function processedApplication()
    {
       $processedApplications = UserSecondary::whereIn('user_role', [2,3,4,5,6])->where('approval','!=','pending')->latest()->paginate(10);
        return view('tgg-india.admin.applications.processed-application', compact('processedApplications'));
    }

    public function userProfile(Request $request, $id)
    {
        $user = UserSecondary::where('id',$id)->first();
        return view('tgg-india.admin.applications.user-profile', compact('user'));
    }

   public function userProfileUpdate(Request $request, $id)
    {
        $user = UserSecondary::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'rhm_number' => 'nullable|string|max:50',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }


    public function updateApproval(Request $request, $id)
    {
        

        $user = UserSecondary::findOrFail($id);
        $message = "";
        $user->approval = $request->action;
        $user->save();

        return back()->with('success', 'User '.$request->action.' status updated.' . $message);
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'project' => 'required|string|max:255',
        ]);

        $user = UserSecondary::findOrFail($id);
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
