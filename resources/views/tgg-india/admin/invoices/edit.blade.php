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
                        value="{{ old('issue_date', $invoice->issue_date ? $invoice->issue_date->format('Y-m-d') : '') }}">
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

                <!-- Invoice Items -->
                <div class="col-12">
                    <label class="form-label">Invoice Items</label>

                    <div id="items-container">
                        @foreach($invoice->items as $index => $item)
                            <div class="item-row border p-3 mb-2 rounded">
                                <div class="row">

                                    <div class="col-md-8 col-12 mb-2">
                                        <label class="form-label">Description</label>
                                        <textarea name="items[{{ $index }}][description]"
                                        class="form-control"
                                        rows="2">{{ $item['description'] ?? '' }}</textarea>

                                    </div>

                                    <div class="col-md-3 col-12 mb-2">
                                        <label class="form-label">Amount</label>
                                        <input type="number"
                                        name="items[{{ $index }}][amount]"
                                        class="form-control"
                                        step="0.01"
                                        value="{{ $item['amount'] ?? '' }}">

                                    </div>

                                    <div class="col-md-1 col-12 d-flex align-items-end mb-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-item" class="btn btn-secondary btn-sm mt-2">
                        <i class="fas fa-plus"></i> Add More
                    </button>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = {{ is_array($invoice->items) ? count($invoice->items) : 0 }};


    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');
        const div = document.createElement('div');

        div.className = 'item-row border p-3 mb-2 rounded';
        div.innerHTML = `
            <div class="row">
                <div class="col-md-8 col-12 mb-2">
                    <label class="form-label">Description</label>
                    <textarea name="items[${itemIndex}][description]" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-md-3 col-12 mb-2">
                    <label class="form-label">Amount</label>
                    <input type="number" name="items[${itemIndex}][amount]" class="form-control" step="0.01">
                </div>

                <div class="col-md-1 col-12 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(div);
        itemIndex++;
    });

    document.getElementById('items-container').addEventListener('click', function (e) {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
});
</script>
@endpush
