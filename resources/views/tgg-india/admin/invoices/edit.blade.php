@extends('tgg-india.layouts.app')

@section('title', 'Edit Invoice | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <h4 class="mb-3 trainer-heading">Edit Invoice #{{ $invoice->invoice_number }}</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">

        <form action="{{ route('tgg-india.admin.invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Source -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Source (From)</label>
                    <select name="source_id" class="form-control">
                        <option value="">-- Select Source --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $invoice->source_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Target -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Target (To)</label>
                    <select name="target_id" class="form-control">
                        <option value="">-- Select Target --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $invoice->target_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Issue Date -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Issue Date</label>
                    <input type="date" name="issue_date" class="form-control"
                        value="{{ old('issue_date', $invoice->created_at ? $invoice->created_at->format('Y-m-d') : '') }}">
                </div>

                <!-- Status -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $invoice->description) }}</textarea>
                </div>

                <!-- Amount -->
                <div class="col-md-6 col-12">
                    <label class="form-label">Amount</label>
                    <input type="number" name="total" class="form-control" step="0.01"
                        value="{{ old('total', $invoice->total) }}">
                </div>
            </div>

            <div class="mt-3 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary save-button">Update</button>
                <a href="{{ route('tgg-india.admin.invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>
@endsection
