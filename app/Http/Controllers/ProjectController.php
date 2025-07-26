<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCollaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
        $request->validate([
            'title' => 'required|string|max:30',
            'description' => 'nullable|string|max:300',
        ]);

        $researcherId = Auth::id();

        // Check if a project already exists for this researcher
        $project = Project::where('researcher_id', $researcherId)->first();

        if ($project) {
            // Update the existing project
            $project->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'started',
            ]);

            return redirect()->back()->with('success', 'Project updated successfully!');
        } else {
            // Create a new project
            Project::create([
                'title' => $request->title,
                'description' => $request->description,
                'researcher_id' => $researcherId,
                'status' => 'started',
            ]);

            return redirect()->back()->with('success', 'Project created successfully!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function progressUpdate(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'document_url' => 'nullable|url',
        ]);

        $project = Project::findOrFail($validated['project_id']);
        $project->update([
            'progress_percentage' => $validated['progress_percentage'],
            'document_url' => $validated['document_url'],
        ]);

        return redirect()->back()->with('success', 'Project progress updated successfully!');
    }

    public function researcherProject()
    {
        $researchProjects = Project::latest()->paginate(10);
        return view('user.projects.researcher-project',compact('researchProjects'));
    }

    public function volunteerProject()
    {
        $volunteerProjects = ProjectCollaboration::latest()->paginate(10);
        return view('user.projects.volunteer-project' , compact('volunteerProjects'));
    }

    public function researcherFreezeProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $newStatus = $project->status === 'freezed' ? 'started' : 'freezed';
        $project->update(['status' => $newStatus]);

        $message = $newStatus === 'freezed' ? 'Researcher project has been frozen successfully!' : 'Researcher project has been unfrozen successfully!';
        return redirect()->back()->with('success', $message);
    }

    public function volunteerFreezeProject(Request $request, $id)
    {

        $projectCollaboration = ProjectCollaboration::findOrFail($id);

        $newStatus = $projectCollaboration->status === 'freezed' ? 'accepted' : 'freezed';
        $projectCollaboration->update(['status' => $newStatus]);

        $message = $newStatus === 'freezed' ? 'Volunteer project collaboration has been frozen successfully!' : 'Volunteer project collaboration has been unfrozen successfully!';
        return redirect()->back()->with('success', $message);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
