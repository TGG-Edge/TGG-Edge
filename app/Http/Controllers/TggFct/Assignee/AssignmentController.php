<?php

namespace App\Http\Controllers\TggFct\Assignee;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::where('assigned_to', auth()->id())
            ->latest()
            ->paginate(10);

        return view('tgg-fct.assignee.assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('tgg-fct.assignee.assignments.create');
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

        Assignment::create([
            'title'       => $request->title,
            'description' => $request->description,
            'task_type'   => $request->task_type,
            'status'      => $request->status,
            'due_date'    => $request->due_date,
            'assigned_to' => auth()->id(), // self-assigned
            'created_by'  => auth()->id(), // in this case user created it for themselves
        ]);

        return redirect()->route('tgg-fct.assignee.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function edit(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        return view('tgg-fct.assignee.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
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

        return redirect()->route('tgg-fct.assignee.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    private function authorizeAssignment(Assignment $assignment)
    {
        if ($assignment->assigned_to !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
