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
    @endphp
    <a href="#" class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <a href="{{ route('tgg-india.member.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i
            class="fas fa-user"></i> Profile</a>

    @if ($investmentModules->isNotEmpty())
        <div class="dropdown">
            <a href="#"
                class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('user/research-assistance/*') ? 'active ' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#researchDropdown" aria-expanded="false">
                <span><i class="fas fa-flask"></i> Investment </span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('user/research-assistance/*') ? 'show ' : '' }}"
                id="researchDropdown">
                @if ($hasLiteratures)
                    {{-- Literature Dropdown --}}
                    @foreach (\App\Models\Literature::get() as $literature)
                        <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#literature-{{ $literature->id }}"
                            aria-expanded="false" title="{{ $literature->title }}">
                            <span><i class="fas fa-book"></i> Literature </span>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        @if ($literature->sections && $literature->sections->count() > 0)
                            <div class="collapse ps-3" id="literature-{{ $literature->id }}">

                                {{-- Loop through sections --}}
                                @foreach ($literature->sections as $section)
                                    @if ($section->chapters && $section->chapters->count() > 0)
                                        <a href="#"
                                            class="dropdown-toggle d-flex justify-content-between align-items-center"
                                            data-bs-toggle="collapse" data-bs-target="#section-{{ $section->id }}"
                                            aria-expanded="false" title="{{ $section->title }}">
                                            <span><i class="fas fa-list"></i> Section</span>
                                            <i class="fas fa-caret-down"></i>
                                        </a>

                                        <div class="collapse ps-3" id="section-{{ $section->id }}">
                                            {{-- Loop chapters --}}
                                            @foreach ($section->chapters as $chapter)
                                                <a href="{{ route('tgg-india.member.modules.chapters', $chapter->id) }}"
                                                    title="{{ $chapter->title }}"><i
                                                        class="fas fa-book"></i>Chapter</a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif

                {{-- Links --}}
                 @if ($hasLinks)
                <a href="{{ route('tgg-india.member.modules.links') }}"><i class="fas fa-link"></i> Links</a>
                @endif

                {{-- Videos --}}
                @if ($hasVideos)
                <a href="{{ route('tgg-india.member.modules.videos') }}"><i class="fas fa-video"></i> Videos</a>
                @endif



            </div>
        </div>

    @endif



    {{-- 
<a href="{{ route('user.profile') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

@if (Auth::check() && Auth::user()->user_role != 1 && Auth::user()->research_assistance == 1)
@endif
<a href="{{ route('user.knowledge-research.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Knowledge and Research
</a>

@if (Auth::check() && Auth::user()->user_role == 1)
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
        <a href="{{ route('user.login') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-sign-in-alt me-2"></i> Login
        </a>
        <a href="{{ url('user/register/researcher') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-edit me-2"></i> Researcher Register
        </a>
        <a href="{{ url('user/register/volunteer') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Volunteer Register
        </a>
    </div>
</div>






<div class="dropdown">
    <a href="#"
       class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('user/new-applications*') || request()->is('user/processed-applications*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       data-bs-target="#applicationDropdown"
       aria-expanded="{{ request()->is('user/new-applications*') || request()->is('user/processed-applications*') ? 'true' : 'false' }}">
        <span><i class="fas fa-file-alt me-2"></i> Applications</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('user/new-applications*') || request()->is('user/processed-applications*') ? 'show' : '' }}"
         id="applicationDropdown">
        <a href="{{ route('user.new-applications') }}" class="d-block py-1">
            <i class="fas fa-user-plus me-2"></i> New Applications
        </a>
        <a href="{{ route('user.processed-applications') }}" class="d-block py-1">
            <i class="fas fa-check-circle me-2"></i> Processed Applications
        </a>
    </div>
</div>

<div class="dropdown">
    <a href="#"
       class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('user/researcher-projects*') || request()->is('user/volunteer-projects*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       data-bs-target="#projectDropdown"
       aria-expanded="{{ request()->is('user/researcher-projects*') || request()->is('user/volunteer-projects*') ? 'true' : 'false' }}">
        <span><i class="fas fa-folder-open me-2"></i> Projects</span>
        <i class="fas fa-caret-down"></i>
    </a>

    <div class="collapse ps-3 {{ request()->is('user/researcher-projects*') || request()->is('user/volunteer-projects*') ? 'show' : '' }}"
         id="projectDropdown">
        <a href="{{ route('user.researcher-projects') }}" class="d-block py-1">
            <i class="fas fa-flask me-2"></i> Researcher Projects
        </a>
        
        <a href="{{ route('user.volunteer-projects') }}" class="d-block py-1">
            <i class="fas fa-hands-helping me-2"></i> Volunteer Projects
        </a>
    </div>
</div>


@endif


<a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a> --}}
