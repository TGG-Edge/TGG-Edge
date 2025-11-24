@extends('tgg-india.layouts.app')

@section('title', 'Incentives | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">My Incentives</h4>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>User</th>
                <th>Type</th>
                <th>Description</th>
                {{-- <th>Reason</th> --}}
                <th>Status</th>
                <th>Amount</th>
                <th>Created At</th>
                {{-- <th>Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($incentives as $incentive)
            <tr>
                <td>{{ $incentive->title }}</td>
                <td>{{ $incentive->referrerUser->name ?? 'N/A' }}</td>
                <td>{{ $incentive->source_type ?? 'N/A' }}</td>
                <td>{{ $incentive->description ?? 'N/A' }}</td>

                {{-- <td>{{ $incentive->reason }}</td> --}}
                 <td>{!! statusWithColor($incentive->status) !!}</td>

                <td>{{ number_format($incentive->amount, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($incentive->created_at)->format('d M Y') }}</td>
                {{-- <td>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No incentives found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $incentives->links() }}
</div>
@endsection
