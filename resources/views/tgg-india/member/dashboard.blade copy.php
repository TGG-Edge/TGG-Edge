@extends('tgg-india.layouts.app')
@section('title', 'Dashboard | TGG Meta | TGG India')

@section('content')
    <style>
        .checkout-btn:hover {
            background-color: #0056b3 !important;
        }

        .checkout-btn-new:hover {
            background-color: #0056b3 !important;
        }

        .btn-inside-model {
            background: #265475;
            color: #fff;
        }

        .btn-inside-model:hover {
            background-color: #0056b3 !important;
            color: #fff !important;
        }

        .checkout-btn-tgg_foundation:hover {
            background-color: #0056b3 !important;
        }

        .card.woodperker {
            grid-column: 1 / -1;
        }

        .card.opportunities {
            grid-column: 1 / -1;
        }
    </style>
    <div class="admin-container">
        @include('tgg-india.layouts.includes.message')
        <main class="dashboard-main">

            <!-- Welcome Note -->
            <div class="dashboard-grid-welcome">
                @php
                    $user = \App\Models\UserSecondary::find(auth('web2')->id());
                    $mainApplicant = \App\Models\UserSecondary::where(
                        'rhm_number',
                        $user->parent_rhm_number ?? '',
                    )->first();
                @endphp

                <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 mb-2">
                    <span><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</span>
                    <span><strong>Role:</strong> {{ $user->role_name ?? 'N/A' }}</span>
                    <span><strong>RHM No:</strong> {{ $user->rhm_number ?? 'N/A' }}</span>

                </div>
                <section class="welcome-note card">
                    <div class="card-inner-welcome">
                        <p id="expandWelcome" class="welcome-expand-note">
                            {!! $showcase->welcome_note_member ??
                                'Welcome to the Volunteer Dashboard! Explore the Woodperker collections, review entrepreneurship opportunities, and keep an eye on the latest updates below.' !!}
                        </p>
                        <span id="toggleExpandWelcome" class="text-primary"
                            style="cursor:pointer; display:none; font-weight:600;">
                            Read More
                        </span>
                    </div>
                </section>
            </div>
            <br>

            <div class="dashboard-grid mb-4">
                <!-- Modicare -->
                <div class="card">
                    <h3 class="card-title">MODICARE</h3>
                    <div class="card-inner">
                        <img src="{{ asset('assets/tgg-india/images/Modicare.png') }}" alt="Modicare Logo" class="card-img"
                            width="300" height="150">
                    </div>
                    <div class="button-group">
                        <a href="https://www.modicare.com/sign-in"
                            style="
                            color: white;
                            text-decoration: none;
                        "
                            class="btn-outline small ">Login</a>
                        <button type="button" class="btn-outline small checkout-btn" data-note="{!! htmlspecialchars($showcase->modicare_checkout, ENT_QUOTES) !!}"
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
                        <a href="https://invest.motilaloswal.com/"
                            style="
                            color: white;
                            text-decoration: none;
                        "
                            class="btn-outline small ">Login</a>
                        <button type="button" class="btn-outline small checkout-btn" data-note="{!! htmlspecialchars($showcase->motilal_checkout, ENT_QUOTES) !!}"
                            data-html="1">Information
                        </button>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">INDIA INSURE</h3>
                    <div class="card-inner" style="width: 420px !important; height: 200px !important;">
                        <img src="{{ asset('assets/tgg-india/images/india-insure.png') }}" alt="India Insure Logo"
                            class="card-img" width="300" height="150" style="    object-fit: cover;">
                    </div>
                    <div class="button-group">
                        <a href="https://pos.insureeasy.in/" style="color: white; text-decoration: none;"
                            class="btn-outline small ">
                            Login
                        </a>
                        <button type="button" class="btn-outline small checkout-btn" data-note="{!! htmlspecialchars($showcase->india_insure_checkout, ENT_QUOTES) !!}"
                            data-html="1">
                            Information
                        </button>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">TGG FOUNDATION</h3>
                    <div class="card-inner" style="width: 420px !important; height: 200px !important; ">
                        <img src="{{ asset('assets/tgg-india/images/tgg-foundation.png') }}" alt="TGG Foundation Logo"
                            class="card-img" width="300" height="150" style="    object-fit: cover;">
                    </div>
                    <div class="button-group">
                        <a href="https://thegoldengreens.com/user/login" style="color: white; text-decoration: none;"
                            class="btn-outline small ">
                            login
                        </a>
                        <button type="button" class="btn-outline small checkout-btn" data-note="{!! htmlspecialchars($showcase->tgg_foundation_checkout, ENT_QUOTES) !!}"
                            data-html="1">
                            Information
                        </button>
                    </div>
                </div>


                <!-- Woodperker -->
                <div class="card woodperker col-md-12">
                    <h3 class="card-title">WOODPERKER COLLECTIONS</h3>
                    <div class="card-inner" style="width: auto !important; max-width: 100%; margin: 8px;">
                        <div class="slider" style="margin: 8px auto; width: 1000px !important; max-width: 1000px;">
                            @if (!empty($showcase->woodpecker_collection))
                                @foreach ($showcase->woodpecker_collection as $item)
                                    @php
                                        $img = is_array($item) ? $item['img'] ?? '' : $item;
                                        $note = is_array($item) ? $item['note'] ?? '' : '';

                                        $isLive = request()->getHost() === 'thegoldengreens.com';
                                        $filename = basename($img);

                                        // Re-assign $imgPath based on environment
                                        $img = $img;
                                    @endphp
                                    <div class="slide" style=" width: 1000px; max-width: 1000px;">
                                        <img src="{{ asset($img) }}" alt="Woodperker Image" class="card-img"
                                            style="width: 1000px; max-width: 1000px;     object-fit: cover;" />
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

                                    $isLive = request()->getHost() === 'thegoldengreens.com';
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button style="width: 100%;" type="button" class="btn-outline small checkout-btn"
                                        data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" data-html="1">Checkout</button>
                                </div>
                            @endforeach
                        @else
                            <div class="slide">
                                <p>No collections available</p>
                            </div>
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

                                        $isLive = request()->getHost() === 'thegoldengreens.com';
                                        $filename = basename($img);

                                        // Re-assign $imgPath based on environment
                                        $img = $img;
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

                                    $isLive = request()->getHost() === 'thegoldengreens.com';
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button
                                        style="
                                        width: 100%;
                                        "
                                        type="button" class="btn-outline small checkout-btn"
                                        data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" data-html="1">Checkout</button>

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
                    <h3 class="card-title">THE ART OF GIFTING</h3>
                    <div class="card-inner">
                        <div class="slider" id="foundation-slider">
                            @if (!empty($showcase->tgg_foundation) && count($showcase->tgg_foundation) > 0)
                                @foreach ($showcase->tgg_foundation as $item)
                                    @php
                                        $img = is_array($item) ? $item['img'] ?? '' : $item;
                                        $note = is_array($item) ? $item['note'] ?? '' : '';

                                        $isLive = request()->getHost() === 'thegoldengreens.com';
                                        $filename = basename($img);

                                        // Re-assign $imgPath based on environment
                                        $img = $img;
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

                                    $isLive = request()->getHost() === 'thegoldengreens.com';
                                    $filename = basename($img);

                                    // Re-assign $imgPath based on environment
                                    $img = $img;
                                @endphp
                                <div class="slide" style="height: 30px">
                                    <button
                                        style="
                                        width: 100%;
                                        "
                                        type="button" class="btn-outline small checkout-btn-tgg_foundation"
                                        data-note="{!! htmlspecialchars($note, ENT_QUOTES) !!}" data-link="{{ $item['link'] ?? '' }}"
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
                    <div class="card-inner" style="width: auto !important; max-width: 100%; margin: 8px;">
                        @if (!empty($showcase->investment_opportunities))
                            @foreach (array_reverse($showcase->investment_opportunities) as $opportunity)
                                <div class="project-row">
                                    <label class="project-left">
                                        <input type="radio" name="project" />
                                        <span>{{ $opportunity['title'] ?? '' }}</span>
                                    </label>
                                    <button class="btn-outline checkout-btn-new" data-note="{!! htmlspecialchars($opportunity['note'] ?? '', ENT_QUOTES) !!}"
                                        data-link="{{ $opportunity['link'] ?? '' }}" data-html="1">
                                        Details
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p>No opportunities available</p>
                        @endif
                    </div>
                </div>


            </div>
            {{-- =================== VENTURE BENCH SUPPORT =================== --}}
            <section class="vb-support-section rounded-4">
                <h3 class="card-title p-3">VENTURE BENCH SUPPORT</h3>

                <div class="container">
                    <div class="row g-4">

                        @foreach (getVentureBenchSupportDashbaordData() as $service)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="vb-service-card text-center rounded-4">

                                    <div class="vb-service-image">
                                        <img src="{{ asset($service['logo']) }}" alt="{{ $service['title'] }}">
                                    </div>

                                    <h6 class="fw-bold text-dark my-3">
                                        {{ strtoupper($service['title']) }}
                                    </h6>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- See More Button --}}
                    <div class="text-center py-3 d-flex justify-content-center">
                        <a href="{{ route('tgg-india.venture-bench-services.index', ['role' => auth('web2')->user()->role_key]) }}"
                            class="btn-outline small text-white checkout-vb-service-btn" style="text-decoration: none;">
                            See More Details
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px;">
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

        document.querySelectorAll('.checkout-btn-new').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 " style="text-align: center;">
                        <a href="${link}" target="_blank" class="btn btn-inside-model">Apply</a>
                    </div>`;
                }

                checkoutModalBody.innerHTML = content;
                checkoutModal.show();
            });
        });

        document.querySelectorAll('.checkout-btn-tgg_foundation').forEach(btn => {
            btn.addEventListener('click', function() {
                const note = this.dataset.note || '';
                const link = this.dataset.link || '';
                const isHtml = this.dataset.html === '1';
                const checkoutModalBody = document.getElementById('checkoutModalBody');

                let content = '';
                if (isHtml) {
                    content = note;
                } else {
                    content = `<p>${note || 'No details available.'}</p>`;
                }

                if (link) {
                    content += `<div class="mt-3 text-center">
                <a href="${link}" target="_blank" class="btn btn-inside-model">Donate</a>
            </div>`;
                }

                checkoutModalBody.innerHTML = content;
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
