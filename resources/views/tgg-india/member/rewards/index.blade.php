@extends('tgg-india.layouts.app')

@section('title', 'Rewards | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-column flex-md-row">
        <h4 class="mb-3 trainer-heading">My Rewards</h4>

        <a href="{{ route('tgg-india.download.excel', ['model' => 'Reward']) }}"
            class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center mt-2 mt-md-0"
            title="Download Excel">
           <i class="fas fa-file-excel me-1"></i> Download Excel 
        </a>
    </div>

    <!-- TABLE MADE RESPONSIVE -->
    <div class="table-responsive">
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
                @forelse($rewards as $reward)
                <tr>
                    <td>{{ $reward->title }}</td>
                    <td>{{ $reward->referrerUser->name ?? 'N/A' }}</td>
                    <td>{{ $reward->source_type ?? 'N/A' }}</td>
                    <td>{{ $reward->description ?? 'N/A' }}</td>

                    {{-- <td>{{ $reward->reason }}</td> --}}
                    <td>{!! statusWithColor($reward->status) !!}</td>

                    <td>{{ number_format($reward->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($reward->created_at)->format('d M Y') }}</td>

                    {{-- <td>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No rewards found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $rewards->links() }}
</div>
@endsection
