@extends('tgg-india.layouts.app')

@section('title', 'Create Reward | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Create Reward</h4>
    @include('tgg-india.layouts.includes.message')
    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.admin.rewards.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Source User</label>
                <select name="source_id" class="form-control" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Target User</label>
                <select name="target_id" class="form-control" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="mb-3">
                <label class="form-label">Reason</label>
                <input type="text" name="reason" class="form-control">
            </div> --}}

            {{-- <div class="mb-3">
                <label class="form-label">Reason</label>
                <select name="reason" class="form-control" required>
                    <option value="">-- Select Reason --</option>

                    @foreach (getReasonOfReward() as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('reason', $reward->reason ?? '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" step="0.01">
            </div>

            {{-- <div class="mb-3">
                <label class="form-label">Receipt No</label>
                <input type="number" name="receipt_no" class="form-control" step="0.01">
            </div> --}}

            <div class="mb-3">
                <label class="form-label">Entitlement</label>
                <input type="number" name="entitlement" class="form-control" step="0.01">
            </div>

            <div class="mb-3">
                <label class="form-label">Appraisal </label>
                <input type="number" name="appraisal" class="form-control" step="0.01">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary save-button">Save</button>
        </form>
    </div>
</div>
@endsection
