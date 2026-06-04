<div class="top-section-container-right">
    <div class="announcement-header">
        <h2>Latest Announcements</h2>
        <!-- <a href="">View All</a> -->
    </div>

    <ul class="latest-announcements-list">
        @foreach(array_slice(array_reverse($announcements), 0, 4) as $announcement)
            <li data-modal
                data-title="{{ $announcement['title'] }}"
                data-note="{{ ($announcement['note'] ?? '') }}"
                data-link="{{ $announcement['link'] ?? '' }}">
                <div class="latest-announcements-list-inner">
                    <h4 style="margin: 0 0 5px 0;">
                        {{ $announcement['title'] }}
                    </h4>

                    <div class="date-views-container">
                        <x-ri-calendar-event-line class="calender-icon" />

                        <span class="date">
                            {{ \Carbon\Carbon::parse($announcement['updated_at'] ?? now())->format('M j, Y') }}
                        </span>
                    </div> </div><x-ri-arrow-right-s-line class="sidebar-icon" />
            </li>
        @endforeach
    </ul>
</div>