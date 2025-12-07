@extends('tgg-india.layouts.app')

@section('title', 'Show Assignment | TGG Meta | TGG India')
@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">

            <div class="card p-4 shadow-sm mb-4">
                <h2 class="litheader">{{ $chapter->title }}</h2>

                <p class="mt-2">{{ $chapter->content ?? 'No content available.' }}</p>
                <hr>

                <div class="mb-3">
                    <h5 class="mb-1">
                        <strong>Section:</strong> {{ $chapter->section->title ?? '-' }}
                    </h5>
                    <h6 class="mb-3">
                        <strong>Literature:</strong> {{ $chapter->section->literature->title ?? '-' }}
                    </h6>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary w-100 w-md-auto">
                    Back
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
