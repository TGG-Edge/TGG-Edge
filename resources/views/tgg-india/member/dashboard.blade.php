@extends('tgg-india.layouts.app')

@section('title', 'Dashboard | TGG Meta | TGG India')


@section('content')
    <div class="admin-container">
        @include('tgg-india.layouts.includes.message')

        <main class="dashboard-main">

            <!-- Section 1: Welcome + Modicare & Motilal -->
            <section class="mb-4 row  ">
                <div class="dashboard-grid-welcome">
                    <section class="mb-4 welcome-note card">
                        <div class="card-inner-welcome">
                            <p>
                                {!! $showcase->welcome_note ??
                                    'Welcome to the Volunteer Dashboard! Explore the Woodperker
                                                            collections, review entrepreneurship opportunities, and keep an eye on
                                                            the latest updates below.' !!}
                            </p>
                        </div>
                    </section>
                </div>
                <br>

                <div class="dashboard-grid">
                    <!-- Modicare -->
                    <div class="card">
                        <h3 class="card-title">MODICARE</h3>
                        <div class="card-inner">
                            <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Modicare Logo"
                                class="card-img" width="300" height="150">
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
                            <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Motilal Logo"
                                class="card-img" width="300" height="150">
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
                </div>
            </section>

            <!-- Section 2: Woodperker & TGG News -->
            <section class="my-4 row top-row">
                <div class="dashboard-grid">
                    <!-- Woodperker -->
                    <div class="card">
                        <h3 class="card-title">WOODPERKER COLLECTIONS</h3>
                        <div class="slider-outer card-inner">
                            <div class="slider" id="woodperker-slider">
                                @if (!empty($showcase->woodpecker_collection))
                                    @foreach ($showcase->woodpecker_collection as $img)
                                        <div class="slide">
                                            <img src="{{ asset($img) }}" alt="Woodpecker image" class="card-img" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/resized.jpg') }}" alt="Dummy Image"
                                            class="card-img" />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="button-group">
                            <button class="btn-outline small checkout-btn">Checkout</button>
                        </div>
                        <div class="modal">
                            <div class="modal-content">
                                <span class="close-btn">&times;</span>
                                <p>This is the checkout popup for Woodperker Collections</p>
                            </div>
                        </div>
                    </div>


                    <!-- News Slider -->
                    <div class="card">
                        <h3 class="card-title">TGG NEWS</h3>
                        <div class="slider-outer card-inner">
                            <div class="slider" id="tgg-news-slider">
                                @if (!empty($showcase->tgg_news))
                                    @foreach ($showcase->tgg_news as $news)
                                        <div class="slide">
                                            <iframe width="100%" height="220" src="{{ getEmbedUrl($news) }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="slide">
                                        <p>No news available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: News Slider & Travel -->
            <section class="my-4 row top-row">
                <div class="dashboard-grid">
                    <!-- Travel -->
                    <div class="card">
                        <h3 class="card-title">TRAVEL UPDATE AND EVENTS</h3>
                        <div class="card-inner">
                            <div class="slider">
                                @if (!empty($showcase->travel_and_events) && count($showcase->travel_and_events) > 0)
                                    @foreach ($showcase->travel_and_events as $event)
                                        <div class="slide">
                                            <img src="{{ asset($event) }}" alt="Event Image" class="card-img" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/WOODPERKER.jpg') }}" alt="Dummy 3"
                                            class="card-img" />
                                    </div>
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Dummy 1"
                                            class="card-img" />
                                    </div>
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Dummy 2"
                                            class="card-img" />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="button-group">
                            <button class="btn-outline small checkout-btn">Checkout</button>
                        </div>
                        <div class="modal">
                            <div class="modal-content">
                                <span class="close-btn">&times;</span>
                                <p>This is the checkout popup for Travel Update and Events</p>
                            </div>
                        </div>
                    </div>

                    <!-- TGG Foundation -->
                    <div class="card">
                        <h3 class="card-title">TGG FOUNDATION</h3>
                        <div class="card-inner">
                            <div class="slider">
                                @if (!empty($showcase->tgg_foundation) && count($showcase->tgg_foundation) > 0)
                                    @foreach ($showcase->tgg_foundation as $item)
                                        <div class="slide">
                                            <img src="{{ asset($item) }}" alt="TGG Foundation Image" class="card-img" />
                                        </div>
                                    @endforeach
                                @else
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/WOODPERKER.jpg') }}"
                                            alt="Dummy Foundation 3" class="card-img" />
                                    </div>
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}"
                                            alt="Dummy Foundation 1" class="card-img" />
                                    </div>
                                    <div class="slide">
                                        <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}"
                                            alt="Dummy Foundation 2" class="card-img" />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="button-group">
                            <button class="btn-outline small checkout-btn">Checkout</button>
                        </div>
                        <div class="modal">
                            <div class="modal-content">
                                <span class="close-btn">&times;</span>
                                <p>This is the checkout popup for TGG Foundation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: Foundation + Placeholder -->
            {{-- <section class="my-4 row top-row">
            <div class="dashboard-grid">
                <!-- Placeholder card (future feature) -->
                <div class="card">
                    <h3 class="card-title">COMING SOON</h3>
                    <div class="card-inner">
                        <p>More features will be added here.</p>
                    </div>
                </div>
            </div>
        </section> --}}

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
                const card = button.closest('.card'); // find parent card
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
                    slider.scrollTo({
                        left: slider.clientWidth * i,
                        behavior: 'smooth'
                    });
                };

                setInterval(() => {
                    index = (index + 1) % slides.length;
                    goTo(index);
                }, INTERVAL);
            });
        });
    </script>
@endpush
