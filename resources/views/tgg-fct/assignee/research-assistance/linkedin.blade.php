@extends('tgg-fct.layouts.app')

@section('title', 'LinkedIn - Research Assistance | Tgg Edge | Tgg Fct')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">
            <h2 class="litheader">Relevant LinkedIn Profiles</h2>

            <div class="table-responsive">
                <ul class="list-group">
                    @forelse ($linkedin as $profile)
                        <li class="list-group-item">
                            <strong>{{ $profile['name'] ?? 'N/A' }}</strong> - {{ $profile['title'] ?? 'N/A' }}<br>
                            {{ $profile['institution'] ?? 'N/A' }}<br>
                            <a href="{{ $profile['linkedin_url'] ?? 'N/A' }}" target="_blank">View Profile</a><br>
                            Expertise: {{ $profile['expertise'] ?? 'N/A' }}<br>
                            Relevance: {{ $profile['relevance'] ?? 'N/A' }}
                        </li>
                    @empty
                        <li class="list-group-item litfeildtext">No LinkedIn data available.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-4">
                {{ $linkedin->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
