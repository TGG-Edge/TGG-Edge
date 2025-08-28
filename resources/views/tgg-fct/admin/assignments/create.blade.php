
@extends('tgg-fct.layouts.app')

@section('title', 'Create Trainer Project | TGG Edge | TGG Fct')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Create Assignment</h4>
    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-fct.admin.assignments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control js-ckeditor" rows="5">
                    {!! old('description', $assignment->description ?? '') !!}
                </textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Task Type</label>
                <input type="text" name="task_type" class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Assign To</label>
                <select name="assigned_to" class="form-control">
                    <option value="">-- Unassigned --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary save-button">Save</button>
        </form>
    </div>
</div>
@endsection
