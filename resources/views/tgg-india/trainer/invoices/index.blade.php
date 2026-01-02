@extends('tgg-india.layouts.app')

@section('title', 'Invoices | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Invoices</h4>
        <div class="d-flex align-items-center justify-content-end gap-2">
            <a href="{{ route('tgg-india.trainer.invoices.create') }}" class="btn btn-primary assignment-button">
                <i class="bi bi-plus-lg"></i> + New Invoice
            </a>
            <a href="{{ route('tgg-india.download.excel', ['model' => 'Invoice']) }}"
                class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center"
                title="Download Excel">
            <i class="fas fa-file-excel"></i>Download Excel 
            </a>
        </div>
    </div>
    @include('tgg-india.layouts.includes.message')

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Invoice #</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Issue Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>#{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->source?->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->target?->name ?? 'N/A' }}</td>
                    <td>{!! statusWithColor($invoice->status)  !!}</td>
                    <td>{{ $invoice->issue_date ? $invoice->issue_date->format('Y-m-d') : '' }}</td>
                    
                    <td>{{ array_sum(array_column( $invoice->items ?? [], 'amount')); }} INR</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('tgg-india.trainer.invoices.show', $invoice->id) }}" class="btn btn-info btn-sm me-2 d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('tgg-india.trainer.invoices.edit', $invoice->id) }}" class="btn btn-primary btn-sm me-2 d-flex align-items-center justify-content-center p-0" style="width:28px;height:28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Download PDF --}}
                            <a href="{{ route('tgg-india.trainer.invoices.download', $invoice->id) }}" 
                            class="btn btn-success btn-sm me-2 d-flex align-items-center justify-content-center p-0" 
                            style="width:28px;height:28px;" 
                            title="Download PDF">
                                <i class="fas fa-download"></i>
                            </a>

                            <form action="{{ route('tgg-india.trainer.invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
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

    {{ $invoices->links() }}
</div>
@endsection
