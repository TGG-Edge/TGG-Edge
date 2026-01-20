@extends('tgg-india.layouts.app')

@section('title', 'Assignments Associate | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">My Assignments</h4>
        <div class="d-flex align-items-center gap-2">
            {{-- <a href="{{ route('tgg-india.associate.assignments.create') }}" class="btn btn-primary assignment-button"><i class="bi bi-plus-lg"></i>New Assignment</a> --}}
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
                    <div class="d-flex align-items-center justify-content-center">
                    <a href="{{ route('tgg-india.associate.assignments.edit', $assignment) }}" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                            style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                    </a>

                    @php
                        $invoiceExists = \App\Models\Invoice::where('model_type', 'App\Models\Assignment')
                                                            ->where('model_id', $assignment->id)
                                                            ->exists();
                        $invoiceExists = false;
                    @endphp

                    <a href="{{ $invoiceExists ? '#' : route('tgg-india.associate.invoices.global-store', [
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
