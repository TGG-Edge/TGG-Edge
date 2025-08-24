@extends('tgg-india.layouts.app')

@section('title', 'Dashboard | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    @include('tgg-india.layouts.includes.message')

    <main class="dashboard-main">
        <!-- Welcome Note -->
        <section class="welcome-note card">
            <p>
                {{ $showcase->welcome_note ?? 'Welcome to the Volunteer Dashboard! Explore the Woodperker
                collections, review entrepreneurship opportunities, and keep an eye on
                the latest updates below.' }}
            </p>
        </section>

        <!-- Top Row -->
        <section class="row top-row">
            <!-- Woodperker -->
            <div class="card woodperker">
                <h3 class="card-title">WOODPERKER COLLECTIONS</h3>

                <div class="slider-outer card-inner">
                    <div class="slider" aria-label="Woodperker image slider">
                        @if(!empty($showcase->woodpecker_collection))
                            @foreach($showcase->woodpecker_collection as $img)
                                <div class="slide">
                                    <img src="{{ asset($img) }}" alt="Woodpecker image"/>
                                </div>
                            @endforeach
                        @else
                            <div class="slide"><p>No images available</p></div>
                        @endif
                    </div>
                </div>

                <button class="btn-outline small">checkout</button>
            </div>

            <!-- Opportunities -->
            <div class="card opportunities">
                <h3 class="card-title">ENTREPRENEURSHIP OPPORTUNITIES</h3>

                @if(!empty($showcase->entrepreneurship_opportunities))
                    @foreach($showcase->entrepreneurship_opportunities as $key => $opportunity)
                        <div class="project-row">
                            <label class="project-left">
                                <input type="radio" name="project"/>
                                <span>{{ $opportunity }}</span>
                            </label>
                            <button class="btn-outline">GO</button>
                        </div>
                    @endforeach
                @else
                    <p>No opportunities available</p>
                @endif
            </div>
        </section>

        <!-- Middle Row -->
        <section class="row">
            <div class="card center-box">
                <h3 class="card-title">TGG NEWS</h3>
                @if(!empty($showcase->tgg_news))
                    @foreach($showcase->tgg_news as $news)
                        <div class="news-item">
                            <iframe width="100%" height="200" src="{{ $news }}" frameborder="0"  
                                frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
    allowfullscreen
    ></iframe>
                        </div>
                    @endforeach
                @else
                    <p>No news available</p>
                @endif
            </div>
            <div class="card center-box">
                <h3 class="card-title">TRAVEL UPDATE AND EVENTS</h3>
                @if(!empty($showcase->travel_and_events))
                    @foreach($showcase->travel_and_events as $event)
                        <img src="{{ asset($event) }}" width="100%" alt="Event Image"/>
                    @endforeach
                @else
                    <p>No events available</p>
                @endif
            </div>
        </section>

        <!-- Bottom Row -->
        <section class="row">
            <div class="card center-box">
                <h3 class="card-title">TGG HOMES</h3>
                @if(!empty($showcase->tgg_homes))
                    @foreach($showcase->tgg_homes as $home)
                        <img src="{{ asset($home) }}" width="100%" alt="Home Image"/>
                    @endforeach
                @else
                    <p>No homes available</p>
                @endif
            </div>
            <div class="card center-box">
                <h3 class="card-title">INVESTMENT OPPORTUNITIES</h3>
                @if(!empty($showcase->investment_opportunities))
                    <ul>
                        @foreach($showcase->investment_opportunities as $investment)
                            <li>{{ $investment }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No investment opportunities</p>
                @endif
            </div>
        </section>
    </main>
</div>
@endsection
