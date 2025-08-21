@extends('tgg-india.layouts.app')

@section('title', 'Feature Limits | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Feature Limits</h4>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('tgg-india.admin.feature-limits.create') }}" class="btn btn-primary">Create New</a>
    </div>

    <div class="card p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Feature</th>
                    <th>Free Limit</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($featureLimits as $feature)
                    <tr>
                        <td>{{ ucfirst($feature->feature_key) }}</td>
                        <td>{{ $feature->free_limit }}</td>
                        <td>{{ $feature->created_at?->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('tgg-india.admin.feature-limits.edit', $feature->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('tgg-india.admin.feature-limits.destroy', $feature->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this feature?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No features found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
