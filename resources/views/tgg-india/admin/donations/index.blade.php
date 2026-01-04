@extends('tgg-india.layouts.app')

@section('title', 'Donations | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Donations</h4>
         <a href="{{ route('tgg-india.admin.donations.create') }}"
       class="btn btn-primary assignment-button">
        <i class="bi bi-plus-lg"></i> + New Donation
    </a>
    </div>

    <!-- Responsive scrollable table -->
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>RHM Reg. No</th>
                    <th>PAN Card</th>
                    <th>Purpose</th>
                    <th>Type</th>
                    <th>Amount (₹)</th>
                    <th>Receipt No.</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr>
                    <td>{{ $donation->name }}</td>
                    @php
                        $user = \App\Models\UserSecondary::where('email', $donation->email)->first();
                    @endphp
                    <td>{{  $user->rhm_number ?? 'N/A'  }}</td>
                    <td>{{ $donation->pan_card_number ?? 'N/A' }}</td>
                    <td>{{ $donation->purpose }}</td>
                    <td>{{ getDonationType()[$donation->type] ?? 'N/A' }}</td>
                    <td>{{ number_format($donation->amount, 2) }}</td>
                    <td>{{ $donation->receipt_number ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d M Y') }}</td>
                    <td>
                       <div class="d-flex align-items-center justify-content-center flex-wrap">

                        {{-- View --}}
                        {{-- <a href="{{ route('tgg-india.admin.donations.show', $donation->id) }}"
                        class="btn btn-info btn-sm me-2 d-flex align-items-center justify-content-center p-0"
                        target="_blank"
                        style="width:28px;height:28px;">
                            <i class="fas fa-eye"></i>
                        </a> --}}

                        {{-- Edit --}}
                        <a href="{{ route('tgg-india.admin.donations.edit', $donation->id) }}"
                        class="btn btn-primary btn-sm me-2 d-flex align-items-center justify-content-center p-0"
                        style="width:28px;height:28px;">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('tgg-india.admin.donations.destroy', $donation->id) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Are you sure you want to delete this donation?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0 me-2 me-md-0"
                                style="width:28px;height:28px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No donations found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $donations->links() }}
    </div>
</div>
@endsection
