@extends('tgg-fct.layouts.app')

@section('title', 'Links - Research Assistance | Tgg Edge | Tgg Fct')
@section('content')

<div class="container">
    <h2 class="litheader">Useful Research Links</h2>
    <ul class="list-group">
        @forelse ($links as $link)
            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start">
                <div class="mb-2 mb-md-0">
                    <strong>{{ $link['title']?? 'N/A'  }}</strong> ({{ $link['type'] ?? 'N/A' }})<br>
                    <p>{{ $link['description']?? 'N/A'  }}</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ $link['url'] ?? 'N/A' }}" target="_blank" class="btn btn-sm btn-primary">{{ $link['url'] ?? 'N/A' }}</a>
                </div>
            </li>
        @empty
            <li class="list-group-item litfeildtext">No link data available.</li>
        @endforelse
    </ul>
    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>

@endsection
