@extends('tgg-india.layouts.app')

@section('title', 'Donations | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Donations</h4>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>PAN Card</th>
                <th>Amount (₹)</th>
                <th>Purpose</th>
                <th>Receipt No.</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr>
                <td>{{ $donation->name }}</td>
                <td>{{ $donation->email }}</td>
                <td>{{ $donation->phone }}</td>
                <td>{{ $donation->pan_card_number ?? 'N/A' }}</td>
                <td>{{ number_format($donation->amount, 2) }}</td>
                <td>{{ $donation->purpose }}</td>
                <td>{{ $donation->receipt_number ?? 'Pending' }}</td>
                <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d M Y') }}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No donations found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $donations->links() }}
    </div>
</div>
@endsection
