@extends('tgg-india.layouts.app')

@section('title', 'Invoice Details | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <h4 class="mb-3 trainer-heading">Invoice #{{ $invoice->invoice_number }}</h4>

    <div class="card p-3">

        {{-- Responsive From / To / Issue / Status --}}
        <div class="row mb-3 gy-3">

            {{-- LEFT SIDE --}}
            <div class="col-12 col-md-6">
                <strong>From:</strong> {{ $invoice->source?->name ?? 'N/A' }}<br>
                <strong>To:</strong> {{ $invoice->target?->name ?? 'N/A' }}
            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-12 col-md-6 text-md-end text-start">
                <strong>Issue Date:</strong> {{ $invoice->created_at?->format('d M, Y') ?? 'N/A' }}<br>
                <strong>Status:</strong> {!! statusWithColor($invoice->status) !!}
            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-3">
            <strong>Description:</strong>
            <p class="mb-0">{{ $invoice->description ?? 'No description provided.' }}</p>
        </div>

        {{-- TOTAL --}}
        <div class="text-md-end text-start">
            <h5>Total: {{ number_format($invoice->total, 2) }} INR</h5>
        </div>

        {{-- BUTTONS --}}
        <div class="mt-4 text-md-end text-start d-flex flex-wrap gap-2 justify-content-md-end justify-content-start">
            <a href="{{ route('tgg-india.advisor.invoices.index') }}" class="btn btn-secondary">
                Back
            </a>
            <a href="{{ route('tgg-india.advisor.invoices.edit', $invoice->id) }}" class="btn btn-primary">
                Edit
            </a>
        </div>

    </div>

</div>
@endsection
