@extends('tgg-india.layouts.app')

@section('title', 'Assignment Dashboard | TGG Meta | TGG India')


@section('content')
<div class="admin-container">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-3">
        <h4 class="mb-3 trainer-heading">Assignmnets</h4>
        <div class="d-flex align-items-center justify-content-start justify-content-lg-end gap-2 flex-wrap">
            <a href="{{ route('tgg-india.admin.assignments.create') }}" class="btn btn-primary assignment-button mb-2 mb-lg-0"><i class="bi bi-plus-lg"></i>+ New Assignment</a>
        </div>
    </div>

    <!-- Responsive scrollable table -->
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Task Type</th>
                    <th>Status</th>
                    <th>Member</th>
                    <th>Due Date</th>
                    <th>Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->title }}</td>
                    <td>{{ $assignment->task_type }}</td>
                    <td>{!! statusWithColor($assignment->status) !!}</td>
                    <td>{{ $assignment->member?->name }}</td>
                    <td>{{ $assignment->due_date ?? 'N/A' }}</td>
                    <td>{{ $assignment->price ?? '0' }}</td>
                  
                    <td>
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-1">
                            <a href="{{ route('tgg-india.admin.assignments.edit', $assignment->id) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-1" 
                                    style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('tgg-india.admin.assignments.destroy', $assignment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                        style="width: 28px; height: 28px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
