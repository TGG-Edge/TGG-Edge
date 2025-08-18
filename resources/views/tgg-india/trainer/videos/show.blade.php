@extends('tgg-india.layouts.app')

@section('title', 'Show chapter - TGG India')
@section('content')

<div class="container">
    <h2 class="litheader">Video Recommendations</h2>
    <div class="row">
        @forelse ($videos as $video)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <img src="{{ $video['thumbnail'] ?? '#' }}" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ $video['title']?? 'N/A'  }}</h5>
                        <p class="card-text">{!! $video['description']?? 'N/A'  !!}</p>
                        <a href="{{ $video['url'] ?? 'N/A' }}" target="_blank" class="btn btn-primary">Watch</a>
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