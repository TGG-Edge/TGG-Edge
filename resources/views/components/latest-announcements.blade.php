<div class="top-section-container-right">
    <div class="announcement-header">
        <h2>Latest Announcements</h2>
        <!-- <a href="">View All</a> -->
    </div>

    <ul class="latest-announcements-list">
        @foreach($announcements as $announcement)
            <li>
                <a href="{{ $announcement['link'] ?? '#' }}" class="announcement-link">
                    <h4 style="margin: 0 0 5px 0;">
                        {{ $announcement['title'] }}
                    </h4>

                    <div class="date-views-container">
                        <x-ri-calendar-event-line class="calender-icon" />

                        <span class="date">
                            {{ \Carbon\Carbon::parse($announcement['updated_at'])->format('M j, Y') }}
                        </span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>