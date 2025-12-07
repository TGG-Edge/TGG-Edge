@extends('tgg-india.layouts.app')

@section('title', 'Create Receipt | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Create Receipt</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.advisor.receipts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Source (From)</label>
                <select name="source_id" class="form-control">
                    <option value="">-- Select Source --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Target (To)</label>
                <select name="target_id" class="form-control">
                    <option value="">-- Select Target --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Issue Date</label>
                <input type="date" name="issue_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>

            {{-- RECEIPT ITEMS --}}
            <div class="mb-3">
                <label class="form-label">Receipt Items</label>

                <div id="items-container">
                    <div class="item-row border p-3 mb-2 rounded">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 mb-2">
                                <label class="form-label">Description</label>
                                <textarea name="items[0][description]" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-3 col-sm-9 mb-2">
                                <label class="form-label">Amount</label>
                                <input type="number" name="items[0][amount]" class="form-control" step="0.01">
                            </div>

                            <div class="col-md-1 col-sm-3 d-flex align-items-end mb-2">
                                <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="btn btn-secondary btn-sm mt-2">
                    <i class="fas fa-plus"></i> Add More
                </button>
            </div>

            <button type="submit" class="btn btn-primary save-button mt-3">Save</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ---------- MOBILE + IPAD RESPONSIVE FIXES ---------- */

@media (max-width: 991.98px) { /* iPad + Mobile */
    .save-button {
        width: 100%;
    }
}

@media (max-width: 575.98px) { /* Mobile Only */
    #items-container .row > div {
        margin-bottom: 10px;
    }

    #items-container textarea,
    #items-container input {
        width: 100% !important;
    }

    .remove-item {
        width: 100% !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Add new item
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newItem = document.createElement('div');
        newItem.classList.add('item-row', 'border', 'p-3', 'mb-2', 'rounded');

        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-8 col-sm-12 mb-2">
                    <label class="form-label">Description</label>
                    <textarea name="items[${itemIndex}][description]" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-md-3 col-sm-9 mb-2">
                    <label class="form-label">Amount</label>
                    <input type="number" name="items[${itemIndex}][amount]" class="form-control" step="0.01">
                </div>

                <div class="col-md-1 col-sm-3 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(newItem);
        itemIndex++;
    });

    // Remove item
    document.getElementById('items-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
});
</script>
@endpush
