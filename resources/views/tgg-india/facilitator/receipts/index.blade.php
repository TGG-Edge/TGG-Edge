@extends('tgg-india.layouts.app')

@section('title', 'Receipts | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Receipts</h4>
        <div class="d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('tgg-india.facilitator.receipts.create') }}" class="btn btn-primary assignment-button">
                <i class="bi bi-plus-lg"></i> + New Receipt
            </a>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Receipt #</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Issue Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
                <tr>
                    <td>#{{ $receipt->receipt_number }}</td>
                    <td>{{ $receipt->source?->name ?? 'N/A' }}</td>
                    <td>{{ $receipt->target?->name ?? 'N/A' }}</td>
                    <td>{!! statusWithColor($receipt->status) !!}</td>
                    <td>{{ $receipt->created_at ? $receipt->created_at->format('d M, Y') : 'N/A' }}</td>
                    
                    <td>{{ array_sum(array_column( $receipt->items ?? [], 'amount')); }} INR</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('tgg-india.facilitator.receipts.show', $receipt->id) }}" class="btn btn-info btn-sm me-2 d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('tgg-india.facilitator.receipts.edit', $receipt->id) }}" class="btn btn-primary btn-sm me-2 d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Download PDF --}}
                            <a href="{{ route('tgg-india.facilitator.receipts.download', $receipt->id) }}" 
                            class="btn btn-success btn-sm me-2 d-flex align-items-center justify-content-center p-0" 
                            style="width:28px;height:28px;" 
                            title="Download PDF">
                                <i class="fas fa-download"></i>
                            </a>

                            <form action="{{ route('tgg-india.facilitator.receipts.destroy', $receipt->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $receipts->links() }}
</div>
@endsection
