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
                    <div class="slider" id="woodpecker-slider" aria-label="Woodpecker image slider">
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
                <div class="slider-outer card-inner">
                    <div class="slider" id="tgg-news-slider">
                        @if(!empty($showcase->tgg_news))
                            @foreach($showcase->tgg_news as $news)
                                <div class="slide">
                                    <iframe width="100%" height="220" src="{{ $news }}" 
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @endforeach
                        @else
                            <div class="slide"><p>No news available</p></div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card center-box">
                <h3 class="card-title">TRAVEL UPDATE AND EVENTS</h3>
                <div class="slider-outer card-inner">
                    <div class="slider" id="travel-slider">
                        @if(!empty($showcase->travel_and_events))
                            @foreach($showcase->travel_and_events as $event)
                                <div class="slide">
                                    <img src="{{ asset($event) }}" alt="Event Image"/>
                                </div>
                            @endforeach
                        @else
                            <div class="slide"><p>No events available</p></div>
                        @endif
                    </div>
                </div>
            </div>

        </section>

        <!-- Bottom Row -->
        <section class="row">
            <div class="card center-box">
                <h3 class="card-title">TGG HOMES</h3>
                <div class="slider-outer card-inner">
                    <div class="slider" id="homes-slider">
                        @if(!empty($showcase->tgg_homes))
                            @foreach($showcase->tgg_homes as $home)
                                <div class="slide">
                                    <img src="{{ asset($home) }}" alt="Home Image"/>
                                </div>
                            @endforeach
                        @else
                            <div class="slide"><p>No homes available</p></div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card opportunities">
                <h3 class="card-title">INVESTMENT OPPORTUNITIES</h3>

                @if(!empty($showcase->investment_opportunities))
                    @foreach($showcase->investment_opportunities as $key => $investment)
                        <div class="project-row">
                            <label class="project-left">
                                <input type="radio" name="investment"/>
                                <span>{{ $investment }}</span>
                            </label>
                            <button class="btn-outline">INVEST</button>
                        </div>
                    @endforeach
                @else
                    <p>No investment opportunities</p>
                @endif
            </div>

        </section>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    function initSlider(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;

        const slides = slider.querySelectorAll(".slide");
        let index = 0;
        let autoSlideInterval;

        function autoSlide() {
            index = (index + 1) % slides.length;
            slider.scrollTo({
                left: slider.clientWidth * index,
                behavior: "smooth"
            });
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideInterval = setInterval(autoSlide, 3000); // 3 sec
        }

        function stopAutoSlide() {
            if (autoSlideInterval) clearInterval(autoSlideInterval);
        }

        slider.addEventListener("scroll", () => {
            const newIndex = Math.round(slider.scrollLeft / slider.clientWidth);
            index = newIndex;
            stopAutoSlide();
            startAutoSlide();
        });

        startAutoSlide();
    }

    // Initialize all sliders
    initSlider("woodpecker-slider");
    initSlider("tgg-news-slider");
    initSlider("travel-slider");
    initSlider("homes-slider");

});
</script>

@endsection
