<!-- <div class="latest_Blogs_News_Section_container"> -->
    <!-- <div class="section-container latest_Blogs_News_Section"> -->
    <div class="section-container latest_Blogs_News_Section">
        <div class="heading-container">
            <div>
                <h2>Latest Blogs & News</h2>
            </div>
            <a href="#">View All</a>
        </div>

        <div class="news-list-container">
            @foreach($latestBlogsAndNews as $latestBlogsAndNew)
                <div class="news-list-item"
                    data-modal
                    data-title="{{ $latestBlogsAndNew['title'] }}"
                    data-img="{{ asset('storage/' . $latestBlogsAndNew['image']) }}"
                    data-video="{{ $latestBlogsAndNew['youtube_video_link'] }}"
                >

                    <!-- Thumbnail -->
                    <div class="news-image-wrapper">
                        <img src="{{ asset('storage/' . $latestBlogsAndNew['image']) }}" 
                            alt="{{ $latestBlogsAndNew['title'] }}" 
                            class="news-thumbnail">
                    </div>

                    <!-- Title -->
                    <div class="news-content">
                        <h4 class="news-title">{{ $latestBlogsAndNew['title'] }}</h4>
                    </div>

                    <x-ri-arrow-right-s-line class="news-arrow-icon" />

                </div>

            @endforeach
        </div>
    </div>
    <!-- <x-need-help-box />
</div> -->