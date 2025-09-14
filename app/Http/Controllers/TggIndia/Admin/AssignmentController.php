<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSecondary;
use App\Models\User;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $assignments = AssignmentSecondary::with(['member', 'creator'])->latest()->paginate(10);
        return view('tgg-india.admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $users = UserSecondary::where('user_role',3)->get(); // All users who can be assignees
        return view('tgg-india.admin.assignments.create', compact('users'));
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

        AssignmentSecondary::create([
            'title'       => $request->title,
            'description' => $request->description,
            'task_type'   => $request->task_type,
            'status'      => 'pending',
            'assigned_to' => $request->assigned_to,
            'created_by'  => Auth('web2')->id(),
            'due_date'    => $request->due_date,
            'price'    => $request->price,
        ]);

        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment created successfully.');
}

     public function edit(AssignmentSecondary $assignment)
    {
        $users = UserSecondary::where('user_role',3)->get();
        return view('tgg-india.admin.assignments.edit', compact('assignment', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssignmentSecondary $assignment)
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
            'price'    => $request->price,
        ]);

        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignmentSecondary $assignment)
    {
        $assignment->delete();
        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}