@extends('tgg-india.layouts.app')

@section('title', 'Email Check History')

@section('content')
<div class="admin-container">

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="trainer-heading">Email Check History</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('tgg-india.email-check.create', request()->route('role')) }}"
               class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> New Check
            </a>
            <a href="{{ route('tgg-india.email-check.download', [request()->route('role')]) }}"
            class="btn btn-success">
                <i class="fas fa-file-excel"></i> Download Valid Emails
            </a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Valid</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emails as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>
                        {!! $row->is_valid
                            ? '<span class="badge bg-success">Valid</span>'
                            : '<span class="badge bg-danger">Invalid</span>' !!}
                    </td>
                    <td>{{ $row->created_at->format('d M Y, h:i:s A') }}</td>
                    <td>
                        <a href="{{ route('tgg-india.email-check.show', [request()->route('role'), $row->id]) }}"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="GET"
                              action="{{ route('tgg-india.email-check.delete',$row->id) }}"
                              style="display:inline">
                            <button class="btn btn-danger btn-sm" style="width:35px;height:35px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $emails->links() }}

</div>
@endsection
