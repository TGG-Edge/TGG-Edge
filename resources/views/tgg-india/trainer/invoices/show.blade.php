@extends('tgg-india.layouts.app')

@section('title', 'Invoice Details | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Invoice #{{ $invoice->invoice_number }}</h4>

    <div class="card p-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>From:</strong> {{ $invoice->source?->name ?? 'N/A' }}<br>
                <strong>To:</strong> {{ $invoice->target?->name ?? 'N/A' }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Issue Date:</strong> {{ $invoice->created_at?->format('d M, Y') ?? 'N/A' }}<br>
                <strong>Status:</strong> {!! statusWithColor($invoice->status) !!}
            </div>
        </div>

        <div class="mb-3">
            <strong>Description:</strong>
            <p>{{ $invoice->description ?? 'No description provided.' }}</p>
        </div>

        <div class="text-end">
            <h5>Total: {{ number_format($invoice->total, 2) }} INR</h5>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('tgg-india.trainer.invoices.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('tgg-india.trainer.invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
@endsection
