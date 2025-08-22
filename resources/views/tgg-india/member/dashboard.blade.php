@extends('tgg-india.layouts.app')

@section('title', 'Admin Dashboard - TGG Edge')

@section('content')
<div class="admin-container">
    @include('tgg-india.layouts.includes.message')

    <main class="dashboard-main">
        <!-- Welcome Note -->
        <section class="welcome-note card">
            <p>
                Welcome to the Volunteer Dashboard! Explore the Woodperker
                collections, review entrepreneurship opportunities, and keep an eye on
                the latest updates below.
            </p>
        </section>

        <!-- Top Row -->
        <section class="row top-row">
            <!-- Woodperker -->
            <div class="card woodperker">
                <h3 class="card-title">WOODPERKER COLLECTIONS</h3>

                <!-- single-image viewport slider -->
                <div class="slider-outer card-inner">
                    <div class="slider" aria-label="Woodperker image slider">
                        <div class="slide">
                            <img src="https://picsum.photos/800/420?random=1" alt="Demo image 1"/>
                        </div>
                        <div class="slide">
                            <img src="https://picsum.photos/800/420?random=2" alt="Demo image 2"/>
                        </div>
                        <div class="slide">
                            <img src="https://picsum.photos/800/420?random=3" alt="Demo image 3"/>
                        </div>
                        <div class="slide">
                            <img src="https://picsum.photos/800/420?random=4" alt="Demo image 4"/>
                        </div>
                    </div>
                </div>

                <button class="btn-outline small">checkout</button>
            </div>

            <!-- Opportunities -->
            <div class="card opportunities">
                <h3 class="card-title">ENTREPRENEURSHIP OPPORTUNITIES</h3>

                <div class="project-row">
                    <label class="project-left">
                        <input type="radio" name="project"/>
                        <span>Project-1</span>
                    </label>
                    <button class="btn-outline">GO</button>
                </div>

                <div class="project-row">
                    <label class="project-left">
                        <input type="radio" name="project"/>
                        <span>Project-2</span>
                    </label>
                    <button class="btn-outline">GO</button>
                </div>

                <div class="project-row">
                    <label class="project-left">
                        <input type="radio" name="project"/>
                        <span>Project-3</span>
                    </label>
                    <button class="btn-outline">GO</button>
                </div>
            </div>
        </section>

        <!-- Middle Row -->
        <section class="row">
            <div class="card center-box">TGG NEWS</div>
            <div class="card center-box">TRAVEL UPDATE AND EVENTS</div>
        </section>

        <!-- Bottom Row -->
        <section class="row">
            <div class="card center-box">TGG HOMES</div>
            <div class="card center-box">INVESTMENT OPPORTUNITIES</div>
        </section>
    </main>
</div>
@endsection
