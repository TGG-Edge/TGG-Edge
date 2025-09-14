<?php

namespace App\Http\Controllers\TggFct\Researcher;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCollaboration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = Project::where('researcher_id', auth()->id())->first();
        if($project && $project->status == 'freezed'){
            return response('Your project is freezed, please contact the admin.');
        }
        $volunteer_applications = ProjectCollaboration::where('status','pending')->latest()->get();
        $collaborated_projects = ProjectCollaboration::whereHas('project',function($q){
            return $q->where('researcher_id', auth()->id());
        })->whereIn('status', ['accepted','running'])->where('status', '!=', 'freezed')->latest()->get();
        return view('tgg-fct.researcher.dashboard', compact('project','volunteer_applications','collaborated_projects'));
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
