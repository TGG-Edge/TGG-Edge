@extends('tgg-india.layouts.app')

@section('title', 'Dashboard | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    @include('tgg-india.layouts.includes.message')

    <main class="dashboard-main">
          <!-- Top Row -->
    <section class="row top-row">

        <div class="dashboard-grid-welcome">

            <!-- Welcome Note (spans 2 columns) -->
            <section class="welcome-note card">
                <div class="card-inner-welcome">
                    <p>
                        {{ $showcase->welcome_note ?? 'Welcome to the Volunteer Dashboard! Explore the Woodperker
                        collections, review entrepreneurship opportunities, and keep an eye on
                        the latest updates below.' }}
                    </p>
                </div>
            </section>
        </div>
        <br>

        <div class="dashboard-grid">

            <!-- Example: Modicare -->
            <!-- Modicare -->
            <div class="card">
                <h3 class="card-title">MODICARE</h3>
                <div class="card-inner">
                    <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Modicare Logo" class="card-img" width="300" height="150">
                </div>
                <div class="button-group">
                    <button class="btn-outline small">Login</button>
                    <button class="btn-outline small info-btn">Information</button>
                </div>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <p>This is information for Modicare</p>
                    </div>
                </div>
            </div>

            <!-- Motilal -->
            <div class="card">
                <h3 class="card-title">MOTILAL OSWAL</h3>
                <div class="card-inner">
                    <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Modicare Logo" class="card-img" width="300" height="150" >
                </div>
                <div class="button-group">
                    <button class="btn-outline small">Login</button>
                    <button class="btn-outline small info-btn">Information</button>
                </div>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <p>This is information for Motilal</p>
                    </div>
                </div>
            </div>

            <!-- Woodperker -->
            <div class="card woodperker">
                <h3 class="card-title">MODICARE</h3>

                <div class="slider-outer card-inner">
                    <div class="slider" id="#" aria-label="Woodpecker image slider">
                                <div class="slide">
                                    <img src="{{ asset('assets/tgg-india/images/modicare.jpeg') }}" alt="modicare image"/>
                                </div>
                    </div>
                </div>
                <div style="display: flex; gap: 5px; align-items: center;">
                    <a href="https://www.modicare.com/sign-in" 
                        style=" color: #ffffff;" class="btn-outline small">
                        Login
                    </a>
                    <a href="#"
                        style=" color: #ffffff;" class="btn-outline small">
                        Information
                    </a>
                </div>

            </div>

            <!-- Opportunities -->
            <div class="card opportunities">
                <h3 class="card-title">INVESTMENT MOTILALOSAWAL</h3>
                         <div class="slider-outer card-inner">
                    <div class="slider" id="#" aria-label="Woodpecker image slider">
                                <div class="slide">
                                    <img src="{{ asset('assets/tgg-india/images/motilal.jpeg') }}" alt="motilal image"/>
                                </div>
                    </div>
                </div>
                  <div style="display: flex; gap: 5px; align-items: center;">
                    <a href="https://invest.motilaloswal.com/" 
                        style=" color: #ffffff;" class="btn-outline small">
                        Login
                    </a>
                    <a href="#" title=" If you don’t have an account, register first"
                        style=" color: #ffffff;" class="btn-outline small">
                        Information
                    </a>
                </div>

            </div>
    </section>
        
        <!-- Top Row -->
        {{-- <section class="row top-row">
            <!-- Woodperker -->
            <div class="card woodperker">
                <h3 class="card-title">WOODPERKER COLLECTIONS</h3>
                <div class="card-inner">
                    @if(!empty($showcase->woodpecker_collection))
                        @foreach($showcase->woodpecker_collection as $img)
                            <img src="{{ asset($img) }}" alt="Woodpecker image" class="card-img"/>
                        @endforeach
                    @else
                        <img src="{{ asset('assets/tgg-india/images/resized.jpg') }}" alt="Dummy Image" class="card-img" />
                    @endif
                </div>

                <div class="button-group">
                    <button class="btn-outline small checkout-btn">Checkout</button>
                </div>

                <!-- Checkout Modal -->
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <p>This is the checkout popup for Woodperker Collections</p>
                    </div>
                </div>
            </div>


            <!-- Entrepreneurship Opportunities -->
            <!-- <div class="card opportunities">
                <h3 class="card-title">ENTREPRENEURSHIP OPPORTUNITIES</h3>
                <div class="card-inner">
                    @if(!empty($showcase->entrepreneurship_opportunities))
                        @foreach($showcase->entrepreneurship_opportunities as $opportunity)
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
            </div> -->

            <!-- TGG News -->
            <div class="card">
            <h3 class="card-title">TGG NEWS</h3>
            <div class="card-inner">
                @if(!empty($showcase->tgg_news))
                    @foreach($showcase->tgg_news as $news)
                        <iframe width="100%" height="200" src="{{ $news }}" 
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    @endforeach
                @else
                    <p>No news available</p>
                @endif
            </div>
        </section> --}}

        <!-- Middle Row -->
        <section class="row">
            <div class="card center-box">
                <h3 class="card-title">TGG NEWS</h3>
                <div class="slider-outer card-inner">
                    <div class="slider" id="tgg-news-slider">
                        @if(!empty($showcase->tgg_news))
                            @foreach($showcase->tgg_news as $news)
                                <div class="slide">
                                    <iframe width="100%" height="220" src="{{ getEmbedUrl($news) }}" 
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
        </div>


            <!-- Travel -->
            <div class="card">
                <h3 class="card-title">TRAVEL UPDATE AND EVENTS</h3>
                <div class="card-inner">
                    <div class="slider">
                        @if(!empty($showcase->travel_and_events) && count($showcase->travel_and_events) > 0)
                            @foreach($showcase->travel_and_events as $event)
                                <div class="slide">
                                    <img src="{{ asset($event) }}" alt="Event Image" class="card-img" />
                                </div>
                            @endforeach
                        @else
                            {{-- Dummy multiple images --}}
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/WOODPERKER.jpg') }}" alt="Dummy 3" class="card-img" />
                            </div>
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Dummy 1" class="card-img" />
                            </div>
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Dummy 2" class="card-img"/>
                            </div>
                        @endif
                    </div>
                </div>

            </div>


                <div class="button-group">
                    <button class="btn-outline small checkout-btn">Checkout</button>
                </div>

                <!-- Checkout Modal -->
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <p>This is the checkout popup for Travel Update and Events</p>
                    </div>
                </div>
            </div>



        <!-- Bottom Row -->
        {{-- <section class="row">
            <div class="card center-box">

            <!-- TGG Homes -->
            <!-- <div class="card">
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
            </div> -->

            <!-- Investment Opportunities -->
            <!-- <div class="card opportunities">
                <h3 class="card-title">INVESTMENT OPPORTUNITIES</h3>
                <div class="card-inner">
                    @if(!empty($showcase->investment_opportunities))
                        @foreach($showcase->investment_opportunities as $investment)
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
            </div> --}}

            <!-- TGG Foundation -->
            <div class="card">
                <h3 class="card-title">TGG FOUNDATION</h3>
                <div class="card-inner">
                    <div class="slider">
                        @if(!empty($showcase->tgg_foundation) && count($showcase->tgg_foundation) > 0)
                            @foreach($showcase->tgg_foundation as $item)
                                <div class="slide">
                                    <img src="{{ asset($item) }}" alt="TGG Foundation Image" class="card-img"/>
                                </div>
                            @endforeach
                        @else
                            {{-- Dummy multiple images --}}
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/WOODPERKER.jpg') }}" alt="Dummy Foundation 3" class="card-img" />
                            </div>
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Dummy Foundation 1" class="card-img"/>
                            </div>
                            <div class="slide">
                                <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Dummy Foundation 2" class="card-img"/>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="button-group">
                    <button class="btn-outline small checkout-btn">Checkout</button>
                </div>

                <!-- Checkout Modal -->
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <p>This is the checkout popup for TGG Foundation</p>
                    </div>
                </div>
            </div>


      {{--  </section> --}}

        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    // ==========================
    // Modal handling
    // ==========================
    // Open the correct modal when any trigger button is clicked
    document.querySelectorAll('.info-btn, .checkout-btn').forEach(button => {
        button.addEventListener('click', () => {
            const card = button.closest('.card');       // find parent card
            const modal = card.querySelector('.modal'); // modal inside this card
            if (modal) modal.style.display = 'flex';
        });
    });

    // Close modal when X is clicked
    document.querySelectorAll('.modal .close-btn').forEach(close => {
        close.addEventListener('click', () => {
            close.closest('.modal').style.display = 'none';
        });
    });

    // Close modal when clicking outside modal-content
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });

    // ==========================
    // Auto slider handling
    // ==========================
    document.addEventListener('DOMContentLoaded', () => {
    const INTERVAL = 2000; // 2 seconds

    document.querySelectorAll('.slider').forEach(slider => {
        const slides = slider.querySelectorAll('.slide');
        if (slides.length <= 1) return;

        let index = 0;

        const goTo = i => {
            slider.scrollTo({ left: slider.clientWidth * i, behavior: 'smooth' });
        };

        setInterval(() => {
            index = (index + 1) % slides.length;
            goTo(index);
        }, INTERVAL);
    });
});
</script>
@endpush

