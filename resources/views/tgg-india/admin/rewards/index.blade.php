@extends('tgg-india.layouts.app')

@section('title', 'Rewards | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">My Rewards</h4>

        <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
            <a href="{{ route('tgg-india.admin.rewards.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-lg"></i> New Reward
            </a>

            <a href="{{ route('tgg-india.download.excel', ['model' => 'Reward']) }}"
               class="btn btn-outline-success d-flex align-items-center justify-content-center">
                <i class="fas fa-file-excel me-1"></i> Download Excel
            </a>
        </div>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Created At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rewards as $reward)
                    <tr>
                        <td>{{ $reward->title }}</td>
                        <td>{{ $reward->referrerUser->name ?? 'N/A' }}</td>
                        <td>{{ $reward->source_type ?? 'donation' }}</td>
                        <td>{{ $reward->description ?? 'N/A' }}</td>
                        <td>{!! statusWithColor($reward->status) !!}</td>

                        <td>{{ number_format($reward->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($reward->created_at)->format('d M Y') }}</td>

                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">

                                <!-- Edit -->
                                <a href="{{ route('tgg-india.admin.rewards.edit', $reward->id) }}"
                                   class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                                   style="width:32px;height:32px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('tgg-india.admin.rewards.destroy', $reward->id) }}"
                                      method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this reward?')"
                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                            style="width:32px;height:32px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                @php
                                    $receiptExists = \App\Models\Receipt::where('model_type', 'App\Models\Reward')
                                        ->where('model_id', $reward->id)
                                        ->exists();
                                    $receiptExists = false;
                                @endphp

                                <!-- Create Receipt -->
                                <a href="{{ $receiptExists
                                    ? '#'
                                    : route('tgg-india.admin.receipts.global-store', [
                                        'model_type' => 'App\Models\Reward',
                                        'model_id' => $reward->id,
                                        'source_id' => auth()->id(),
                                        'title' => $reward->title,
                                        'status' => 'pending',
                                        'price' => $reward->amount,
                                        'task_type' => $reward->task_type,
                                    ]) }}"
                                   class="btn btn-success btn-sm d-flex align-items-center justify-content-center p-0 {{ $receiptExists ? 'disabled' : '' }}"
                                   style="width:32px;height:32px;"
                                   title="Create receipt {{ $receiptExists ? '(Already exists)' : '' }}">
                                    <i class="fas fa-receipt"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No rewards found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $rewards->links() }}
    </div>

</div>
@endsection
