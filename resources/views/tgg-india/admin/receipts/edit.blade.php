@extends('tgg-india.layouts.app')

@section('title', 'Edit Receipt | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Receipt #{{ $receipt->receipt_number }}</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.admin.receipts.update', $receipt->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Source (From)</label>
                <select name="source_id" class="form-control">
                    <option value="">-- Select Source --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $receipt->source_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Target (To)</label>
                <select name="target_id" class="form-control">
                    <option value="">-- Select Target --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $receipt->target_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Issue Date</label>
                <input type="date" name="issue_date" class="form-control"
                    value="{{ old('issue_date', $receipt->issue_date ? $receipt->issue_date->format('Y-m-d') : '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="draft" {{ $receipt->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="paid" {{ $receipt->status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ $receipt->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>

             <div class="mb-3">
                <label class="form-label">Receipt Items</label>

                <div id="items-container">
                    @forelse(old('items', $receipt->items ?? []) as $index => $item)
                        <div class="item-row border p-3 mb-2 rounded">
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="items[{{ $index }}][description]"
                                            class="form-control" rows="2">{{ $item['description'] }}</textarea>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Amount</label>
                                    <input type="number"
                                        name="items[{{ $index }}][amount]"
                                        class="form-control"
                                        step="0.01"
                                        value="{{ $item['amount'] }}">
                                </div>

                                <div class="col-md-1 d-flex align-items-end mb-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- If no items exist --}}
                        <div class="item-row border p-3 mb-2 rounded">
                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="items[0][description]" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Amount</label>
                                    <input type="number" name="items[0][amount]" class="form-control" step="0.01">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button type="button" id="add-item" class="btn btn-success btn-sm mt-2">
                    <i class="fas fa-plus"></i> Add Item
                </button>
            </div>

            <button type="submit" class="btn btn-primary save-button">Update</button>
            <a href="{{ route('tgg-india.admin.receipts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = document.querySelectorAll('.item-row').length;

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('items-container');

        const newItem = document.createElement('div');
        newItem.classList.add('item-row', 'border', 'p-3', 'mb-2', 'rounded');

        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-8 mb-2">
                    <label class="form-label">Description</label>
                    <textarea name="items[${itemIndex}][description]" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-md-3 mb-2">
                    <label class="form-label">Amount</label>
                    <input type="number" name="items[${itemIndex}][amount]" class="form-control" step="0.01">
                </div>

                <div class="col-md-1 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item w-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(newItem);
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