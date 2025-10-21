@extends('tgg-fct.layouts.app')

@section('title', 'Assignment | TGG Edge | TGG fct')

@section('content')
<div class="container-fluid admin-container">
    <div class="row mb-3 align-items-center">
        <div class="col-12 col-md-6">
            <h4 class="mb-3 trainer-heading">Assignments</h4>
        </div>
        <div class="col-12 col-md-6 text-md-end text-start">
            @include('tgg-fct.layouts.includes.message')
            <a href="{{ route('tgg-fct.admin.assignments.create') }}" class="btn btn-primary assignment-button mt-2 mt-md-0">
                <i class="bi bi-plus-lg"></i> + New Assignment
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Title</th>
                    <th>Task Type</th>
                    <th>Status</th>
                    <th>Assignee</th>
                    <th>Due Date</th>
                    <th>Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->title }}</td>
                    <td>{{ $assignment->task_type }}</td>
                    <td>{!! statusWithColor($assignment->status) !!}</td>
                    <td>{{ $assignment->assignee?->name }}</td>
                    <td>{{ $assignment->due_date ?? 'N/A' }}</td>
                    <td>{{ $assignment->price ?? '0' }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('tgg-fct.admin.assignments.edit', $assignment->id) }}" 
                               class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('tgg-fct.admin.assignments.destroy', $assignment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
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

    <div class="d-flex justify-content-center mt-3">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
