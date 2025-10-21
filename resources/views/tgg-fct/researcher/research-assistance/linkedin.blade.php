@extends('tgg-fct.layouts.app')

@section('title', 'LinkedIn - Research Assistance | Tgg Edge | Tgg Fct')
@section('content')

<div class="container">
    <h2 class="litheader">Relevant LinkedIn Profiles</h2>
    <ul class="list-group">
        @forelse ($linkedin as $profile)
            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start">
                <div class="mb-2 mb-md-0">
                    <strong>{{ $profile['name'] ?? 'N/A' }}</strong> - {{ $profile['title'] ?? 'N/A' }}<br>
                    {{ $profile['institution'] ?? 'N/A' }}<br>
                    Expertise: {{ $profile['expertise'] ?? 'N/A'  }}<br>
                    Relevance: {{ $profile['relevance'] ?? 'N/A' }}
                </div>
                <div class="mt-2 mt-md-0">
                    <a href="{{ $profile['linkedin_url'] ?? 'N/A' }}" target="_blank" class="btn btn-sm btn-primary">View Profile</a>
                </div>
            </li>
        @empty
            <li class="list-group-item litfeildtext">No LinkedIn data available.</li>
        @endforelse
    </ul>
    <div class="mt-4">
        {{ $linkedin->links() }}
    </div>
</div>

@endsection
