@extends('tgg-fct.layouts.app')

@section('title', 'Assignment Details - TGG India')

@section('content')
<div class="container">
    <h2>Create Assignment</h2>

    <form action="{{ route('assignee.assignments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Task Type</label>
            <select name="task_type" class="form-control" required>
                <option value="">-- Select Task Type --</option>
                <option value="verification" {{ old('task_type') == 'verification' ? 'selected' : '' }}>Verification</option>
                <option value="interview" {{ old('task_type') == 'interview' ? 'selected' : '' }}>Interview</option>
                <option value="documentation" {{ old('task_type') == 'documentation' ? 'selected' : '' }}>Documentation</option>
            </select>
            @error('task_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
            @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('assignee.assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection