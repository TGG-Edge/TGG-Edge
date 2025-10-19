@extends('tgg-india.layouts.app')

@section('title', 'Assignment Details | TGG Meta | TGG India')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">

            <h2 class="text-center mb-4">Create Assignment</h2>

            <form action="{{ route('tgg-india.member.assignments.store') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
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
                    <select name="task_type" class="form-select" required>
                        <option value="">-- Select Task Type --</option>
                        <option value="verification" {{ old('task_type') == 'verification' ? 'selected' : '' }}>Verification</option>
                        <option value="interview" {{ old('task_type') == 'interview' ? 'selected' : '' }}>Interview</option>
                        <option value="documentation" {{ old('task_type') == 'documentation' ? 'selected' : '' }}>Documentation</option>
                    </select>
                    @error('task_type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
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

                <div class="d-flex flex-wrap justify-content-between gap-2 mt-4">
                    <button type="submit" class="btn btn-success flex-fill flex-md-grow-0">Create</button>
                    <a href="{{ route('tgg-india.member.assignments.index') }}" class="btn btn-secondary flex-fill flex-md-grow-0">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
