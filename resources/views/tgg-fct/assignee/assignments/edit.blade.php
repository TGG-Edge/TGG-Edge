@extends('tgg-fct.layouts.app')

@section('title', 'Assignment Details | TGG Edge | TGG fct')


@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Assignment</h4>

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-fct.assignee.assignments.update', $assignment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" disabled name="title" class="form-control" value="{{ old('title', $assignment->title) }}" required>
                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Description</label>
                <textarea disabled name="description" class="form-control js-ckeditor" rows="5">{{ old('description', $assignment->description) }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Type Task</label>
                <select disabled name="task_type" class="form-control" required>
                    <option value="">-- Select Task Type --</option>
                    <option value="verification" {{ old('task_type', $assignment->task_type) == 'verification' ? 'selected' : '' }}>Verification</option>
                    <option value="interview" {{ old('task_type', $assignment->task_type) == 'interview' ? 'selected' : '' }}>Interview</option>
                    <option value="documentation" {{ old('task_type', $assignment->task_type) == 'documentation' ? 'selected' : '' }}>Documentation</option>
                </select>
                @error('task_type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ old('status', $assignment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $assignment->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('status', $assignment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Due Date</label>
                <input disabled type="date" name="due_date" class="form-control" value="{{ old('due_date', $assignment->due_date) }}">
                @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary save-button">Update</button>
            <a href="{{ route('tgg-fct.assignee.assignments.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection