@extends('tgg-india.layouts.app')

@section('title', 'Incentives | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">My Incentives</h4>

        {{-- 📊 Download Excel Button --}}
        <a href="{{ route('tgg-india.download.excel', ['model' => 'Incentive']) }}"
            class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center"
            title="Download Excel">
           <i class="fas fa-file-excel"></i> Download Excel
        </a>

        @include('tgg-india.layouts.includes.message')
    </div>

    {{-- Responsive scrollable table --}}
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incentives as $incentive)
                <tr>
                    <td>{{ $incentive->title }}</td>
                    <td>{{ $incentive->referrerUser->name ?? 'N/A' }}</td>
                    <td>{{ $incentive->source_type ?? 'N/A' }}</td>
                    <td>{{ $incentive->description ?? 'N/A' }}</td>
                    <td>{{ ucfirst($incentive->status) }}</td>
                    <td>{{ number_format($incentive->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($incentive->created_at)->format('d M Y') }}</td>
                    <td>
                        @php
                            $receiptExists = \App\Models\Receipt::where('model_type', 'App\Models\Incentive')
                                ->where('model_id', $incentive->id)
                                ->exists();
                        @endphp

                        <a href="{{ $receiptExists ? '#' : route('tgg-india.admin.receipts.global-store', [
                            'model_type' => 'App\Models\Incentive',
                            'model_id'   => $incentive->id,
                            'source_id'  => auth()->id(),
                            'title'      => $incentive->title,
                            'status'     => 'pending',
                            'price'      => $incentive->amount,
                            'task_type'  => $incentive->task_type,
                            'target_id'  => $incentive->referrerUser->id,
                        ]) }}" 
                        class="btn btn-success btn-sm d-flex align-items-center justify-content-center p-0 {{ $receiptExists ? 'disabled' : '' }}"
                        style="width: 28px; height: 28px;" 
                        title="Create receipt {{ $receiptExists ? '(Already exists)' : '' }}">
                            <i class="fas fa-receipt"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No incentives found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $incentives->links() }}
</div>
@endsection
