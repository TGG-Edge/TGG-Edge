@extends('tgg-india.layouts.app')
@section('title', 'Dashboard | TGG Meta | TGG India')

@section('content')
     <style>
        .checkout-btn:hover{
    background-color: #0056b3 !important;
        }
     </style>
    <div class="admin-container">
        @include('tgg-india.layouts.includes.message')
        <main class="dashboard-main">

            <!-- Welcome Note -->
            <div class="dashboard-grid-welcome">
                <section class="welcome-note card">
                    <div class="card-inner-welcome">
                        <p>
                            {!! $showcase->welcome_note_member  ??
                                'Welcome to the Volunteer Dashboard! Explore the Woodperker collections, review entrepreneurship opportunities, and keep an eye on the latest updates below.' !!}
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
                        <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Modicare Logo" class="card-img"
                            width="300" height="150">
                    </div>
                    <div class="button-group">
                        <a href="https://www.modicare.com/sign-in" style="
                            color: white;
                            text-decoration: none;
                        " class="btn-outline small checkout-btn">Login</a>
                        <button type="button" class="btn-outline small checkout-btn"
                            data-note="{{ isset($showcase->modicare_checkout) ? e($showcase->modicare_checkout) : '' }}"
                            data-html="1">Information
                        </button>
                    </div>
                </div>

                <!-- Motilal -->
                <div class="card">
                    <h3 class="card-title">MOTILAL OSWAL</h3>
                    <div class="card-inner">
                        <img src="{{ asset('assets/tgg-india/images/Motilal.png') }}" alt="Motilal Logo" class="card-img"
                            width="300" height="150">
                    </div>
                    <div class="button-group">
                        <a href="https://invest.motilaloswal.com/" style="
                            color: white;
                            text-decoration: none;
                        " class="btn-outline small checkout-btn">Login</a>
                        <button type="button" class="btn-outline small checkout-btn"
                            data-note="{{ isset($showcase->motilal_checkout) ? e($showcase->motilal_checkout) : '' }}"
                            data-html="1">Information
                        </button>
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
                                        $img = is_array($item) ? $item['img'] ?? '' : $item;
                                        $note = is_array($item) ? $item['note'] ?? '' : '';

                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                    @endphp
                                    <div class="slide">
                                        <img src="{{ asset($img) }}" alt="Woodperker Image" class="card-img" />
                                    </div>
                                @endforeach
                            @else
                                <div class="slide">
                                    <p>No collections available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="slider" style="height: 30px !important; flex: 0 0 40px !important;">
                        @if (!empty($showcase->woodpecker_collection))
                            @foreach ($showcase->woodpecker_collection as $item)
                                @php
                                    $img = is_array($item) ? $item['img'] ?? '' : $item;
                                    $note = is_array($item) ? $item['note'] ?? '' : '';
                                    
                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button style="width: 100%;" type="button" class="btn-outline small checkout-btn"  data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" 
                                    data-html="1">Checkout</button>
                                </div>
                            @endforeach
                        @else
                            <div class="slide">
                                <p>No collections available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Freelancing Opportunities -->
                <div class="card opportunities">
                    <h3 class="card-title">FREELANCING OPPORTUNITIES</h3>
                    <div class="card-inner">
                        @if (!empty($showcase->investment_opportunities))
                            @foreach ($showcase->investment_opportunities as $opportunity)
                                <div class="project-row">
                                    <label class="project-left">
                                        <input type="radio" name="project" />
                                        <span>{{ $opportunity }}</span>
                                    </label>
                                    <button class="btn-outline checkout-btn">GO</button>
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
                                        $img = is_array($item) ? $item['img'] ?? '' : $item;
                                        $note = is_array($item) ? $item['note'] ?? '' : '';

                                                     
                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                    @endphp
                                    <div class="slide">
                                        <img src="{{ asset($img) }}" alt="Event Image" class="card-img" />
                                    </div>
                                @endforeach
                            @else
                                <div class="slide">
                                    <p>No events available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="slider" style="height: 30px !important; flex: 0 0 40px !important;">
                        @if (!empty($showcase->travel_and_events))
                            @foreach ($showcase->travel_and_events as $item)
                                @php
                                    $img = is_array($item) ? $item['img'] ?? '' : $item;
                                    $note = is_array($item) ? $item['note'] ?? '' : '';

                                                                    
                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button style="
                                        width: 100%;
                                        " type="button" class="btn-outline small checkout-btn"
                                        data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" 
                                    data-html="1">Checkout</button>

                                </div>
                            @endforeach
                        @else
                            <div class="slide">
                                <p>No collections available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TGG Foundation -->
                <div class="card tgg-foundation">
                    <h3 class="card-title">TGG FOUNDATION</h3>
                    <div class="card-inner">
                        <div class="slider" id="foundation-slider">
                            @if (!empty($showcase->tgg_foundation) && count($showcase->tgg_foundation) > 0)
                                @foreach ($showcase->tgg_foundation as $item)
                                    @php
                                        $img = is_array($item) ? $item['img'] ?? '' : $item;
                                        $note = is_array($item) ? $item['note'] ?? '' : '';

                                                       
                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                    @endphp
                                    <div class="slide">
                                        <img src="{{ asset($img) }}" alt="TGG Foundation Image" class="card-img" />
                                    </div>
                                @endforeach
                            @else
                                <div class="slide">
                                    <p>No foundation updates available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="slider" style="height: 30px !important; flex: 0 0 40px !important;">
                        @if (!empty($showcase->tgg_foundation))
                            @foreach ($showcase->tgg_foundation as $item)
                                @php
                                    $img = is_array($item) ? $item['img'] ?? '' : $item;
                                    $note = is_array($item) ? $item['note'] ?? '' : '';

                                                                    
                                    $isLive = (request()->getHost() === 'thegoldengreens.com');
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $isLive
                                        ? "https://thegoldengreens.com/storage/app/public/showcase/{$filename}"
                                        : $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button style="
                                        width: 100%;
                                        " type="button" class="btn-outline small checkout-btn"
                                        data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" 
                                    data-html="1">Checkout</button>

                                </div>
                            @endforeach
                        @else
                            <div class="slide">
                                <p>No collections available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content a4-modal">
        <div class="modal-header">
            <h5 class="modal-title">Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="checkoutModalBody">
            <!-- Dynamic content goes here -->
        </div>
        </div>
    </div>
    </div>


@endsection

@push('scripts')
    <script>
        // ==========================
        // Modal handling
        // ==========================
        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        // const checkoutModalBody = document.getElementById('checkoutModalBody');

        document.querySelectorAll('.checkout-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');
                if (isHtml) {
                    checkoutModalBody.innerHTML = note;
                } else {
                    checkoutModalBody.textContent = note || 'No details available.';
                }
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.modal .close-btn').forEach(close => {
            close.addEventListener('click', () => {
                close.closest('.modal').style.display = 'none';
            });
        });

        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });

        // ==========================
        // Auto slider handling
        // ==========================
        document.addEventListener('DOMContentLoaded', () => {
            const INTERVAL = 5000;
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


        document.addEventListener('DOMContentLoaded', () => {
            const INTERVAL = 5000;
            document.querySelectorAll('.slider1').forEach(slider => {
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
