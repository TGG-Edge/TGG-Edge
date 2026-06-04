<?php

namespace App\Http\Controllers\TggIndia\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSecondary;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = AssignmentSecondary::query()
        ->where('assigned_to', auth('web2')->id())
        ->latest();

        // ✅ If 'parent_id' is passed, filter by it
        if ($request->has('parent_id') && !empty($request->parent_id)) {
            $query->where('parent_id', $request->parent_id);
        } else {
            // ✅ Otherwise, show only root (top-level) assignments
            $query->whereNull('parent_id');
        }

        $assignments = $query->paginate(10);

        return view('tgg-india.freelancer.assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('tgg-india.freelancer.assignments.create');
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
            'status'      => 'pending',
            'assigned_to' => Auth('web2')->id(),
            'created_by'  => Auth('web2')->id(),
            'due_date'    => $request->due_date,
            'price'    => $request->price,
            'parent_id'   => $request->parent_id ?? null,
        ]);

        if ($request->filled('parent_id')) {
            return redirect()
                ->route('tgg-india.freelancer.assignments.index', ['parent_id' => $request->parent_id])
                ->with('success', 'Sub-assignment created successfully.');
        }

        return redirect()->route('tgg-india.freelancer.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function edit(AssignmentSecondary $assignment)
    {
        $this->authorizeAssignment($assignment);

        return view('tgg-india.freelancer.assignments.edit', compact('assignment'));
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
        if ( $assignment->parent_id != null)  {
            return redirect()
                ->route('tgg-india.freelancer.assignments.index', ['parent_id' => $assignment->parent_id])
                ->with('success', 'Sub-assignment updated successfully.');
        }

        return redirect()->route('tgg-india.freelancer.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    private function authorizeAssignment(AssignmentSecondary $assignment)
    {
        if ($assignment->assigned_to !== auth('web2')->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
