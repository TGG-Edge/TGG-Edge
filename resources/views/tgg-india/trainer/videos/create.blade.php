@extends('tgg-india.layouts.app')

@section('title', 'Create Videos | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">
    <h4 class="mb-3 trainer-heading">Create New Video</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.videos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    id="title" 
                    placeholder="Enter title" 
                    required
                >
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-control js-ckeditor" 
                    rows="5"
                >{!! old('description', $video->description ?? '') !!}</textarea>
            </div>

            <!-- URL -->
            <div class="mb-3">
                <label for="url" class="form-label fw-semibold">URL</label>
                <input 
                    type="url" 
                    name="url" 
                    class="form-control" 
                    id="url" 
                    placeholder="https://example.com" 
                    required
                >
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Upload Image</label>
                <input 
                    type="file" 
                    name="image" 
                    class="form-control" 
                    id="image" 
                    accept="image/*"
                >
            </div>

            <!-- Buttons -->
            <div class="d-flex flex-wrap justify-content-start gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('tgg-india.trainer.videos.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
