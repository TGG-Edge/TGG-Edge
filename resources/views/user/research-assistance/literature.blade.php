@extends('user.layouts.app')

@section('title', 'Literature - Research Assistance')

@section('content')

<div class="container">
    <h2 class="litheader">Literature Resources</h2>
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
      <div class="mt-4">
        {{ $literature->links() }}
    </div>
</div>

@endsection
