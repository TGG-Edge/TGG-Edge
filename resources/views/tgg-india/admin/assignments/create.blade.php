@extends('tgg-india.layouts.app')

@section('title', 'Create Assignment | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <!-- Page Title -->
    <h4 class="mb-3 trainer-heading">Create Assignment</h4>

    @include('tgg-india.layouts.includes.message')

    <!-- Responsive Card -->
    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.admin.assignments.store') }}" method="POST">
            @csrf

            @if(request()->has('parent_id'))
                <input type="hidden" value="{{ request()->parent_id }}" name="parent_id">
            @endif

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" 
                       name="title" 
                       class="form-control" 
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="description" 
                          name="description" 
                          class="form-control js-ckeditor" 
                          rows="5">
                    {!! old('description', $assignment->description ?? '') !!}
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Task Type</label>
                <select name="task_type" class="form-control" required>
                    @foreach(taskTypes() as $key => $label)
                        <option value="{{ $key }}" {{ old('task_type') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>   
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Assign To</label>
                <select name="assigned_to" class="form-control">
                    <option value="">-- Unassigned --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Due Date</label>
                <input type="date" 
                       name="due_date" 
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Fee</label>
                <input type="number" 
                       name="price" 
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary save-button mt-2">
                Save
            </button>

        </form>

    </div>

</div>
@endsection
