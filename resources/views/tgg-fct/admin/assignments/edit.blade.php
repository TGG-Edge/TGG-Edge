

@extends('tgg-fct.layouts.app')

@section('title', 'Edit Trainer Project - TGG fct')


@section('content')
<div class="container">
    <h1>Edit Assignment</h1>
    <form action="{{ route('tgg-fct.admin.assignments.update', $assignment) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $assignment->title }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $assignment->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Task Type</label>
            <input type="text" name="task_type" value="{{ $assignment->task_type }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending" @if($assignment->status=='pending') selected @endif>Pending</option>
                <option value="in_progress" @if($assignment->status=='in_progress') selected @endif>In Progress</option>
                <option value="completed" @if($assignment->status=='completed') selected @endif>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign To</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Unassigned --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($assignment->assigned_to == $user->id) selected @endif>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" value="{{ $assignment->due_date }}" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
