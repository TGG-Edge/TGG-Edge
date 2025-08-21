
@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Create Chapters | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New chapter</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.chapters.store') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{request()->section_id}}">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           id="title" 
                           value="{{ old('title', $chapter->title ?? '') }}"
                           placeholder="Enter title">
                </div>
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>
@endsection
