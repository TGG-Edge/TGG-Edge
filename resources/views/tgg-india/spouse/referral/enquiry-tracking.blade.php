@extends('tgg-india.layouts.app')

@section('title', 'Enquiry Tracking | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Enquiry Tracking</h4>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Referrer</th>
                <th>Enquiry Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Message</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $index => $enquiry)
                <tr>
                    <td>{{ $index + $enquiries->firstItem() }}</td>
                    <td>{{ $enquiry->referrer?->name ?? 'N/A' }}</td>
                    <td>{{ $enquiry->name }}</td>
                    <td>{{ $enquiry->email }}</td>
                    <td>{{ $enquiry->phone }}</td>
                    <td>{{ $enquiry->role }}</td>
                    <td>{{ $enquiry->message ?? '-' }}</td>
                    <td>{{ $enquiry->created_at?->format('d M Y, h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No enquiries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $enquiries->links() }}
</div>
@endsection
