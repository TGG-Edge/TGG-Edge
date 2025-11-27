@extends('tgg-fct.layouts.app')

@section('title', 'Literature - Research Assistance | Tgg Edge | Tgg Fct')

@section('content')

<div class="container">
    <h2 class="litheader">Literature Resources</h2>
    <ul class="list-group">
        @forelse ($literature as $item)
            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start">
                <div class="mb-2 mb-md-0">
                    <strong>{{ $item['title'] }}</strong><br>
                    {{-- <small>{{ $item['authors'] ?? 'N/A' }} | {{ $item['year'] ?? 'N/A'  }} | {{ $item['source'] ?? 'N/A' }}</small><br> --}}
                    <p>{{ $item['description'] ?? 'N/A' }}</p>
                </div>
                {{-- <div class="mt-2 mt-md-0">
                    <a href="{{ $item['url'] ?? 'N/A' }}" target="_blank" class="btn btn-sm btn-primary">View</a>
                </div> --}}
            </li>
        @empty
            <li class="list-group-item litfeildtext">No literature data available.</li>
        @endforelse
    </ul>
      <div class="mt-4">
        {{ $literature->links() }}
    </div>
</div>

@endsection
