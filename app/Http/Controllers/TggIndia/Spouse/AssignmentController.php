<?php

namespace App\Http\Controllers\TggIndia\Spouse;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSecondary;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = AssignmentSecondary::where('assigned_to', auth('web2')->id())
            ->latest()
            ->paginate(10);

        return view('tgg-india.spouse.assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('tgg-india.spouse.assignments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type'   => 'required|string',
            'status'      => 'required|string|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
        ]);

        AssignmentSecondary::create([
            'title'       => $request->title,
            'description' => $request->description,
            'task_type'   => $request->task_type,
            'status'      => $request->status,
            'due_date'    => $request->due_date,
            'assigned_to' => auth('web2')->id(), // self-assigned
            'created_by'  => auth('web2')->id(), // in this case user created it for themselves
        ]);

        return redirect()->route('tgg-india.spouse.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function edit(AssignmentSecondary $assignment)
    {
        $this->authorizeAssignment($assignment);

        return view('tgg-india.spouse.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, AssignmentSecondary $assignment)
    {
        $this->authorizeAssignment($assignment);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type'   => 'required|string',
            'status'      => 'required|string|in:pending,in_progress,completed',
            'due_date'    => 'nullable|date',
        ]);

        $assignment->update($request->all());

        return redirect()->route('tgg-india.spouse.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    private function authorizeAssignment(AssignmentSecondary $assignment)
    {
        if ($assignment->assigned_to !== auth('web2')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
