@extends('tgg-india.layouts.app')
@section('title', 'Dashboard | TGG Meta | TGG India')
@section('content')
    <div class="admin-container">
        @include('tgg-india.layouts.includes.message')
        <main class="dashboard-main">
            <div class="dashboard-grid-welcome">
                <!-- Welcome Note (spans 2 columns) -->
                <section class="welcome-note card">
                    <div class="card-inner-welcome">
                        <p>
                            {{ $showcase->welcome_note ?? 'Welcome to the Volunteer Dashboard! Explore the Woodperker collections, review entrepreneurship opportunities, and keep an eye on the latest updates below.' }}
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
                        <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Modicare Logo" class="card-img"
                            width="300" height="150">
                    </div>
                    <div class="button-group">
                        <button class="btn-outline small">Login</button>
                        <!-- <button class="btn-outline small info-btn">Information</button> -->
                        <button type="button" class="btn-outline small checkout-btn"
                                data-note="{{ isset($showcase->modicare_checkout) ? e($showcase->modicare_checkout) : '' }}"
                                data-html="1">Information
                        </button>
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
                        <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Modicare Logo" class="card-img"
                            width="300" height="150">
                    </div>
                    <div class="button-group">
                        <button class="btn-outline small">Login</button>
                        <!-- <button class="btn-outline small info-btn">Information</button> -->
                        <button type="button" class="btn-outline small checkout-btn"
                                data-note="{{ isset($showcase->motilal_checkout) ? e($showcase->motilal_checkout) : '' }}"
                                data-html="1">Information
                        </button>
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
                    <h3 class="card-title">WOODPERKER COLLECTIONS</h3>
                    <div class="card-inner">
                        <div class="slider">
                            @if (!empty($showcase->woodpecker_collection))
                                @foreach ($showcase->woodpecker_collection as $item)
                                    @php
                                        $img = is_array($item) ? ($item['img'] ?? '') : $item;
                                        $note = is_array($item) ? ($item['note'] ?? '') : '';
                                    @endphp
                                    <div class="slide">
                                        <img src="{{ asset($img) }}" alt="Woodperker Image" class="card-img" />
                                    </div>
                                @endforeach
                            @else
                                <div class="slide">
                                    <!-- <img src="{{ asset('assets/tgg-india/images/resized.jpg') }}" alt="Dummy Image" class="card-img" /> -->
                                </div>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn-outline small checkout-btn"
                        data-note="{{ e($note) }}" data-html="0">Checkout
                    </button>
                    <!-- <div class="button-group">
                        <button class="btn-outline small checkout-btn">Checkout</button>
                    </div>

                    <div class="modal">
                        <div class="modal-content">
                            <span class="close-btn">&times;</span>
                            <p>This is the checkout popup for Woodperker Collections</p>
                        </div>
                    </div> -->
                </div>


                <!-- Entrepreneurship Opportunities -->
                <!--
                <div class="card opportunities">
                    <h3 class="card-title">ENTREPRENEURSHIP OPPORTUNITIES</h3>
                    <div class="card-inner">
                        @if (!empty($showcase->entrepreneurship_opportunities))
                            @foreach ($showcase->entrepreneurship_opportunities as $opportunity)
                                <div class="project-row">
                                    <label class="project-left">
                                        <input type="radio" name="project" />
                                        <span>{{ $opportunity }}</span>
                                    </label>
                                    <button class="btn-outline">GO</button>
                                </div>
                            @endforeach
                        @else
                            <p>No opportunities available</p>
                        @endif
                    </div>
                </div>-->

                <!-- TGG News -->
                <!-- <div class="card tgg_news">
                    <h3 class="card-title">TGG NEWS</h3>
                    <div class="card-inner">
                        @if (!empty($showcase->tgg_news))
                            @foreach ($showcase->tgg_news as $news)
                                <iframe width="100%" height="200" src="{{ getEmbedUrl($news) }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen>
                                </iframe>
                            @endforeach
                        @else
                            <p>No news available</p>
                        @endif
                    </div>
                </div> -->

                <!-- Freelancing Opportunities -->
            <div class="card opportunities">
                <h3 class="card-title">FREELANCING OPPORTUNITIES</h3>
                <div class="card-inner">
                    @if(!empty($showcase->freelancing_opportunities))
                        @foreach($showcase->freelancing_opportunities as $opportunity)
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
            </div>



                <!-- Travel -->
                <div class="card travel">
                    <h3 class="card-title">TRAVEL UPDATE AND EVENTS</h3>
                    <div class="card-inner">
                        <div class="slider" id="travel-slider">
                            @if (!empty($showcase->travel_and_events) && count($showcase->travel_and_events) > 0)
                                    @foreach ($showcase->travel_and_events as $item)
                                        @php
                                            $img = is_array($item) ? ($item['img'] ?? '') : $item;
                                            $note = is_array($item) ? ($item['note'] ?? '') : '';
                                        @endphp
                                        <div class="slide">
                                            <img src="{{ asset($img) }}" alt="Event Image" class="card-img" />
                                        </div>
                                    @endforeach

                                @endif
                        </div>
                    </div>
                    <button type="button" class="btn-outline small checkout-btn"
                        data-note="{{ e($note) }}" data-html="0">Checkout
                    </button>
                    <!-- <div class="button-group">
                        <button class="btn-outline small checkout-btn">Checkout</button>
                    </div>
                    <div class="modal">
                        <div class="modal-content">
                            <span class="close-btn">&times;</span>
                            <p>This is the checkout popup for Travel Update and Events</p>
                        </div>
                    </div> -->
                </div>

                <!-- TGG Homes -->
                <!--
                <div class="card">
                    <h3 class="card-title">TGG HOMES</h3>
                    <div class="slider-outer card-inner">
                        <div class="slider" id="homes-slider">
                            @if (!empty($showcase->tgg_homes))
                                @foreach ($showcase->tgg_homes as $home)
                                    <div class="slide">
                                        <img src="{{ asset($home) }}" alt="Home Image" />
                                    </div>
                                @endforeach
                            @else
                                <div class="slide"><p>No homes available</p></div>
                            @endif
                        </div>
                    </div>
                </div>
                -->
                <!-- Investment Opportunities -->
                <!--
                <div class="card opportunities">
                    <h3 class="card-title">INVESTMENT OPPORTUNITIES</h3>
                    <div class="card-inner">
                        @if (!empty($showcase->investment_opportunities))
                            @foreach ($showcase->investment_opportunities as $investment)
                                <div class="project-row">
                                    <label class="project-left">
                                        <input type="radio" name="investment" />
                                        <span>{{ $investment }}</span>
                                    </label>
                                    <button class="btn-outline">INVEST</button>
                                </div>
                            @endforeach
                        @else
                            <p>No investment opportunities</p>
                        @endif
                    </div>
                </div>
                -->

                <!-- TGG Foundation -->
                <div class="card tgg-foundation ">
                    <h3 class="card-title">TGG FOUNDATION</h3>
                    <div class="card-inner">
                        <div class="slider" id="foundation-slider">
                            @if (!empty($showcase->tgg_foundation) && count($showcase->tgg_foundation) > 0)
                                    @foreach ($showcase->tgg_foundation as $item)
                                        @php
                                            $img = is_array($item) ? ($item['img'] ?? '') : $item;
                                            $note = is_array($item) ? ($item['note'] ?? '') : '';
                                        @endphp
                                        <div class="slide">
                                            <img src="{{ asset($img) }}" alt="TGG Foundation Image" class="card-img" />
                                        </div>
                                    @endforeach
                                @else
                                    <!-- <div class="slide">
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
                                    </div> -->
                                @endif
                        </div>
                    </div>
                    <button type="button" class="btn-outline small checkout-btn"
                        data-note="{{ e($note) }}" data-html="0">Checkout
                    </button>
                    <!-- <div class="button-group">
                        <button class="btn-outline small checkout-btn">Checkout</button>
                    </div>
                    <div class="modal">
                        <div class="modal-content">
                            <span class="close-btn">&times;</span>
                            <p>This is the checkout popup for TGG Foundation</p>
                        </div>
                    </div> -->
                </div>
            </div>
        </main>
    </div>

    <!-- Reusable checkout modal (single) -->
    <div class="modal" id="checkoutModal" style="display:none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div id="checkoutModalBody"></div>
        </div>
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

        // Checkout buttons open the reusable modal. Use data-html="1" if the note contains HTML.
            const checkoutModal = document.getElementById('checkoutModal');
            const checkoutModalBody = document.getElementById('checkoutModalBody');

            document.querySelectorAll('.checkout-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const note = this.dataset.note || '';
                    const isHtml = this.dataset.html === '1';
                    if (isHtml) {
                        checkoutModalBody.innerHTML = note; // allow HTML for partner checkout notes
                    } else {
                        checkoutModalBody.textContent = note || 'No details available.';
                    }
                    checkoutModal.style.display = 'flex';
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

