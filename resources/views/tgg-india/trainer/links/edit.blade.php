@extends('tgg-india.layouts.app')

@section('title', 'Edit Link | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">
    <h4 class="mb-3 trainer-heading">Edit Link</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.links.update', $link->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    id="title" 
                    value="{{ old('title', $link->title) }}" 
                    placeholder="Enter title"
                    required
                >
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control js-ckeditor" 
                    rows="5"
                >{{ old('description', $link->description) }}</textarea>
            </div>

            <!-- URL -->
            <div class="mb-3">
                <label for="url" class="form-label fw-semibold">URL</label>
                <input 
                    type="url" 
                    name="url" 
                    class="form-control" 
                    id="url" 
                    value="{{ old('url', $link->url) }}" 
                    placeholder="https://example.com"
                    required
                >
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary save-button">Update</button>
                <a href="{{ route('tgg-india.trainer.links.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
