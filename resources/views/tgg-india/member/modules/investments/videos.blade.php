@extends('tgg-india.layouts.app')

@section('title', 'Show videos | TGG Meta | TGG India')
@section('content')

<div class="container my-4">
    <h2 class="litheader mb-4">Video Recommendations</h2>
    @include('tgg-india.layouts.includes.message')

    <div class="row">
        @forelse ($videos as $video)
            <div class="col-12 col-sm-6 col-md-6 mb-3">
                <div class="card h-100">
                    @php
                        $imageSrc = Str::startsWith($video->image, ['http://', 'https://']) 
                            ? $video->image 
                            : asset('storage/app/public/' . $video->image);
                    @endphp
                    <img src="{{ $imageSrc ?? 'assets/images/no-thumb.png' }}" class="card-img-top" 
                         style="height: 250px; object-fit: cover;" alt="Thumbnail">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $video['title'] ?? 'N/A' }}</h5>
                        <p class="card-text">{!! $video['description'] ?? 'N/A' !!}</p>
                        <a href="{{ $video['url'] ?? '#' }}" target="_blank" class="btn btn-primary mt-auto">Watch</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center litfeildtext">
                    No video data available.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $videos->links() }}
    </div>
</div>

@endsection
