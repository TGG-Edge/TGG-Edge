@extends('tgg-india.layouts.app')

@section('title', 'Admin Dashbaord | TGG Meta | TGG India')

@section('content')
<div class="container">
    <h3>Edit Showcase: {{ ucfirst(str_replace('_',' ',$section)) }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tgg-india.admin.showcases.update', $section) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Welcome Note --}}
        @if($section == 'welcome_note')
            <textarea name="welcome_note" class="form-control" rows="5">{{ $showcase->welcome_note }}</textarea>
        @endif

        {{-- Entrepreneurship (multiple text) --}}
        @if($section == 'entrepreneurship')
            <div id="entrepreneurship-wrapper">
                @foreach($showcase->entrepreneurship_opportunities ?? [] as $text)
                    <input type="text" name="entrepreneurship_opportunities[]" value="{{ $text }}" class="form-control mb-2">
                @endforeach
                <button type="button" class="btn btn-sm btn-primary" onclick="addField('entrepreneurship-wrapper','entrepreneurship_opportunities[]')">+ Add</button>
            </div>
        @endif

        {{-- Woodpecker / Travel / Homes (multiple image URLs) --}}
        @if(in_array($section, ['woodpecker','travel','homes']))
            <div id="image-wrapper">
                @foreach($showcase->{ $section == 'woodpecker' ? 'woodpecker_collection' : ($section == 'travel' ? 'travel_and_events' : 'tgg_homes') } ?? [] as $img)
                    <input type="text" name="{{ $section }}[]" value="{{ $img }}" class="form-control mb-2" placeholder="Image URL">
                @endforeach
                <button type="button" class="btn btn-sm btn-primary" onclick="addField('image-wrapper','{{ $section }}[]')">+ Add</button>
            </div>
        @endif

        {{-- TGG News (multiple YouTube URLs) --}}
        @if($section == 'news')
            <div id="news-wrapper">
                @foreach($showcase->tgg_news ?? [] as $url)
                    <input type="text" name="tgg_news[]" value="{{ $url }}" class="form-control mb-2" placeholder="YouTube URL">
                @endforeach
                <button type="button" class="btn btn-sm btn-primary" onclick="addField('news-wrapper','tgg_news[]')">+ Add</button>
            </div>
        @endif

        {{-- Investment Opportunities (multiple text) --}}
        @if($section == 'investment')
            <div id="investment-wrapper">
                @foreach($showcase->investment_opportunities ?? [] as $item)
                    <input type="text" name="investment_opportunities[]" value="{{ $item }}" class="form-control mb-2">
                @endforeach
                <button type="button" class="btn btn-sm btn-primary" onclick="addField('investment-wrapper','investment_opportunities[]')">+ Add</button>
            </div>
        @endif

        <br>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>
function addField(wrapperId, fieldName) {
    let wrapper = document.getElementById(wrapperId);
    let input = document.createElement("input");
    input.type = "text";
    input.name = fieldName;
    input.className = "form-control mb-2";
    wrapper.insertBefore(input, wrapper.lastElementChild);
}
</script>
@endsection
