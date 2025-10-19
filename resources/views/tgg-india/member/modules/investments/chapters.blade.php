@extends('tgg-india.layouts.app')

@section('title', 'Chapters | TGG Meta | TGG India')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">{{ $chapter->title }}</h2>
            @include('tgg-india.layouts.includes.message')
            <div class="mb-4">
                {!! $chapter->content ?? '<p>No content available.</p>' !!}
            </div>

            <hr>

            <h5>Section: {{ $chapter->section->title ?? '-' }}</h5>
            <h6>Literature: {{ $chapter->section->literature->title ?? '-' }}</h6>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
</div>
@endsection
