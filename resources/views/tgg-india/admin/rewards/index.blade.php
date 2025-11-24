@extends('tgg-india.layouts.app')

@section('title', 'Rewards | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-3 trainer-heading">My Rewards</h4>

            <div class="d-flex justify-content-between align-items-center mb-3 ">
                <a href="{{ route('tgg-india.admin.rewards.create') }}" class="btn btn-primary me-2">
                    <i class="bi bi-plus-lg"></i> New Reward
                </a>
                <a href="{{ route('tgg-india.download.excel', ['model' => 'Reward']) }}"
                    class="btn btn-outline-success  d-flex align-items-center justify-content-center" title="Download Excel">
                    <i class="fas fa-file-excel"></i>Download Excel
                </a>
            </div>

        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Description</th>
                    {{-- <th>Reason</th> --}}
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rewards as $reward)
                    <tr>
                        <td>{{ $reward->title }}</td>
                        <td>{{ $reward->referrerUser->name ?? 'N/A' }}</td>
                        <td>{{ $reward->source_type ?? 'donation' }}</td>
                        <td>{{ $reward->description ?? 'N/A' }}</td>

                        {{-- <td>{{ $reward->reason }}</td> --}}
                        <td>{!! statusWithColor($reward->status) !!}</td>

                        <td>{{ number_format($reward->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($reward->created_at)->format('d M Y') }}</td>
                        <td>
                              <div class="d-flex align-items-center justify-content-center">
                             <a href="{{ route('tgg-india.admin.rewards.edit', $reward->id) }}" class="btn btn-primary btn-sm me-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('tgg-india.admin.rewards.destroy', $reward->id) }}" method="POST" style="">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm  me-2" onclick="return confirm('Delete this reward?')" style="
    width: auto;
">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                            @php
                                $receiptExists = \App\Models\Receipt::where('model_type', 'App\Models\Reward')
                                    ->where('model_id', $reward->id)
                                    ->exists();
                                $receiptExists = false;
                            @endphp
                            <a href="{{ $receiptExists
                                ? '#'
                                : route('tgg-india.admin.receipts.global-store', [
                                    'model_type' => 'App\Models\Reward',
                                    'model_id' => $reward->id,
                                    'source_id' => auth()->id(), // Optional: current user as source
                                    'title' => $reward->title,
                                    'status' => 'pending',
                                    'price' => $reward->amount,
                                    'task_type' => $reward->task_type,
                                ]) }}"
                                class="btn btn-success btn-sm d-flex align-items-center justify-content-center p-0 {{ $receiptExists ? 'disabled' : '' }}"
                                style="width: 28px; height: 28px;"
                                title="Create receipt {{ $receiptExists ? '(Already exists)' : '' }}">
                                <i class="fas fa-receipt"></i>
                            </a>
                              </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No rewards found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $rewards->links() }}
    </div>
@endsection
