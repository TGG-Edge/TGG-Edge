@extends('tgg-india.layouts.app')

@section('title', 'Show Product')

@section('content')

<div class="container mt-4">

    <div class="card p-4">

        <h3 class="mb-3">
            {{ $product->title }}
        </h3>

        @if($product->image)

            <img src="{{ asset('storage/'.$product->image) }}"
                 width="150"
                 class="mb-3"
                 style="border-radius:10px; object-fit:cover;">

        @endif

        <div class="row">

            <div class="col-md-6 mb-3">

                <strong>Amount:</strong><br>

                ₹{{ $product->amount }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Stock:</strong><br>

                {{ $product->stock }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Status:</strong><br>

                {{ ucfirst($product->status) }}

            </div>

            <div class="col-md-6 mb-3">

                <strong>Active:</strong><br>

                {{ $product->is_active ? 'Yes' : 'No' }}

            </div>

        </div>

        <hr>

        <h5>Description</h5>

        <div>
            {!! $product->description !!}
        </div>

    </div>

</div>

@endsection