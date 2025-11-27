@extends('tgg-india.layouts.app')

@section('title', 'Show Links | TGG Meta | TGG India')
@section('content')

<div class="container my-4">
    <h2 class="litheader mb-4">Useful Research Links</h2>
    @include('tgg-india.layouts.includes.message')

    <div class="row">
        @forelse ($links as $link)
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-1">
                            <strong>{{ $link->title ?? 'N/A' }}</strong>
                        </h6>
                        {{-- <p class="text-muted small mb-2">
                            {{ $link->type ?? 'N/A' }}
                        </p> --}}
                        <a href="{{ $link->url ?? '#' }}" target="_blank" 
                           class="small text-primary d-block mb-2 text-truncate"
                           title="{{ $link->url }}">
                            {{ $link->url ?? 'N/A' }}
                        </a>
                        <div class="card-text small text-secondary">
                            {!! $link->description ?? 'N/A' !!}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center litfeildtext">
                    No link data available.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>

@endsection
