@extends('tgg-fct.layouts.app')

@section('title', 'Assignments assignee - TGG India')


@section('content')
<div class="container">
    <h2>My Assignments</h2>
    <a href="{{ route('tgg-fct. assignee.assignments.create') }}" class="btn btn-primary">New Assignment</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Task Type</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->task_type }}</td>
                <td>{{ ucfirst($assignment->status) }}</td>
                <td>{{ $assignment->due_date ?? '-' }}</td>
                <td>
                    <a href="{{ route('tgg-fct. assignee.assignments.edit', $assignment) }}" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assignments->links() }}
</div>
@endsection
