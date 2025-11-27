@extends('tgg-india.layouts.app')

@section('title', 'Show Chapters | TGG Meta | TGG India')

@section('content')
<div class="container my-4">
    <h2 class="litheader">{{ $chapter->title }}</h2>

    @include('tgg-india.layouts.includes.message')

    <div class="card mb-3">
        <div class="card-body">
            <p>{!! $chapter->content ?? 'No content available.' !!}</p>
        </div>
    </div>

    <div class="mb-3">
        <h5>Section: {{ $chapter->section->title ?? '-' }}</h5>
        <h6>Literature: {{ $chapter->section->literature->title ?? '-' }}</h6>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
</div>
@endsection
