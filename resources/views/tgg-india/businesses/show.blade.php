@extends('tgg-india.layouts.app')

@section('title', 'Show Business | TGG Meta | TGG India')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-10 col-12">

            <div class="card p-4 shadow-sm mb-4">

                <div class="text-center mb-4">

                    @if($business->image)

                        <img src="{{ asset('storage/'.$business->image) }}"
                             width="120"
                             height="120"
                             style="object-fit:cover; border-radius:12px;">

                    @endif

                </div>

                <h3 class="mb-3">
                    {{ $business->title }}
                </h3>

                <p>
                    {!! $business->description !!}
                </p>

                <hr>

                <div class="mb-2">
                    <strong>Owner:</strong>
                    {{ $business->owner?->name }}
                </div>

                <div class="mb-2">
                    <strong>Email:</strong>
                    {{ $business->email ?? 'N/A' }}
                </div>

                <div class="mb-2">
                    <strong>Phone:</strong>
                    {{ $business->phone ?? 'N/A' }}
                </div>

                <div class="mb-2">
                    <strong>Website:</strong>
                    {{ $business->website ?? 'N/A' }}
                </div>

                <div class="mb-2">
                    <strong>Status:</strong>
                    {{ ucfirst($business->status) }}
                </div>

                <div class="mb-3">
                    <strong>Address:</strong>
                    {{ $business->address ?? 'N/A' }}
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    Back
                </a>

            </div>

        </div>

    </div>

</div>

@endsection