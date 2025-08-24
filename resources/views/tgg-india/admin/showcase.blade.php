@extends('tgg-india.layouts.app')

@section('title', 'Admin Dashbaord | TGG Meta | TGG India')

@section('content')
<div class="container">
    <h2>Edit Showcase</h2>
    @include('tgg-india.layouts.includes.message')

    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- WELCOME NOTE -->
    <div class="mb-3">
        <label for="welcome_note" class="form-label">Welcome Note</label>
        <textarea id="welcome_note" name="welcome_note" class="form-control js-ckeditor" rows="5">
            {!! old('welcome_note', $showcase?->welcome_note ?? '') !!}
        </textarea>
    </div>

    <!-- ENTREPRENEURSHIP -->
    <div class="form-group">
        <label>Entrepreneurship Opportunities (comma separated)</label>
        <input type="text" name="entrepreneurship_opportunities"
               class="form-control"
               value="{{ old('entrepreneurship_opportunities', implode(',', $showcase->entrepreneurship_opportunities ?? [])) }}">
    </div>

    <!-- IMAGE FIELDS -->
    @foreach(['woodpecker_collection' => 'Woodpecker Collection', 'travel_and_events' => 'Travel & Events', 'tgg_homes' => 'TGG Homes'] as $field => $label)
        <div class="form-group">
            <label>{{ $label }} (Upload Multiple Images)</label>
            <input type="file" name="{{ $field }}[]" class="form-control" multiple>
            <div class="mt-2 d-flex flex-wrap">
                @foreach($showcase->$field ?? [] as $img)
                    <div class="position-relative m-1">
                        <img src="{{ $img }}" width="100" class="rounded shadow">
                        <label class="d-block text-center small mt-1">
                            <input type="checkbox" name="remove_{{ $field }}[]" value="{{ $img }}"> Remove
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- TGG NEWS -->
    <div class="form-group">
        <label>TGG News (YouTube URLs, comma separated)</label>
        <input type="text" name="tgg_news"
               class="form-control"
               value="{{ old('tgg_news', implode(',', $showcase->tgg_news ?? [])) }}">
    </div>

    <!-- INVESTMENT -->
    <div class="form-group">
        <label>Investment Opportunities (comma separated)</label>
        <input type="text" name="investment_opportunities"
               class="form-control"
               value="{{ old('investment_opportunities', implode(',', $showcase->investment_opportunities ?? [])) }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Showcase</button>
</form>

</div>
@endsection
