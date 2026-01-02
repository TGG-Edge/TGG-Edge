@extends('tgg-india.layouts.app')

@section('title', 'Receipt Details | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Receipt #{{ $receipt->receipt_number }}</h4>

    <div class="card p-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>From:</strong> {{ $receipt->source?->name ?? 'N/A' }}<br>
                <strong>To:</strong> {{ $receipt->target?->name ?? 'N/A' }}
            </div>
            <div class="col-md-6 text-end">
                <strong>Issue Date:</strong> {{ $receipt->issue_date?->format('d M, Y') ?? 'N/A' }}<br>
                <strong>Status:</strong> {!! statusWithColor($receipt->status) !!}
            </div>
        </div>

        <div class="mb-3">
            <strong>Description:</strong>
            <p>{{ $receipt->description ?? 'No description provided.' }}</p>
        </div>

        <div class="text-end">
            <h5>Total: {{ number_format($receipt->total, 2) }} INR</h5>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('tgg-india.freelancer.receipts.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('tgg-india.freelancer.receipts.edit', $receipt->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
@endsection
