<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ProjectSecondary;
use App\Models\ProjectSecondaryUser;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
    $projects = ProjectSecondary::query();

    if (auth('web2')->user()->id != 1) {

        $userId = auth('web2')->user()->id;

        $projects->where(function ($query) use ($userId) {
            $query->where('created_by', $userId)
                    ->orWhereHas('members', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
        });
    }

    $projects = $projects->with(['business', 'owner', 'members'])
        ->latest()
        ->paginate(10);

    return view('tgg-india.projects.index', compact('projects'));
    }

    public function create()
    {
        $businesses = Business::query();
        if(auth('web2')->user()->id != 1){
            $businesses =  $businesses->where('created_by', auth('web2')->user()->id);
        }

        $businesses =  $businesses->where('status', 'active')->get();   

        $facilitators = UserSecondary::where('user_role', 8)->get();

        $freelancers = UserSecondary::where('user_role', 6)->get();

        return view('tgg-india.projects.create', compact(
            'businesses',
            'facilitators',
            'freelancers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'nullable',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'status' => 'required',
            'facilitators' => 'nullable|array',
            'freelancers' => 'nullable|array',
        ]);

        $project = ProjectSecondary::create([
            'business_id' => $request->business_id,
            'title' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'status' => $request->status,
            'created_by' => Auth('web2')->user()->id,
            'owner_id' => Auth('web2')->user()->id,
        ]);

        // Facilitators
        if ($request->facilitators) {

            foreach ($request->facilitators as $userId) {

                ProjectSecondaryUser::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'role_type' => 'facilitator',
                    'assigned_by' => Auth('web2')->user()->id,
                ]);
            }
        }

        // Freelancers
        if ($request->freelancers) {

            foreach ($request->freelancers as $userId) {

                ProjectSecondaryUser::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'role_type' => 'freelancer',
                    'assigned_by' => Auth('web2')->user()->id,
                ]);
            }
        }

        return redirect()
            ->route('tgg-india.projects.index',['role' => auth('web2')->user()->role_key])
            ->with('success', 'Project created successfully.');
    }

    public function show($role,ProjectSecondary $project)
    {
        $project->load([
            'business',
            'owner',
            'members.user'
        ]);

        return view('tgg-india.projects.show', compact('project'));
    }

    public function edit($role,ProjectSecondary $project)
    {
        $businesses = Business::query();
        if(auth('web2')->user()->id != 1){
            $businesses =  $businesses->where('created_by', auth('web2')->user()->id);
        }

        $businesses =  $businesses->where('status', 'active')->get();   

        $facilitators = UserSecondary::where('user_role', 8)->get();

        $freelancers = UserSecondary::where('user_role', 6)->get();

        $selectedFacilitators = ProjectSecondaryUser::where('project_id', $project->id)
            ->pluck('user_id')
            ->toArray();

        $selectedFreelancers = ProjectSecondaryUser::where('project_id', $project->id)  
            ->pluck('user_id')
            ->toArray();

        return view('tgg-india.projects.edit', compact(
            'project',
            'businesses',
            'facilitators',
            'freelancers',
            'selectedFacilitators',
            'selectedFreelancers'
        ));
    }

    public function update($role,Request $request, ProjectSecondary $project)
    {
        $request->validate([
            'business_id' => 'nullable',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'amount' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $project->update([
            'business_id' => $request->business_id,
            'title' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        // Remove old members
        ProjectSecondaryUser::where('project_id', $project->id)->delete();

        // Add facilitators
        if ($request->facilitators) {

            foreach ($request->facilitators as $userId) {

                ProjectSecondaryUser::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'role_type' => 'facilitator',
                    'assigned_by' => Auth('web2')->user()->id,
                ]);
            }
        }

        // Add freelancers
        if ($request->freelancers) {

            foreach ($request->freelancers as $userId) {

                ProjectSecondaryUser::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'role_type' => 'freelancer',
                    'assigned_by' => Auth('web2')->user()->id,
                ]);
            }
        }

        return redirect()
            ->route('tgg-india.projects.index',['role' => auth('web2')->user()->role_key])
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($role,ProjectSecondary $project)
    {
        ProjectSecondaryUser::where('project_id', $project->id)->delete();

        $project->delete();

        return redirect()
            ->route('tgg-india.projects.index',['role' => auth('web2')->user()->role_key])
            ->with('success', 'Project deleted successfully.');
    }
}
