    @php
        $user = auth('web2')->user();
        $modules = $user->modules;
        $host = request()->getHost();
        if ($host === 'localhost' || $host === '127.0.0.1') {
            // Local environment
            $investmentModules = $user->modules->filter(function ($module) {
                return $module->slug === 'investment-sip' || $module->name === 'Investment sip';
            });
        } else {
            // Server (production/staging)
            $investmentModules = $user->modules->filter(function ($module) {
                return $module->slug === 'investment-for-beginners' || $module->name === 'INVESTMENT FOR BEGINNERS';
            });
        }

        $features = $user->modules->flatMap->features;
        // Check for specific feature keys
        $hasLiteratures = $features->contains('feature_key', 'literatures');
        $hasLinks = $features->contains('feature_key', 'links');
        $hasVideos = $features->contains('feature_key', 'videos');
        $otherAccounts = \App\Models\UserSecondary::where('email', $user->email)->where('id', '!=', $user->id)->get();
        $literatures = \App\Models\Literature::get();
        $assignments = \App\Models\AssignmentSecondary::where('assigned_to', auth('web2')->id())->get();
    @endphp
    <a href="{{ route('tgg-india.advisor.dashboard') }}"
        class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <a href="{{ route('tgg-india.advisor.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i
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
        <a href="{{ route('tgg-india.advisor.assignments.index') }}"
            class="{{ request()->is('tgg-edge/tgg-fct/assignee/assignments*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Assignments
        </a>
    @endif

    <div class="dropdown">
        <a href="#"
            class="dropdown-toggle d-flex justify-content-between align-items-center 
        {{ request()->is('tgg-meta/tgg-india/advisor/incentives*') || request()->is('tgg-meta/tgg-india/advisor/rewards*') || request()->is('tgg-meta/tgg-india/advisor/invoices*') || request()->is('tgg-meta/tgg-india/advisor/receipts*') ? 'active' : '' }}"
            data-bs-toggle="collapse" data-bs-target="#advancementDropdown"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/advisor/incentives*') || request()->is('tgg-meta/tgg-india/advisor/rewards*') || request()->is('tgg-meta/tgg-india/advisor/invoices*') || request()->is('tgg-meta/tgg-india/advisor/receipts*') ? 'true' : 'false' }}">
            <span><i class="fas fa-arrow-up me-2"></i> Advancement</span>
            <i class="fas fa-caret-down"></i>
        </a>
        <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/advisor/incentives*') || request()->is('tgg-meta/tgg-india/advisor/rewards*') || request()->is('tgg-meta/tgg-india/advisor/invoices*') || request()->is('tgg-meta/tgg-india/advisor/receipts*') ? 'show' : '' }}"
            id="advancementDropdown">
            <a href="{{ route('tgg-india.advisor.incentives.index') }}" class="d-block py-1">
                <i class="fas fa-gift me-2"></i> Incentive
            </a>
            <a href="{{ route('tgg-india.advisor.rewards.index') }}" class="d-block py-1">
                <i class="fas fa-trophy me-2"></i> Reward
            </a>
            <a href="{{ route('tgg-india.advisor.invoices.index') }}" class="d-block py-1">
                <i class="fas fa-file-invoice me-2"></i> Invoice
            </a>
            <a href="{{ route('tgg-india.advisor.receipts.index') }}" class="d-block py-1">
                <i class="fas fa-receipt me-2"></i> Receipt
            </a>
        </div>
    </div>


    <div class="dropdown">
        <a href="#sitemaplink" class="dropdown-toggle d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sitemaplink">
            <span><i class="fas fa-sitemap me-2"></i>Links (Sitemap)</span>
            <i class="fas fa-caret-down"></i>
        </a>
        <div class="collapse ps-3 {{ request()->is('user/login') || request()->is('uses/researcher') ? 'show' : '' }}"
            id="sitemaplink">
            <a href="{{ url('https://tggindia.com/my-account/') }}" class="d-block py-1" target="_blank"
                rel="noopener noreferrer">
                <i class="fas fa-sign-in-alt me-2"></i> Journey with TGG Login
            </a>
        </div>
    </div>

    @if ($user->modules->isNotEmpty())
        {{-- Top-level Modules dropdown --}}
        <div class="dropdown">
            <a href="#"
                class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/advisor/modules*') ? 'active' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#modulesDropdown"
                aria-expanded="{{ request()->is('tgg-meta/tgg-india/advisor/modules*') ? 'true' : 'false' }}">
                <span><i class="fas fa-flask"></i> Modules</span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/advisor/modules*') ? 'show' : '' }}"
                id="modulesDropdown">
                @foreach ($user->modules as $module)
                    @php
                        $moduleId = 'module-' . $module->id;
                        $moduleInstance = \App\Models\ModuleInstance::where('module_id', $module->id)->first();
                        $moduleInstanceId = $moduleInstance ? $moduleInstance->id : null;
                        $literatures = \App\Models\Literature::where('module_instance_id', $moduleInstanceId)->get();

                        // Default flags
                        $isModuleActive = false;
                        $activeLiteratureId = null;
                        $activeSectionId = null;
                        $activeChapterId = null;

                        // Find which literature/section/chapter is active based on the URL
                        foreach ($literatures as $lit) {
                            foreach ($lit->sections as $sec) {
                                foreach ($sec->chapters as $ch) {
                                    if (request()->is('tgg-meta/tgg-india/advisor/modules/chapters/' . $ch->id)) {
                                        $isModuleActive = true;
                                        $activeLiteratureId = $lit->id;
                                        $activeSectionId = $sec->id;
                                        $activeChapterId = $ch->id;
                                    }
                                }
                            }
                        }
                        if (
                            (request()->is('tgg-meta/tgg-india/advisor/modules/links') &&
                                request()->get('module_instance_id') == $moduleInstanceId) ||
                            (request()->is('tgg-meta/tgg-india/advisor/modules/videos') &&
                                request()->get('module_instance_id') == $moduleInstanceId)
                        ) {
                            $isModuleActive = true;
                        }
                    @endphp

                    {{-- MODULE --}}
                    <div class="dropdown">
                        <a href="#"
                            class="dropdown-toggle d-flex justify-content-between align-items-center {{ $isModuleActive ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#{{ $moduleId }}"
                            aria-expanded="{{ $isModuleActive ? 'true' : 'false' }}"
                            aria-controls="{{ $moduleId }}">
                            <span><i class="fas fa-flask"></i> {{ $module->name }}</span>
                            <i class="fas fa-caret-down"></i>
                        </a>

                        <div class="collapse ps-3 {{ $isModuleActive ? 'show' : '' }}" id="{{ $moduleId }}"
                            data-bs-parent="#modulesDropdown">

                            {{-- LITERATURES --}}
                            @foreach ($literatures as $literature)
                                @php
                                    $literatureId = 'literature-' . $literature->id;
                                    $isLiteratureActive = $activeLiteratureId === $literature->id;
                                @endphp

                                <a href="#"
                                    class="dropdown-toggle d-flex justify-content-between align-items-center {{ $isLiteratureActive ? 'active' : '' }}"
                                    data-bs-toggle="collapse" data-bs-target="#{{ $literatureId }}"
                                    aria-expanded="{{ $isLiteratureActive ? 'true' : 'false' }}"
                                    aria-controls="{{ $literatureId }}">
                                    <span><i class="fas fa-book"></i> {{ $literature->title }}</span>
                                    <i class="fas fa-caret-down"></i>
                                </a>

                                <div class="collapse ps-3 {{ $isLiteratureActive ? 'show' : '' }}"
                                    id="{{ $literatureId }}" data-bs-parent="#{{ $moduleId }}">

                                    {{-- SECTIONS --}}
                                    @foreach ($literature->sections as $section)
                                        @php
                                            $sectionId = 'section-' . $section->id;
                                            $isSectionActive = $activeSectionId === $section->id;
                                        @endphp

                                        <a href="#"
                                            class="dropdown-toggle d-flex justify-content-between align-items-center {{ $isSectionActive ? 'active' : '' }}"
                                            data-bs-toggle="collapse" data-bs-target="#{{ $sectionId }}"
                                            aria-expanded="{{ $isSectionActive ? 'true' : 'false' }}"
                                            aria-controls="{{ $sectionId }}">
                                            <span><i class="fas fa-list"></i> {{ $section->title }}</span>
                                            <i class="fas fa-caret-down"></i>
                                        </a>

                                        <div class="collapse ps-3 {{ $isSectionActive ? 'show' : '' }}"
                                            id="{{ $sectionId }}" data-bs-parent="#{{ $literatureId }}">
                                            {{-- CHAPTERS --}}
                                            @foreach ($section->chapters as $chapter)
                                                <a href="{{ route('tgg-india.advisor.modules.chapters', $chapter->id) }}"
                                                    class="{{ request()->is('tgg-meta/tgg-india/advisor/modules/chapters/' . $chapter->id) ? 'active' : '' }}">
                                                    <i class="fas fa-book"></i> {{ $chapter->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                            {{-- LINKS --}}
                            @if ($hasLinks)
                                <a href="{{ route('tgg-india.advisor.modules.links') }}?module_instance_id={{ $moduleInstanceId }}"
                                    class="{{ request()->is('tgg-meta/tgg-india/advisor/modules/links') ? 'active' : '' }}">
                                    <i class="fas fa-link"></i> Links
                                </a>
                            @endif

                            {{-- VIDEOS --}}
                            @if ($hasVideos)
                                <a href="{{ route('tgg-india.advisor.modules.videos') }}?module_instance_id={{ $moduleInstanceId }}"
                                    class="{{ request()->is('tgg-meta/tgg-india/advisor/modules/videos') ? 'active' : '' }}">
                                    <i class="fas fa-video"></i> Videos
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif



    <div class="dropdown">
        <a href="#referrallink"
            class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/advisor/referral/program*') || request()->is('tgg-india/admin/referral/tracking*') ? 'active' : '' }}"
            data-bs-toggle="collapse" role="button"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/advisor/referral/program*') || request()->is('tgg-india/admin/referral/tracking*') ? 'true' : 'false' }}"
            aria-controls="referrallink">
            <span><i class="fas fa-share-alt me-2"></i>Referral</span>
            <i class="fas fa-caret-down"></i>
        </a>

        <div id="referrallink"
            class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/advisor/referral/program*') || request()->is('tgg-india/admin/referral/tracking*') ? 'show' : '' }}">
            <a href="{{ route('tgg-india.advisor.referral.program') }}"
                class="d-block py-1 {{ request()->is('tgg-meta/tgg-india/advisor/referral/program*') ? 'active' : '' }}">
                <i class="fas fa-project-diagram me-2"></i>Referral Program
            </a>

            <a href="{{ route('tgg-india.advisor.referral.tracking') }}"
                class="d-block py-1 {{ request()->is('tgg-india/admin/referral/tracking*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>Referral Tracking
            </a>
        </div>
    </div>


    <a href="{{ route('tgg-india.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>

    @if (url()->current() === url('tgg-meta/tgg-india/advisor/dashboard'))
        <div class="card tgg_news">
            <h3 class="card-title">TGG NEWS</h3>
            <div class="card-inner">
                <div class="slider"
                    style="
                height: 220px !important;
                width: auto !important">
                    @if (!empty($showcase->tgg_news))
                        @foreach ($showcase->tgg_news as $news)
                            <div class="slide "
                                style="
                                height: 220px !important;
                                width: auto !important margin: 10px !important;">
                                <iframe width="100%" height="200" src="{{ getEmbedUrl($news) }}"
                                    frameborder="0"
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
