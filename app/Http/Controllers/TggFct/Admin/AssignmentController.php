<?php

namespace App\Http\Controllers\TggFct\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $assignments = Assignment::with(['assignee', 'creator'])->latest()->paginate(10);
        return view('tgg-fct.admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $users = User::all(); // All users who can be assignees
        return view('tgg-fct.admin.assignments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type'   => 'required|string|max:100',
            'assigned_to' => 'required|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        Assignment::create([
            'title'       => $request->title,
            'description' => $request->description,
            'task_type'   => $request->task_type,
            'status'      => 'pending',
            'assigned_to' => $request->assigned_to,
            'created_by'  => Auth::id(),
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('tgg-fct.admin.assignments.index')->with('success', 'Assignment created successfully.');
}

     public function edit(Assignment $assignment)
    {
        $users = User::all();
        return view('tgg-fct.admin.assignments.edit', compact('assignment', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type'   => 'required|string|max:100',
            'status'      => 'required|in:pending,in_progress,completed',
            'assigned_to' => 'required|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        $assignment->update([
            'title'       => $request->title,
            'description' => $request->description,
            'task_type'   => $request->task_type,
            'status'      => $request->status,
            'assigned_to' => $request->assigned_to,
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('tgg-fct.admin.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('tgg-fct.admin.assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}