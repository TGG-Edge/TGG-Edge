@extends('tgg-india.layouts.app')

@section('title', 'Payments | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Payments</h4>
    </div>

    <!-- Responsive scrollable table -->
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Payer ID</th>
                    <th>Payer Type</th>
                    <th>Source (User)</th>
                    <th>Source Type</th>
                    <th>Feature Key</th>
                    <th>Amount (₹)</th>
                    <th>Status</th>
                    <th>Transaction ID</th>
                    <th>Payment Method</th>
                    <th>Currency</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->payer_id }}</td>
                    <td>{{ $payment->payer_type }}</td>
                    <td>{{ $payment->referrer->name ?? 'N/A' }}</td>
                    <td>{{ $payment->source_type ?? 'N/A' }}</td>
                    <td>{{ $payment->feature_key }}</td>
                    <td>{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ $payment->transaction_id ?? 'Pending' }}</td>
                    <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                    <td>{{ $payment->currency }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="text-center">No payments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
