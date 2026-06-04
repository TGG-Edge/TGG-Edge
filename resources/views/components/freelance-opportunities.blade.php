<div class="bottom-section">
    <div class="section-container">

        <div class="heading-container">
            <div>
                <h2>Freelance Opportunities</h2>
                <p>Earn extra by leveraging your skills</p>
            </div>
        </div>

        <div class="freelance-opportunity-list">
            @if (!empty($opportunities))
                @foreach(array_slice(array_reverse($opportunities), 0, 4) as $item)
                    <div class="freelance-list-item"
                         data-modal
                         data-title="{{ $item['title'] }}"
                         data-note="{{ $item['note'] ?? ''}}"
                         data-img="{{ $item['img'] ?? '' }}"
                         data-link="{{ $item['link'] ?? '' }}"
                    >

                        <div class="badge-icon" style="background-color: #DBEAFE; color: #033576;">
                            <x-dynamic-component 
                                :component="'ri-hand-heart-line'" 
                                class="list-icon-svg"
                                style="color: #033576;" 
                            />
                        </div>

                        <div class="list-content">
                            <h4 class="list-title">{{ $item['title'] }}</h4>

                            {{-- Short preview --}}
                            <p class="list-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item['note'] ?? ''), 80) }}
                            </p>
                        </div>

                        <x-ri-arrow-right-s-line class="sidebar-icon" />
                    </div>

                @endforeach
            @else
                <p>No opportunities available</p>
            @endif
        </div>

        <a class="view-all-opportunities-btn" href="#">View All Opportunities</a>

    </div>
</div>