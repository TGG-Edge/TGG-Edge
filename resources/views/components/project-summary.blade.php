{{-- resources/views/components/project-summary.blade.php --}}
@php
    $projectCount = \App\Models\ProjectSecondary::query();

    if (auth('web2')->user()->id != 1) {

        $userId = auth('web2')->user()->id;

        $projectCount->where(function ($query) use ($userId) {
            $query->where('created_by', $userId)
                    ->orWhereHas('members', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
        });
    }
    $projectCount = $projectCount->count();
@endphp
<div class="active-projects">
    <h2>{{ $title ?? 'Project Summary' }}</h2>

    <ul class="active-projects-list">
        <li>

            <h4>{{ $label ?? 'Your ongoing Projects'    }}</h4>
            <div>
                <span class="badge"></span>

                <span class="badge-status-text">
                    {{ $projectCount ?? 0 }} {{ $status ?? 'Active' }}
                </span>
            </div>
        </li>
    </ul>
</div>