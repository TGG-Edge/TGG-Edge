<div class="section-container">

    <div class="happiness-program-heading-container">
        <div class="heading-container-text">
            <h2>Happiness Program</h2>
            <p>Enhance your lifestyle with exclusive member benefits and personalized services</p>
        </div>


        <!-- <div class="heading-container-more">
            <p><span> Services Available</span></p>
            <span>
                <x-ri-arrow-up-s-line class="card-icon" />
            </span>
        </div> -->

    </div>

    <!-- 1. Dynamic Cards Loop -->
    <div class="happiness-program-card-container">
        @php
            // Define the collections with optional icons and colors
            $collections = [
                'woodpecker_collection' => [
                    'title' => 'Woodpecker Collection',
                    'icon' => 'ri-gift-line',
                    'icon_color' => '#FF5733'
                ],
                'travel_and_events' => [
                    'title' => 'Travel & Events',
                    'icon' => 'ri-flight-takeoff-line',
                    'icon_color' => '#337AFF'
                ],
                'tgg_foundation' => [
                    'title' => 'TGG Foundation',
                    'icon' => 'ri-hand-heart-line',
                    'icon_color' => '#33FF77'
                ]
            ];
        @endphp

        @foreach($collections as $key => $collection)
            @if(!empty($showcase->$key) && is_array($showcase->$key))
                @foreach($showcase->$key as $item)
                    <div class="happiness-card">
                        <div class="card-image-wrapper">
                            <img src="{{ $item['img'] }}" alt="{{ $collection['title'] }}">
                            
                            {{-- Floating icon for the collection --}}
                            <div class="floating-icon">
                                <x-dynamic-component 
                                    :component="$collection['icon'] ?? 'ri-gift-line'" 
                                    class="card-icon" 
                                    style="color: {{ $collection['icon_color'] ?? '#000' }};" 
                                />
                            </div>
                        </div>

                        <div class="card-content">
                            {{-- Use note if exists, else fallback title --}}
                            @if(!empty($item['note']))
                                <h3 class="card-heading">{{ \Illuminate\Support\Str::limit(strip_tags($item['note']), 25) }}</h3>
                            @else
                                <h3 class="card-heading">{{ $collection['title'] }}</h3>
                            @endif
                            <p class="card-desc">{{ $collection['title'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                @if(!empty($item['link']))
                                    <a href="{{ $item['link'] }}" class="card-link">Explore &rarr;</a>
                                @else
                                    <div></div>
                                @endif
                                <button class="dashboard-read-more-btn"
                                    data-modal
                                    data-img="{{ $item['img'] }}"
                                    data-title="{{ $collection['title'] }}"
                                    data-note="{{ ($item['note'] ?? '') }}"
                                    data-link="{{ $item['link'] ?? '' }}"
                                >
                                    Read More →
                                </button>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>

    <!-- 2. Static "Coming Soon" Card -->
    <div class="future-service-widget">
        <div class="widget-content-stack">
            <div class="widget-icon-box">
                <!-- Assuming you are using Blade/Alpine or similar for the Heroicon -->
                <x-heroicon-o-plus class="icon-svg" />
            </div>
            <h3 class="widget-title">More Services Coming Soon</h3>
            <p class="widget-text">We're constantly adding new benefits to enhance your experience.</p>
        </div>
    </div>

</div>