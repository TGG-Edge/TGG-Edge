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
   public function index(Request $request)
    {
         $query = AssignmentSecondary::query()
        ->latest();

        // ✅ If 'parent_id' is passed, filter by it
        if ($request->has('parent_id') && !empty($request->parent_id)) {
            $query->where('parent_id', $request->parent_id);
        } else {
            // ✅ Otherwise, show only root (top-level) assignments
            $query->whereNull('parent_id');
        }

        $assignments = $query->paginate(10);
        return view('tgg-india.admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $users = UserSecondary::whereIn('user_role',[2,3,7,8,6])->get(); // All users who can be assignees
        return view('tgg-india.admin.assignments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type'   => 'required|string|max:100',
            'assigned_to' => 'required',
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
            'parent_id'   => $request->parent_id ?? null,
        ]);

        if ($request->filled('parent_id')) {
            return redirect()
                ->route('tgg-india.admin.assignments.index', ['parent_id' => $request->parent_id])
                ->with('success', 'Sub-assignment created successfully.');
        }

        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment created successfully.');
}

     public function edit(AssignmentSecondary $assignment)
    {
        $users = UserSecondary::whereIn('user_role',[2,3,7,8,6])->get();
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
            'assigned_to' => 'required',
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

         if ( $assignment->parent_id != null)  {
            return redirect()
                ->route('tgg-india.admin.assignments.index', ['parent_id' => $assignment->parent_id])
                ->with('success', 'Sub-assignment updated successfully.');
        }

        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignmentSecondary $assignment)
    {
        AssignmentSecondary::where('parent_id', $assignment->id)->delete(); 
        $assignment->delete();
        return redirect()->route('tgg-india.admin.assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}