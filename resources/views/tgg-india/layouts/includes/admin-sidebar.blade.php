
{{-- @php
    if(auth()->user()->user_role == 1){
        $dashboardRoute = route('user.admin-dashboard'); 

    }elseif(auth()->user()->user_role == 2){
        $dashboardRoute = route('user.researcher-dashboard'); 

    }elseif(auth()->user()->user_role == 3){
        $dashboardRoute = route('user.volunteer-dashboard'); 

    }else{
        $dashboardRoute = route('user.dashboard'); 
    } 
@endphp --}}
<a href="#" class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>


<a href="{{ route('tgg-india.admin.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="showcaseDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-star"></i> Showcase
    </a>
    <ul class="dropdown-menu" aria-labelledby="showcaseDropdown">
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'welcome_note']) }}">Welcome Note</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'entrepreneurship']) }}">Entrepreneurship Opportunities</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'woodpecker']) }}">Woodpecker Collection</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'travel']) }}">Travel & Events</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'homes']) }}">TGG Homes</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'news']) }}">TGG News</a></li>
        <li><a class="dropdown-item" href="{{ route('tgg-india.admin.showcases.edit', ['section' => 'investment']) }}">Investment Opportunities</a></li>
    </ul>
</li>

<a href="{{ route('tgg-india.admin.modules.index') }}" class="{{ request()->is('tgg-india/admin/modules*') ? 'active' : '' }}">
    <i class="fas fa-cubes"></i> Modules
</a>

<a href="{{ route('tgg-india.admin.feature-limits.index') }}" class="{{ request()->is('tgg-india/admin/feature-limits*') ? 'active' : '' }}">
    <i class="fas fa-sliders-h"></i> Feature Limits
</a>


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
        <a href="{{ route('tgg-india.admin.new-applications') }}" class="d-block py-1">
            <i class="fas fa-user-plus me-2"></i> New Applications
        </a>
        <a href="{{ route('tgg-india.admin.processed-applications') }}" class="d-block py-1">
            <i class="fas fa-check-circle me-2"></i> Processed Applications
        </a>
    </div>
</div>


{{-- 
@if(Auth::check() && Auth::user()->user_role != 1 && Auth::user()->research_assistance == 1)
<div class="dropdown">
    <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('user/research-assistance/*') ? 'active ' : '' }}"
       data-bs-toggle="collapse" data-bs-target="#researchDropdown" aria-expanded="false">
        <span><i class="fas fa-flask"></i> Research Assistance</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('user/research-assistance/*') ? 'show ' : '' }}" id="researchDropdown">
        <a href="{{ route('user.research-assistance.literature') }}"><i class="fas fa-chart-bar"></i> Literature</a>
        <a href="{{ route('user.research-assistance.videos') }}"><i class="fas fa-video"></i> Videos</a>
        <a href="{{ route('user.research-assistance.links') }}"><i class="fas fa-link"></i> Links</a>
        <a href="{{ route('user.research-assistance.linkedin') }}"><i class="fab fa-linkedin"></i> LinkedIn</a>
    </div>
</div>
@endif


<a href="{{ route('user.knowledge-research.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Knowledge and Research
</a>

@if(Auth::check() && Auth::user()->user_role == 1)
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
