@extends('tgg-india.layouts.app')

@section('title', 'Admin Dashbaord | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 showcase-heading">Edit Showcase</h4>
    @include('tgg-india.layouts.includes.message')

    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    <div class="card p-3 mb-4">

        <form action="{{ route('tgg-india.admin.showcases.update') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <!-- WELCOME NOTE -->
        <div class="mb-3">
            <label for="welcome_note" class="form-label">Welcome Note</label>
            <textarea id="welcome_note" name="welcome_note" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note', $showcase?->welcome_note ?? '') !!}
            </textarea>
        </div>

         <div class="mb-3">
            <label for="welcome_note_trainer" class="form-label">Welcome Note For Trainer</label>
            <textarea id="welcome_note_trainer" name="welcome_note_trainer" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_trainer', $showcase?->welcome_note_trainer ?? '') !!}
            </textarea>
        </div>

         <div class="mb-3">
            <label for="welcome_note_member" class="form-label">Welcome Note For Member</label>
            <textarea id="welcome_note_member" name="welcome_note_member" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_member', $showcase?->welcome_note_member ?? '') !!}
            </textarea>
        </div>

         <div class="mb-3">
            <label for="welcome_note_rhm_club" class="form-label">Welcome Note For Rhm Club</label>
            <textarea id="welcome_note_rhm_club" name="welcome_note_rhm_club" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_rhm_club', $showcase?->welcome_note_rhm_club ?? '') !!}
            </textarea>
        </div>

         <div class="mb-3">
            <label for="welcome_note_nomad_community" class="form-label">Welcome Note For Nomad Community</label>
            <textarea id="welcome_note_nomad_community" name="welcome_note_nomad_community" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_nomad_community', $showcase?->welcome_note_nomad_community ?? '') !!}
            </textarea>
        </div>

        <div class="mb-3">
            <label for="welcome_note_freelancer" class="form-label">Welcome Note For Freelancer</label>
            <textarea id="welcome_note_freelancer" name="welcome_note_freelancer" class="form-control js-ckeditor" rows="5">
                {!! old('welcome_note_freelancer', $showcase?->welcome_note_freelancer ?? '') !!}
            </textarea>
        </div>

        <!-- ENTREPRENEURSHIP -->
        <div class="mb-3">
            <label for="entrepreneurship_opportunities" class="form-label">Entrepreneurship Opportunities (comma separated)</label>
            <input type="text" name="entrepreneurship_opportunities"
                class="form-control"
                value="{{ old('entrepreneurship_opportunities', implode(',', $showcase->entrepreneurship_opportunities ?? [])) }}">
        </div>

        <!-- IMAGE FIELDS -->
    @foreach(['woodpecker_collection' => 'Woodpecker Collection', 'travel_and_events' => 'Travel & Events', 'tgg_homes' => 'TGG Homes'] as $field => $label)
        <div class="mb-3">
            <label for="{{ $field }}" class="form-label">{{ $label }} (Upload Multiple Images)</label>
            <input type="file" id="{{ $field }}" name="{{ $field }}[]" class="form-control" multiple>

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
            <label for="tgg_news" class="form-label">TGG News (YouTube URLs, comma separated)</label>
            <input type="text" name="tgg_news"
                class="form-control"
                value="{{ old('tgg_news', implode(',', $showcase->tgg_news ?? [])) }}">
        </div>

        <!-- INVESTMENT -->
        <div class="form-group">
            <label for="investment_opportunities" class="form-label">Investment Opportunities (comma separated)</label>
            <input type="text" name="investment_opportunities"
                class="form-control"
                value="{{ old('investment_opportunities', implode(',', $showcase->investment_opportunities ?? [])) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Showcase</button>
    </form>

</div>

</div>
@endsection
