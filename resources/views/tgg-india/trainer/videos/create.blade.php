@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Create videos | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New Literature</h4>
         @include('tgg-india.layouts.includes.message')
        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.videos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control js-ckeditor">{!! old('description', $video->description ?? '') !!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" name="url" class="form-control" id="url" placeholder="https://example.com">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*"> {{-- NEW FIELD --}}
                </div>
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>

    
@endsection
