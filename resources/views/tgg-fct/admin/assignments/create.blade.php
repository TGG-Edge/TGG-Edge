
@extends('tgg-fct.layouts.app')

@section('title', 'Create Trainer Project - TGG India')

@section('content')
<div class="container">
    <h1>Create Assignment</h1>
    <form action="{{ route('tgg-india.admin.assignments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Task Type</label>
            <input type="text" name="task_type" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign To</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Unassigned --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
