@extends('tgg-india.layouts.app')

@section('title', 'Feature Limits | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h4 class="mb-3 trainer-heading">Feature Limits</h4>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('tgg-india.admin.feature-limits.create') }}" class="btn btn-primary assignment-button">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <!-- Responsive table wrapper -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Feature</th>
                    <th>Free Limit</th>
                    <th>Created</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($featureLimits as $feature)
                    <tr>
                        <td>{{ ucfirst($feature->feature_key) }}</td>
                        <td>{{ $feature->free_limit }}</td>
                        <td>{{ $feature->created_at?->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <!-- Edit Button -->
                                <a href="{{ route('tgg-india.admin.feature-limits.edit', $feature->id) }}" 
                                   class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                                   style="width: 28px; height: 28px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('tgg-india.admin.feature-limits.destroy', $feature->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this feature?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                            style="width: 28px; height: 28px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No features found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
