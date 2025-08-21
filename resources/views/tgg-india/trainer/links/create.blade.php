@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Create Links | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New Literature</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.links.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control js-ckeditor" rows="5">
                        {!! old('description', $link->description ?? '') !!}
                    </textarea>
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" name="url" class="form-control" id="url" placeholder="https://example.com">
                </div>
                
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>

@endsection
