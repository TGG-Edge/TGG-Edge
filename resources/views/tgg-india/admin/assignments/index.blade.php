@extends('tgg-india.layouts.app')

@section('title', 'Assignment Dashboard | TGG Meta | TGG India')


@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Assignmnets</h4>
          @include('tgg-india.layouts.includes.message')
        <div class="d-flex align-items-center justify-content-end gap-2">
           
            @if(request()->has('parent_id'))
            <a href="{{ route('tgg-india.admin.assignments.create',[ 'parent_id' => request()->parent_id]) }}" class="btn btn-primary assignment-button"><i class="bi bi-plus-lg"></i>New Assignment</a>
            @else
             <a href="{{ route('tgg-india.admin.assignments.create') }}" class="btn btn-primary assignment-button"><i class="bi bi-plus-lg"></i>New Assignment</a>
            @endif
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Task Type</th>
                <th>Status</th>
                <th>Advisor</th>
                <th>Due Date</th>
                <th>Fee</th>
                <th>Childs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->task_type }}</td>
                <td>{!! statusWithColor($assignment->status) !!}</td>
                <td>{{ $assignment->advisor?->name }}</td>
                <td>{{ $assignment->due_date ?? 'N/A' }}</td>
                <td>{{ $assignment->price ?? '0' }}</td>
              <td><a href="{{ route('tgg-india.admin.assignments.index', [ 'parent_id' => $assignment->id])  }}">{{ $assignment->children ? $assignment->children->count() : 0 }}</a></td>
                <td>
                    <div class="d-flex align-items-center justify-content-center">

                        
                        <a href="{{ route('tgg-india.admin.assignments.edit', $assignment->id) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
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

    {{ $assignments->links() }}
</div>
@endsection
