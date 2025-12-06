@extends('tgg-india.layouts.app')

@section('title', 'Edit Receipt | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Receipt #{{ $receipt->receipt_number }}</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.receipts.update', $receipt->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- <div class="mb-3">
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
            </div> --}}

            @php
                $authId = auth('web2')->id();
            @endphp
            <input type="hidden" name="source_id" value="{{ $authId }}">
            <input type="hidden" name="target_id" value="1">

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
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $receipt->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" name="total" class="form-control" step="0.01" value="{{ old('total', $receipt->total) }}">
            </div>

            <button type="submit" class="btn btn-primary save-button">Update</button>
            <a href="{{ route('tgg-india.trainer.receipts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
