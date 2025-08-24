@extends('tgg-india.layouts.app')

@section('title', 'Dashboard | TGG Meta | TGG India')

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
                            <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Funsplash.com%2Fs%2Fphotos%2Ffree-images&psig=AOvVaw0KDcBQMAq42BRcGqphELO_&ust=1756044678803000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMi3wbSOoY8DFQAAAAAdAAAAABAE" alt="Demo image 1"/>
                        </div>
                        <div class="slide">
                            <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fnewsroom.gettyimages.com%2Fen%2Fgetty-images%2Fgetty-images-statement&psig=AOvVaw0KDcBQMAq42BRcGqphELO_&ust=1756044678803000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMi3wbSOoY8DFQAAAAAdAAAAABAT" alt="Demo image 2"/>
                        </div>
                        <div class="slide">
                            <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fpixabay.com%2Fphotos%2Fbird-blue-clouds-weather-pen-8788491%2F&psig=AOvVaw0KDcBQMAq42BRcGqphELO_&ust=1756044678803000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMi3wbSOoY8DFQAAAAAdAAAAABAc" alt="Demo image 3"/>
                        </div>
                        <div class="slide">
                            <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Funsplash.com%2Fs%2Fphotos%2Ffree-images&psig=AOvVaw0KDcBQMAq42BRcGqphELO_&ust=1756044678803000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCMi3wbSOoY8DFQAAAAAdAAAAABAl" alt="Demo image 4"/>
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
