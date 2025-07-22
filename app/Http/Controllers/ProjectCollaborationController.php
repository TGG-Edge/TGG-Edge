<?php

namespace App\Http\Controllers;

use App\Models\ProjectCollaboration;
use Illuminate\Http\Request;

class ProjectCollaborationController extends Controller
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
    public function show(ProjectCollaboration $projectCollaboration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCollaboration $projectCollaboration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function apply(Request $request)
    {
        //
        $request->validate([
        'project_id' => 'required|exists:projects,id',
        ]);
        $projectId = $request->project_id;
        $volunteerId = auth()->id();

        $hasPendingRequest = ProjectCollaboration::where('volunteer_id', $volunteerId)
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return back()->with('error', 'You already have a pending project request. Wait for approval of accept or reject before applying to another project.');
        }

        $alreadyAppliedToThis = ProjectCollaboration::where('project_id', $projectId)
            ->where('volunteer_id', $volunteerId)
            ->exists();

        if ($alreadyAppliedToThis) {
            return back()->with('error', 'You have already applied to this project.');
        }

        ProjectCollaboration::create([
            'project_id' => $projectId,
            'volunteer_id' => $volunteerId,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Request sent to researcher successfully!');
    }


    public function progressUpdate(Request $request)
    {
        //
        $request->validate([
        'progress_percentage' => 'required|integer|min:0|max:100',
        ]);
        $collaboratedProjectId = $request->input('collaborated_project_id');
        $collaboratedProject = ProjectCollaboration::findOrFail($collaboratedProjectId);
        $collaboratedProject->update([
        'progress_percentage' => $request->progress_percentage,
        ]);

        return back()->with('success', 'Collaborated Project progress updated!');
    }

    public function researcherProgressUpdate(Request $request)
    {
        //
        $request->validate([
        'researcher_progress_percentage' => 'required|integer|min:0|max:100',
        ]);
        $collaboratedProjectId = $request->input('collaborated_project_id');
        $collaboratedProject = ProjectCollaboration::findOrFail($collaboratedProjectId);
        $collaboratedProject->update([
            'researcher_progress_percentage' => $request->researcher_progress_percentage,
            'document_url' => $request->document_url ?? null,        ]);

        

        return back()->with('success', 'Collaborated Project progress updated!');
    }

    public function applicationAcceptReject(Request $request)
    {
        //
         $request->validate([
            'project_collaboration_id' => 'required|exists:project_collaborations,id',
            'action' => 'required|in:accept,reject',
        ]);

        $project_collaboration = ProjectCollaboration::find($request->project_collaboration_id);

        if ($request->action === 'accept') {
            $project_collaboration->status = 'accepted';
        } else {
            $project_collaboration->status = 'rejected';
        }

        $project_collaboration->save();

        return back()->with('success', 'Application ' . $project_collaboration->status . ' successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCollaboration $projectCollaboration)
    {
        //
    }
}
