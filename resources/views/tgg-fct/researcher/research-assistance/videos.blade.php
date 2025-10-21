@extends('tgg-fct.layouts.app')

@section('title', 'Videos - Research Assistance | Tgg Edge | Tgg Fct')
@section('content')

<div class="container">
    <h2 class="litheader">Video Recommendations</h2>
    <div class="row">
        @forelse ($videos as $video)
            <div class="col-12 col-md-6 mb-3">
                <div class="card h-100">
                    <img src="{{ $video['thumbnail'] ?? '#' }}" class="card-img-top" alt="Thumbnail">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $video['title']?? 'N/A' }}</h5>
                        <p class="card-text flex-grow-1">{{ $video['description']?? 'N/A' }}</p>
                        <a href="{{ $video['url'] ?? 'N/A' }}" target="_blank" class="btn btn-primary mt-auto">Watch</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="litfeildtext">No video data available.</p>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $videos->links() }}
    </div>
</div>

@endsection
