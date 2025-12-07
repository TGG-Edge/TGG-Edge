@extends('tgg-india.layouts.app')

@section('title', 'Referral Tracking | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Referral Tracking</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Referrer User</th>
                    <th>Referrer Email</th>
                    <th>Referred User</th>
                    <th>Referred Email</th>
                    <th>Step</th>
                    <th>Approval By Admin</th>
                    <th>Joined At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($referrals as $index => $referral)
                    <tr>
                        <td>{{ $index + $referrals->firstItem() }}</td>
                        <td>{{ $referral->referrerUser?->name ?? 'N/A' }}</td>
                        <td>{{ $referral->referrerUser?->email ?? 'N/A' }}</td>
                        <td>{{ $referral->referredUser?->name ?? 'N/A' }}</td>
                        <td>{{ $referral->referredUser?->email ?? 'N/A' }}</td>
                        <td>
                           {!! statusWithColorStep($referral->step) !!}
                        </td>
                        <td>{!! statusWithColorApproval($referral->referredUser?->approval) !!}</td>
                        <td>{{ $referral->created_at?->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No referrals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $referrals->links() }}
</div>
@endsection
