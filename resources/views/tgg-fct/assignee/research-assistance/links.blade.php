@extends('tgg-fct.layouts.app')

@section('title', 'Links - Research Assistance | Tgg Edge | Tgg Fct')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">
            <h2 class="litheader">Useful Research Links</h2>

            <div class="table-responsive">
                <ul class="list-group">
                    @forelse ($links as $link)
                        <li class="list-group-item">
                            <strong>{{ $link['title'] ?? 'N/A' }}</strong> ({{ $link['type'] ?? 'N/A' }})<br>
                            <a href="{{ $link['url'] ?? 'N/A' }}" target="_blank">{{ $link['url'] ?? 'N/A' }}</a><br>
                            <p>{{ $link['description'] ?? 'N/A' }}</p>
                        </li>
                    @empty
                        <li class="list-group-item litfeildtext">No link data available.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-4">
                {{ $links->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
