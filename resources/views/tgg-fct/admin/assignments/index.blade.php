@extends('tgg-fct.layouts.app')

@section('title', 'Trainer Dashboard - TGG India')


@section('content')
<div class="container">
    <h2>Assignments</h2>
    <a href="{{ route('tgg-fct.admin.assignments.create') }}" class="btn btn-primary mb-3">+ New Assignment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Task Type</th>
                <th>Status</th>
                <th>Assignee</th>
                <th>Due Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->task_type }}</td>
                <td>{{ ucfirst($assignment->status) }}</td>
                <td>{{ $assignment->assignee?->name }}</td>
                <td>{{ $assignment->due_date ?? 'N/A' }}</td>
                <td>{{ $assignment->creator?->name }}</td>
                <td>
                    <a href="{{ route('tgg-fct.admin.assignments.edit', $assignment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tgg-fct.admin.assignments.destroy', $assignment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $assignments->links() }}
</div>
@endsection
