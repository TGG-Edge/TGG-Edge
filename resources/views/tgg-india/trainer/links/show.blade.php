@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Show Links | TGG Meta | TGG India')
@section('content')

<div class="container">
    <h2 class="litheader">Useful Research Links</h2>
    <ul class="list-group">
        @forelse ($links as $link)
            <li class="list-group-item">
                <strong>{{ $link->title?? 'N/A'  }}</strong> ({{ $link->type  ?? 'N/A' }})<br>
                <a href="{{ $link->url  ?? 'N/A' }}" target="_blank">{{ $link->url  ?? 'N/A' }}</a><br>
                <p>{!! $link->description ?? 'N/A'  !!}</p>
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
