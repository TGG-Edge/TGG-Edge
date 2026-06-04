<div class="section-container">
    <div class="heading-container">
        <div>
            <h2>Venture Bench Support</h2>
        </div>

        <a href="{{ $viewAllUrl }}">View All</a>
    </div>

    <div class="venture-bench-support">
        @foreach(array_slice($items, 0, 6) as $item)
            <div class="venture-bench-card">
                <div
                    class="icon-wrapper main-icon"
                    style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};"
                >
                    <x-dynamic-component
                        :component="$item['icon']"
                        class="stat-icon"
                        style="color: {{ $item['color'] }};"
                    />
                </div>

                <div class="venture-bench-card-text-info">
                    <h3 class="title">{{ $item['title'] }}</h3>
                    <p class="desc">{{ implode(', ', $item['points']) }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>