<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCollaboration;
use App\Models\User;
use Illuminate\Http\Request;

class VolunteerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $users = User::where('user_role',2)->get();
        $volunteerId = auth()->id();

        // 1. Projects that do NOT have the current volunteer
        $projects = Project::whereDoesntHave('collaborations', function ($q) use ($volunteerId) {
            $q->where('volunteer_id', $volunteerId)->where('status', '!=', 'freezed');
        })->where('status', '!=', 'freezed')->latest()->get();

        // 2. Latest pending collaboration (if any)
        $selected_project = ProjectCollaboration::where('volunteer_id', $volunteerId)
            ->whereIn('status', ['running','pending'])->where('status', '!=', 'freezed')
            ->latest()
            ->first();

        // 3. Projects where the current user is collaborating
        $collaborated_projects = Project::with('collaborations')
            ->whereHas('collaborations', function ($q) use ($volunteerId) {
            $q->where('volunteer_id', $volunteerId)->whereIn('status', ['accepted','rejected'])->where('status', '!=', 'freezed');
        })->where('status', '!=', 'freezed')->latest()->get();

      


        return view('user.volunteer-dashboard',compact('users','projects','selected_project','collaborated_projects'));
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
