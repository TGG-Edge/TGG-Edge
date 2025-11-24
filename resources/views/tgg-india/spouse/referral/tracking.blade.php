@extends('tgg-india.layouts.app')

@section('title', 'Referral Tracking | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Referral Tracking</h4>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Referred User</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Step</th>
                <th>Joined At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($referrals as $index => $referral)
                <tr>
                    <td>{{ $index + $referrals->firstItem() }}</td>
                    <td>{{ $referral->referredUser?->name ?? 'N/A' }}</td>
                    <td>{{ $referral->referredUser?->email ?? 'N/A' }}</td>
                    <td>{{ $referral->referredUser?->phone ?? 'N/A' }}</td>
                    <td>
                        @if($referral->step == 0)
                            <span class="badge bg-warning">Pending</span>
                        @elseif($referral->step == 1)
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-secondary">Other</span>
                        @endif
                    </td>
                    <td>{{ $referral->created_at?->format('d M Y, h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No referrals found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $referrals->links() }}
</div>
@endsection
