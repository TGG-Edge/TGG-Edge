@extends('tgg-india.layouts.app')

@section('title', 'Edit Feature Limit | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Feature Limit</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form action="{{ route('tgg-india.admin.feature-limits.update', $featureLimit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="feature_key">Feature:</label>
            <select name="feature_key" class="form-control" required>
                <option value="literatures" {{ $featureLimit->feature_key == 'literatures' ? 'selected' : '' }}>Literatures</option>
                <option value="links" {{ $featureLimit->feature_key == 'links' ? 'selected' : '' }}>Links</option>
                <option value="videos" {{ $featureLimit->feature_key == 'videos' ? 'selected' : '' }}>Videos</option>
                <option value="linkedins" {{ $featureLimit->feature_key == 'linkedins' ? 'selected' : '' }}>Linkedins</option>
            </select>

            <label for="free_limit" class="mt-2">Free Limit:</label>
            <input type="number" name="free_limit" class="form-control" min="0" value="{{ $featureLimit->free_limit }}" required>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>
@endsection
