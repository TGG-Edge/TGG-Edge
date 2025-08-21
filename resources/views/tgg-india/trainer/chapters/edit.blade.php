@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Edit Chapters | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Edit Chapter</h4>
@include('tgg-india.layouts.includes.message')
    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.chapters.update', $chapter->id) }}" method="POST">
            @csrf
            @method('PUT')
                <input type="hidden" name="section_id" value="{{$chapter->section->id}}">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input 
                    type="text" 
                    class="form-control @error('title') is-invalid @enderror" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $chapter->title) }}" 
                    placeholder="Enter chapter title" 
                    required
                >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">content</label>
                <textarea 
                    id="description" 
                    name="content" 
                    class="form-control js-ckeditor @error('content') is-invalid @enderror" 
                    rows="5"
                >{!! old('content', $chapter->content) !!}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tgg-india.trainer.chapters.index', ['section_id' => $chapter->section_id]) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
