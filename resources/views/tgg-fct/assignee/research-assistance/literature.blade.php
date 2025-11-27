@extends('tgg-fct.layouts.app')

@section('title', 'Literature - Research Assistance | Tgg Edge | Tgg Fct')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">
            <h2 class="litheader">Literature Resources</h2>

            <div class="table-responsive">
                <ul class="list-group">
                    @forelse ($literature as $item)
                        <li class="list-group-item">
                            <strong>{{ $item['title'] }}</strong><br>
                            {{-- <small>{{ $item['authors'] ?? 'N/A' }} | {{ $item['year'] ?? 'N/A'  }} | {{ $item['source'] ?? 'N/A' }}</small><br> --}}
                            <p>{{ $item['description'] ?? 'N/A' }}</p>
                            {{-- <a href="{{ $item['url'] ?? 'N/A' }}" target="_blank">View</a> --}}
                        </li>
                    @empty
                        <li class="list-group-item litfeildtext">No literature data available.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-4">
                {{ $literature->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
