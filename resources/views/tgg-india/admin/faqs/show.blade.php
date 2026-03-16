@extends('tgg-india.layouts.app')

@section('title', 'Show FAQ | TGG Meta | TGG India')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">

            <div class="card p-4 shadow-sm mb-4">

                <h2 class="litheader">{{ $faq->title }}</h2>

                <p class="mt-2">{!! $faq->description ?? 'No answer available.' !!}</p>

                <hr>

                <div class="mb-3">
                    <h6>
                        <strong>Category:</strong>
                        {{ $faq->category?->title ?? '-' }}
                    </h6>

                    <h6>
                        <strong>Status:</strong>
                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                    </h6>

                    <h6>
                        <strong>Created By:</strong>
                        {{ $faq->creator?->name ?? '-' }}
                    </h6>
                </div>

                <a href="{{ url()->previous() }}"
                   class="btn btn-secondary w-100 w-md-auto">
                    Back
                </a>

            </div>

        </div>
    </div>
</div>

@endsection
