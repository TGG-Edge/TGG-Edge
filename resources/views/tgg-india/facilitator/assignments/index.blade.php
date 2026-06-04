@extends('tgg-india.layouts.app')

@section('title', 'Assignments facilitator | TGG Meta | TGG India')


@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">My Assignments</h4>
        <div class="d-flex align-items-center gap-2">
            @if(request()->has('parent_id'))
            <a href="{{ route('tgg-india.facilitator.assignments.create',[ 'parent_id' => request()->parent_id]) }}" class="btn btn-primary assignment-button"><i class="bi bi-plus-lg"></i>New Assignment</a>
            @else
                <a href="{{ route('tgg-india.facilitator.assignments.create') }}" 
                   class="btn btn-primary assignment-button">
                    <i class="bi bi-plus-lg"></i> New Assignment
                </a>
            @endif
        </div>
    </div>
    @include('tgg-india.layouts.includes.message') 
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Task Type</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Created By</th>
                <th>Fee</th>
                <th>Activity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->title }}</td>
                <td>{{ $assignment->task_type }}</td>
                <td>{!! statusWithColor($assignment->status) !!}</td>
                <td>{{ $assignment->due_date ?? '-' }}</td>
                <td>{{ $assignment->creator?->name }}</td>
                <td>{{ $assignment->price }}</td>
                <td>
                    @php
                        $parent = $assignment->parent; // 1st level parent
                        $grandParent = $parent ? $parent->parent : null; // 2nd level parent
                        $greatGrandParent = $grandParent ? $grandParent->parent : null; // 3rd level parent
                    @endphp
                    @if($grandParent == null)
                        <a href="{{ route('tgg-india.facilitator.assignments.index', ['parent_id' => $assignment->id]) }}">
                            {{ $assignment->children ? $assignment->children->count() : 0 }}
                        </a>
                    @else
                    <a href="javascript:void(0);" 
                    style="pointer-events: none; color: gray; text-decoration: none; cursor: not-allowed;">
                    {{ $assignment->children ? $assignment->children->count() : 0 }}
                    </a>
                    @endif
                    {{-- <a href="{{ route('tgg-india.facilitator.assignments.index', [ 'parent_id' => $assignment->id])  }}">{{ $assignment->children ? $assignment->children->count() : 0 }}</a> --}}
                </td>
                <td>
                    <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ route('tgg-india.facilitator.assignments.edit', $assignment) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                            style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                    </a>

                    @php
                        $invoiceExists = \App\Models\Invoice::where('model_type', 'App\Models\Assignment')
                                                            ->where('model_id', $assignment->id)
                                                            ->exists();
                        $invoiceExists = false;
                    @endphp

                    <a href="{{ $invoiceExists ? '#' : route('tgg-india.facilitator.invoices.global-store', [
                        'model_type' => 'App\Models\Assignment',
                        'model_id'   => $assignment->id,
                        'source_id'  => auth()->id(),      // Optional: current user as source
                        'title'=> $assignment->title,
                        'status'     => 'pending',
                        'price'      => $assignment->price,
                        'task_type'      => $assignment->task_type,
                            ]) }}" 
                        class="btn btn-success btn-sm d-flex align-items-center justify-content-center p-0 {{ $invoiceExists ? 'disabled' : '' }}" 
                        style="width: 28px; height: 28px;" 
                        title="Create Invoice {{ $invoiceExists ? '(Already exists)' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $assignments->links() }}
</div>
@endsection
