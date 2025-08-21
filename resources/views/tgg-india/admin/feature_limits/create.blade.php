@extends('tgg-india.layouts.app')

@section('title', 'Create Feature Limit | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Create Feature Limit</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form action="{{ route('tgg-india.admin.feature-limits.store') }}" method="POST">
            @csrf

            <label for="feature_key">Feature:</label>
            <select name="feature_key" class="form-control" required>
                <option value="literatures">Literatures</option>
                <option value="links">Links</option>
                <option value="videos">Videos</option>
                <option value="linkedins">Linkedins</option>
            </select>

            <label for="free_limit" class="mt-2">Free Limit:</label>
            <input type="number" name="free_limit" class="form-control" min="0" value="0" required>

            <button type="submit" class="btn btn-primary save-button">Save</button>
        </form>
    </div>
</div>
@endsection
