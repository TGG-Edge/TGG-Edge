@extends('tgg-india.layouts.app')

@section('title', 'Chapter - ' . $chapter->title)

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Chapter: {{ $chapter->title }}</h4>

    <div class="card mb-3 p-3">
        <h5 class="mb-2">{{ $chapter->title }}</h5>
        <p>{{ $chapter->content ?? 'No content available for this chapter.' }}</p>
    </div>

    <div class="card mb-3 p-3">
        <p><strong>Section:</strong> {{ $chapter->section->title ?? '-' }}</p>
        <p><strong>Literature:</strong> {{ $chapter->section->literature->title ?? '-' }}</p>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex justify-content-between">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        @if($chapter->next())
            <a href="{{ route('chapters.show', $chapter->next()->id) }}" class="btn btn-primary">
                Next <i class="bi bi-arrow-right"></i>
            </a>
        @endif
    </div>
</div>
@endsection
