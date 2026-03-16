@extends('tgg-india.layouts.app')

@section('title','View FAQ Category')

@section('content')
<div class="admin-container">

    <div class="card p-4">

        <h4>{{ $faq_category->title }}</h4>
        <hr>

        <p>{{ $faq_category->description ?? 'No description available.' }}</p>

        <strong>Status:</strong>
        {{ $faq_category->is_active ? 'Active' : 'Inactive' }}

        <br><br>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            Back
        </a>

    </div>

</div>
@endsection
