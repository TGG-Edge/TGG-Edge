@extends('tgg-india.layouts.app')

@section('title', 'Create Links | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">
    <h4 class="mb-3 trainer-heading">Create New Literature</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.trainer.links.store') }}" method="POST">
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
                >{!! old('description', $link->description ?? '') !!}</textarea>
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
                >
            </div>

            <!-- Submit -->
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
