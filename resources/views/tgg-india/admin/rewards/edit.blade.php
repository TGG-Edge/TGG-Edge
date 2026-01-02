@extends('tgg-india.layouts.app')

@section('title', 'Edit Reward | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Reward</h4>
    @include('tgg-india.layouts.includes.message')
    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.admin.rewards.update', $reward->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $reward->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Source User</label>
                <select name="source_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $reward->source_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Target User</label>
                <select name="target_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $reward->target_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="mb-3">
                <label class="form-label">Reason</label>
                <input type="text" name="reason" class="form-control" value="{{ $reward->reason }}">
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
                <textarea name="description" class="form-control" rows="4">{{ $reward->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" step="0.01" value="{{ $reward->amount }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $reward->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $reward->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $reward->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary save-button">Update</button>
        </form>
    </div>
</div>
@endsection
