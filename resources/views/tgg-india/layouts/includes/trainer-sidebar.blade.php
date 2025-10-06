    @php
        $user = auth('web2')->user();
        // Combine all feature objects from all modules into one list
        $features = $user->modules->flatMap->features;
        $hasLiteratures = $features->contains('feature_key', 'literatures');
        $hasLinks = $features->contains('feature_key', 'links');
        $hasVideos = $features->contains('feature_key', 'videos');
        $otherAccounts = \App\Models\UserSecondary::where('email', $user->email)->where('id', '!=', $user->id)->get();
    @endphp
    <a href="{{ route('tgg-india.trainer.dashboard') }}"
        class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="{{ route('tgg-india.trainer.profile.index') }}"
        class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

    @if ($otherAccounts->count() > 0)
        <div class="dropdown mt-2">
            <a href="#"
                class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-india/switch*') ? 'active' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#switchAccountDropdown"
                aria-expanded="{{ request()->is('tgg-edge/tgg-india/switch*') ? 'true' : 'false' }}">
                <span><i class="fas fa-exchange-alt me-2"></i> Switch Account</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse ps-3 {{ request()->is('tgg-india/switch*') ? 'show' : '' }}"
                id="switchAccountDropdown">
                @foreach ($otherAccounts as $account)
                    <a href="{{ route('tgg-india.switch.account', $account->id) }}" class="d-block py-1"
                        target="_blank">
                        <i class="fas fa-user me-2"></i>
                        Switch to {{ ucfirst($account->role_name ?? 'N/A') }} Dashboard
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    {{-- @if ($investmentModules->isNotEmpty()) --}}
    <div class="dropdown">
        {{-- Main Dropdown --}}
        <a href="#"
            class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/trainer/*') ? 'active' : '' }}"
            data-bs-toggle="collapse" data-bs-target="#investmentDropdown"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/trainer/*') ? 'true' : 'false' }}">
            <span><i class="fas fa-flask"></i> {{$user->modules->last()->name}} </span>
            <i class="fas fa-caret-down"></i>
        </a>

        <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/trainer/*') ? 'show' : '' }}"
            id="investmentDropdown">

            {{-- ================= Create Section ================= --}}
            <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#createSectionDropdown"
                aria-expanded="{{ request()->is('tgg-meta/tgg-india/trainer/sections*') || request()->is('tgg-meta/tgg-india/trainer/links*') || request()->is('tgg-meta/tgg-india/trainer/videos*') ? 'true' : 'false' }}">
                <span><i class="fas fa-plus-circle"></i> Create Section</span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/trainer/sections*') || request()->is('tgg-meta/tgg-india/trainer/links*') || request()->is('tgg-meta/tgg-india/trainer/videos*') ? 'show' : '' }}"
                id="createSectionDropdown">
                @if ($hasLiteratures)
                    <a href="{{ route('tgg-india.trainer.sections.index') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/trainer/sections*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Literatures
                    </a>
                @endif
                @if ($hasLinks)
                    <a href="{{ route('tgg-india.trainer.links.index') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/trainer/links/index') ? 'active' : '' }}">
                        <i class="fas fa-link"></i> Links
                    </a>
                @endif
                @if ($hasVideos)
                    <a href="{{ route('tgg-india.trainer.videos.index') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/trainer/videos/index') ? 'active' : '' }}">
                        <i class="fas fa-video"></i> Videos
                    </a>
                @endif
            </div>

            {{-- ================= View Section ================= --}}
            <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#viewSectionDropdown"
                aria-expanded="{{ request()->is('tgg-meta/tgg-india/trainer/chapters*') || request()->is('tgg-meta/tgg-india/trainer/links/show*') || request()->is('tgg-meta/tgg-india/trainer/videos/show*') ? 'true' : 'false' }}">
                <span><i class="fas fa-eye"></i> View Section</span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/trainer/chapters*') || request()->is('tgg-meta/tgg-india/trainer/links/show*') || request()->is('tgg-meta/tgg-india/trainer/videos/show*') ? 'show' : '' }}"
                id="viewSectionDropdown">

                @if ($hasLiteratures)
                   @foreach ($user->literatures as $literature)
                    @php
                        // Check if any section/chapter inside this literature is active
                        $isActiveLiterature = $literature->sections->contains(function ($section) {
                            return $section->chapters->contains(function ($chapter) {
                                return request()->is('tgg-meta/tgg-india/trainer/chapters/' . $chapter->id);
                            });
                        });
                    @endphp

                    <a href="#"
                        class="dropdown-toggle d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse"
                        data-bs-target="#literature-{{ $literature->id }}"
                        aria-expanded="{{ $isActiveLiterature ? 'true' : 'false' }}"
                        title="{{ $literature->title }}">
                        <span><i class="fas fa-book"></i> {{ $literature->title }}</span>
                        <i class="fas fa-caret-down"></i>
                    </a>

                    @if ($literature->sections && $literature->sections->count() > 0)
                        <div class="collapse ps-3 {{ $isActiveLiterature ? 'show' : '' }}"
                            id="literature-{{ $literature->id }}">

                            @foreach ($literature->sections as $section)
                                @php
                                    // Check if this section contains the current active chapter
                                    $isActiveSection = $section->chapters->contains(function ($chapter) {
                                        return request()->is('tgg-meta/tgg-india/trainer/chapters/' . $chapter->id);
                                    });
                                @endphp

                                @if ($section->chapters && $section->chapters->count() > 0)
                                    <a href="#"
                                        class="dropdown-toggle d-flex justify-content-between align-items-center"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#section-{{ $section->id }}"
                                        aria-expanded="{{ $isActiveSection ? 'true' : 'false' }}"
                                        title="{{ $section->title }}">
                                        <span><i class="fas fa-list"></i> {{ $section->title }}</span>
                                        <i class="fas fa-caret-down"></i>
                                    </a>

                                    <div class="collapse ps-3 {{ $isActiveSection ? 'show' : '' }}"
                                        id="section-{{ $section->id }}">
                                        @foreach ($section->chapters as $chapter)
                                            <a href="{{ route('tgg-india.trainer.chapters.show', $chapter->id) }}"
                                                title="{{ $chapter->title }}"
                                                class="{{ request()->is('tgg-meta/tgg-india/trainer/chapters/' . $chapter->id) ? 'active' : '' }}">
                                                <i class="fas fa-book"></i> {{ $chapter->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach

                @endif

                @if ($hasLinks)
                    <a href="{{ route('tgg-india.trainer.links.show') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/trainer/links/show*') ? 'active' : '' }}">
                        <i class="fas fa-link"></i> Links
                    </a>
                @endif

                @if ($hasVideos)
                    <a href="{{ route('tgg-india.trainer.videos.show') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/trainer/videos/show*') ? 'active' : '' }}">
                        <i class="fas fa-video"></i> Videos
                    </a>
                @endif
            </div>

            <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#featureLimitDropdown"
                aria-expanded="{{ request()->is('tgg-meta/tgg-india/trainer/feature-limits*') ? 'true' : 'false' }}">
                <span><i class="fas fa-sliders-h"></i> Feature Limits</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/trainer/feature-limits*') ? 'show' : '' }}"
                id="featureLimitDropdown">
                <a href="{{ route('tgg-india.trainer.feature-limits.index') }}"
                    class="{{ request()->is('tgg-meta/tgg-india/trainer/feature-limits') ? 'active' : '' }}">
                    <i class="fas fa-list-ul"></i> Manage Feature Limits
                </a>
                {{-- <a href="{{ route('tgg-india.trainer.feature-limits.assign') }}"
                    class="{{ request()->is('tgg-meta/tgg-india/trainer/feature-limits/assign*') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Assign Limits
                </a> --}}
            </div>

        </div>
    </div>



    {{-- @endif --}}
    <a href="{{ route('tgg-india.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
