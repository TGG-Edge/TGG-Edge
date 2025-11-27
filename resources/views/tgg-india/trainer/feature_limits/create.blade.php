@extends('tgg-india.layouts.app')

@section('title', 'Create Feature Limit | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Create Feature Limit</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form action="{{ route('tgg-india.trainer.feature-limits.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="feature_key" class="form-label">Feature:</label>
                <select name="feature_key" class="form-control" required>
                    <option value="literatures">Literatures</option>
                    <option value="links">Links</option>
                    <option value="videos">Videos</option>
                    <option value="linkedins">Linkedins</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="free_limit" class="form-label">Free Limit:</label>
                <input type="number" name="free_limit" class="form-control" min="0" value="0" required>
            </div>

            <button type="submit" class="btn btn-primary save-button">Save</button>
        </form>
    </div>
</div>
@endsection
