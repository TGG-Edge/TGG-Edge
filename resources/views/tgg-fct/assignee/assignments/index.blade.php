@extends('tgg-fct.layouts.app')

@section('title', 'Assignments assignee | TGG Edge | TGG fct')


@section('content')
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-3 trainer-heading">My Assignments</h4>
            <div class="d-flex align-items-center gap-2">
                {{-- <a href="{{ route('tgg-fct.assignee.assignments.create') }}" class="btn btn-primary assignment-button"><i class="bi bi-plus-lg"></i>New Assignment</a> --}}
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th style="width: 20%;">Title</th>
                    <th style="width: 15%;">Task Type</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 15%;">Due Date</th>
                    <th style="width: 15%;">Created By</th>
                    <th style="width: 10%;">Fee</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->task_type }}</td>
                        <td>{!! statusWithColor($assignment->status) !!}</td>
                        <td>{{ $assignment->due_date ?? '-' }}</td>
                        <td>{{ $assignment->creator?->name }}</td>
                        <td>{{ $assignment->price ?? '0' }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('tgg-fct.assignee.assignments.edit', $assignment) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $assignments->links() }}
    </div>
@endsection
