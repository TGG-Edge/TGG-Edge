@extends('user.layouts.app')

@section('title', 'LinkedIn - Research Assistance')
@section('content')

<div class="container">
    <h2 class="litheader">Relevant LinkedIn Profiles</h2>
    <ul class="list-group">
        @forelse ($linkedin as $profile)
            <li class="list-group-item">
                <strong>{{ $profile['name'] ?? 'N/A' }}</strong> - {{ $profile['title'] ?? 'N/A' }}<br>
                {{ $profile['institution'] ?? 'N/A' }}<br>
                <a href="{{ $profile['linkedin_url'] ?? 'N/A' }}" target="_blank">View Profile</a><br>
                Expertise: {{ $profile['expertise']?? 'N/A'  }}<br>
                Relevance: {{ $profile['relevance'] ?? 'N/A' }}
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