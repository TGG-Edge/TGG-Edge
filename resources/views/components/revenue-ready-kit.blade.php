<div class="section-container">
    <div class="heading-container">
        <div>
            <h2>{{ $title }}</h2>
        </div>

        <!-- <a href="{{ $viewAllLink }}">View All</a> -->
    </div>

    <div class="revenue-ready-kit">
        @foreach($items as $item)
            <div class="revenue-card">

                <div class="icon-wrapper main-icon"
                    style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                    
                    <x-dynamic-component 
                        :component="$item['icon']" 
                        class="stat-icon"
                        style="color: {{ $item['color'] }};" />
                </div>

                <h3 class="title">{{ $item['title'] }}</h3>
                <p class="desc">{{ $item['desc'] }}</p>

                <div class="card-action-row">

                    <a href="{{ $item['link'] }}" class="get-more-btn">
                        <span class="btn-text">Get More</span>
                    </a>

                    <a href="{{ $item['link'] }}">
                        <div class="icon-wrapper btn-icon"
                            style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                            
                            <x-dynamic-component 
                                :component="$item['link-icon']" 
                                class="stat-icon"
                                style="color: {{ $item['color'] }};" />
                        </div>
                    </a>

                </div>

            </div>
        @endforeach
    </div>
</div>