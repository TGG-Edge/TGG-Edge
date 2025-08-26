@extends('tgg-india.layouts.app')

@section('title', 'Show chapter - TGG india')
@section('content')
<div class="container">

    <h2>{{ $chapter->title }}</h2>
    <p>{{ $chapter->content ?? 'No content available.' }}</p>

    <hr>

    <h5>Section: {{ $chapter->section->title ?? '-' }}</h5>
    <h6>Literature: {{ $chapter->section->literature->title ?? '-' }}</h6>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

</div>
@endsection
