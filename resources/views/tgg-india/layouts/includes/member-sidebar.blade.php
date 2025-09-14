    @php
        $user = auth('web2')->user();
        $modules = $user->modules;
        $investmentModules = $user->modules->filter(function ($module) {
            return $module->slug === 'investment-sip' || $module->name === 'Investment sip';
        });
        $features = $user->modules->flatMap->features;
        // Check for specific feature keys
        $hasLiteratures = $features->contains('feature_key', 'literatures');
        $hasLinks = $features->contains('feature_key', 'links');
        $hasVideos = $features->contains('feature_key', 'videos');
        $otherAccounts = \App\Models\UserSecondary::where('email', $user->email)->where('id', '!=', $user->id)->get();
        $literatures = \App\Models\Literature::get();
        $assignments = \App\Models\AssignmentSecondary::where('assigned_to', auth('web2')->id())->get();
    @endphp
    <a href="{{ route('tgg-india.member.dashboard') }}"
        class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <a href="{{ route('tgg-india.member.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i
            class="fas fa-user"></i> Profile</a>


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

    @if ($assignments->count() > 0)
        <a href="{{ route('tgg-india.member.assignments.index') }}"
            class="{{ request()->is('tgg-edge/tgg-fct/assignee/assignments') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Assignments
        </a>
    @endif

    <div class="dropdown">
    <a href="#sitemaplink"
       class="dropdown-toggle d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse"
       role="button"
       aria-expanded="false"
       aria-controls="sitemaplink">
        <span><i class="fas fa-sitemap me-2"></i>Links (Sitemap)</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('user/login') || request()->is('uses/researcher') ? 'show' : '' }}"
         id="sitemaplink">
        <a href="{{ url(' https://tggindia.com/my-account/') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-sign-in-alt me-2"></i> Journey with TGG Login
        </a>
    </div>
</div>

    @if ($investmentModules->isNotEmpty())
        <div class="dropdown">
            {{-- Main Investment Dropdown --}}
            <a href="#"
                class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/member/modules*') ? 'active' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#researchDropdown"
                aria-expanded="{{ request()->is('tgg-meta/tgg-india/member/modules*') ? 'true' : 'false' }}">
                <span><i class="fas fa-flask"></i> Investment </span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/member/modules*') ? 'show' : '' }}"
                id="researchDropdown">

                {{-- ================= Literatures ================= --}}
                @if ($hasLiteratures)

                    @foreach ($literatures as $literature)
                        @php
                            $literatureActive = request()->is('tgg-meta/tgg-india/member/modules/chapters/*');
                        @endphp

                        <a href="#"
                            class="dropdown-toggle d-flex justify-content-between align-items-center {{ $literatureActive ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#literature-{{ $literature->id }}"
                            aria-expanded="{{ $literatureActive ? 'true' : 'false' }}"
                            title="{{ $literature->title }}">
                            <span><i class="fas fa-book"></i>Literature</span>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        @if ($literature->sections && $literature->sections->count() > 0)
                            <div class="collapse ps-3 {{ $literatureActive ? 'show' : '' }}"
                                id="literature-{{ $literature->id }}">
                                {{-- Loop Sections --}}
                                @foreach ($literature->sections as $section)
                                    @php
                                        // Check if any chapter inside this section is active
                                        $sectionActive = false;
                                        if ($section->chapters && $section->chapters->count() > 0) {
                                            foreach ($section->chapters as $chapter) {
                                                if (
                                                    request()->is(
                                                        'tgg-meta/tgg-india/member/modules/chapters/' . $chapter->id,
                                                    )
                                                ) {
                                                    $sectionActive = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp

                                    <a href="#"
                                        class="dropdown-toggle d-flex justify-content-between align-items-center {{ $sectionActive ? 'active' : '' }}"
                                        data-bs-toggle="collapse" data-bs-target="#section-{{ $section->id }}"
                                        aria-expanded="{{ $sectionActive ? 'true' : 'false' }}"
                                        title="{{ $section->title }}">
                                        <span><i class="fas fa-list"></i> {{ $section->title }}</span>
                                        <i class="fas fa-caret-down"></i>
                                    </a>

                                    {{-- Loop Chapters --}}
                                    @if ($section->chapters && $section->chapters->count() > 0)
                                        <div class="collapse ps-3 {{ $sectionActive ? 'show' : '' }}"
                                            id="section-{{ $section->id }}">
                                            @foreach ($section->chapters as $chapter)
                                                <a href="{{ route('tgg-india.member.modules.chapters', $chapter->id) }}"
                                                    title="{{ $chapter->title }}"
                                                    class="{{ request()->is('tgg-meta/tgg-india/member/modules/chapters/' . $chapter->id) ? 'active' : '' }}">
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

                {{-- ================= Links ================= --}}
                @if ($hasLinks)
                    <a href="{{ route('tgg-india.member.modules.links') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/member/modules/links') ? 'active' : '' }}">
                        <i class="fas fa-link"></i> Links
                    </a>
                @endif

                {{-- ================= Videos ================= --}}
                @if ($hasVideos)
                    <a href="{{ route('tgg-india.member.modules.videos') }}"
                        class="{{ request()->is('tgg-meta/tgg-india/member/modules/videos') ? 'active' : '' }}">
                        <i class="fas fa-video"></i> Videos
                    </a>
                @endif
            </div>
        </div>
    @endif


    <a href="{{ route('tgg-india.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>

    @if (url()->current() === url('tgg-meta/tgg-india/member/dashboard'))
    <div class="card tgg_news">
        <h3 class="card-title">TGG NEWS</h3>
        <div class="card-inner">
            <div class="slider" style="
                height: 220px !important;
                width: auto !important">
                @if (!empty($showcase->tgg_news))
                    @foreach ($showcase->tgg_news as $news)
                        <div class="slide " style="
                                height: 220px !important;
                                width: auto !important margin: 10px !important;">
                            <iframe width="100%" height="200" src="{{ getEmbedUrl($news) }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endforeach
                @else
                    <p>No news available</p>
                @endif
            </div>
        </div>
    </div>
    @endif


    {{-- WhatsApp Message Admin Box --}}
    <div class="mt-4 p-4 border rounded bg-light text-center shadow-sm" style="min-height: 220px;">
        <h6 class="fw-bold mb-3 text-dark">
            <i class="fab fa-whatsapp text-success me-1"></i> Message Admin
        </h6>

        <p class="small text-muted mb-4">
            Need help? Chat directly with the admin on WhatsApp.
        </p>

        {{-- 🔗 Replace 919995329536 with admin WhatsApp number --}}
        {{-- And replace the text after ?text= with your own message (use %20 for spaces) --}}
        <a href="https://wa.me/919995329536/?text=Hello%20Admin,%20I%20need%20some%20help." target="_blank"
            class="btn btn-success w-100 d-flex align-items-center justify-content-center py-2">
            <i class="fab fa-whatsapp me-2"></i> Start Chat
        </a>
    </div>

   
    

