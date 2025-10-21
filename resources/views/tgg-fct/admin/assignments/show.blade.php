@extends('tgg-fct.layouts.app')

@section('title', 'Show Assignment | TGG Edge | TGG fct')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm p-4">
                <h2 class="mb-3 text-center">{{ $chapter->title }}</h2>
                <p class="mb-4">{{ $chapter->content ?? 'No content available.' }}</p>
                <hr>
                <div class="mb-3">
                    <h5>Section: <span class="fw-normal">{{ $chapter->section->title ?? '-' }}</span></h5>
                    <h6>Literature: <span class="fw-normal">{{ $chapter->section->literature->title ?? '-' }}</span></h6>
                </div>
                <div class="text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
