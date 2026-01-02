@extends('tgg-india.layouts.app')

@section('title', 'Campaign Details')

@section('content')
<div class="admin-container">

    <h4 class="trainer-heading mb-3">Campaign Details</h4>

    {{-- Campaign Info --}}
    <div class="card mb-4 p-3">
        <div class="row">
            <div class="col-md-4"><strong>ID:</strong> {{ $campaign->id }}</div>
            <div class="col-md-4"><strong>Status:</strong> {{ ucfirst($campaign->status) }}</div>
            <div class="col-md-4"><strong>Type:</strong> {{ ucfirst($campaign->type) }}</div>
            <div class="col-md-4">
                <strong>Template:</strong> {{ $campaign->template->name ?? 'N/A' }}
            </div>
            <div class="col-md-4">
                <strong>Created At:</strong> {{ $campaign->created_at->format('d M Y, h:i A') }}
            </div>
        </div>
    </div>

    {{-- Template Preview --}}
    <div class="card mb-4 p-3">
        <h6>Template Content</h6>
        <div>
            <strong>Subject:</strong> {{ $campaign->template->title ?? '-' }}
        </div>
        <hr>
        {!! $campaign->template->content['body'] ?? '-' !!}
    </div>

    {{-- Recipients --}}
    <div class="card p-3">
        <h6 class="mb-3">Campaign Recipients</h6>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaign->recipients as $index => $recipient)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $recipient->payload['email'] ?? 'N/A' }}</td>
                            <td>{{ $recipient->payload['name'] ?? 'N/A' }}</td>
                            <td>{{ ucfirst($recipient->status) }}</td>
                            <td>{{ $recipient->updated_at ? $recipient->updated_at->format('d M Y, h:i:s A') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($campaign->recipients->isEmpty())
            <p class="text-muted">No recipients found.</p>
        @endif
    </div>

</div>
@endsection
