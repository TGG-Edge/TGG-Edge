@extends('tgg-india.layouts.app')

@section('title', 'Receipts | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Receipts</h4>

        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
            <a href="{{ route('tgg-india.admin.receipts.create') }}" 
               class="btn btn-primary assignment-button">
                <i class="bi bi-plus-lg"></i> + New Receipt
            </a>

            <a href="{{ route('tgg-india.download.excel', ['model' => 'Receipt']) }}"
               class="btn btn-outline-success d-flex align-items-center justify-content-center">
                <i class="fas fa-file-excel me-1"></i> Download Excel
            </a>
        </div>

        @include('tgg-india.layouts.includes.message')
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Receipt #</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Issue Date</th>
                    <th>Total</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($receipts as $receipt)
                    <tr>
                        <td>#{{ $receipt->receipt_number }}</td>
                        <td>{{ $receipt->source?->name ?? 'N/A' }}</td>
                        <td>{{ $receipt->target?->name ?? 'N/A' }}</td>
                        <td>{!! statusWithColor($receipt->status) !!}</td>

                        <td>{{ $receipt->issue_date ? $receipt->issue_date->format('d M, Y') : 'N/A' }}</td>

                        <td>{{ array_sum(array_column( $receipt->items ?? [], 'amount')) }} INR</td>

                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">

                                <a href="{{ route('tgg-india.admin.receipts.show', $receipt->id) }}"
                                   class="btn btn-info btn-sm d-flex align-items-center justify-content-center p-0"
                                   style="width:30px;height:30px;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('tgg-india.admin.receipts.edit', $receipt->id) }}"
                                   class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                                   style="width:30px;height:30px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('tgg-india.admin.receipts.download', $receipt->id) }}"
                                   class="btn btn-success btn-sm d-flex align-items-center justify-content-center p-0"
                                   style="width:30px;height:30px;"
                                   title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>

                                <form action="{{ route('tgg-india.admin.receipts.destroy', $receipt->id) }}" 
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                            style="width:30px;height:30px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $receipts->links() }}
    </div>

</div>
@endsection
