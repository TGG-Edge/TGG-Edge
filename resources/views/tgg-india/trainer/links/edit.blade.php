@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Edit Link | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Link</h4>

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.links.update', $link->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
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

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control js-ckeditor" 
                    rows="5"
                >{{ old('description', $link->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
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
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tgg-india.trainer.links.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<!-- CKEditor 5 Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
