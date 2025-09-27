

<a href="{{ route('tgg-fct.assignee.dashboard') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>

<a href="{{ route('tgg-fct.assignee.profile') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

<a href="{{ route('tgg-fct.assignee.assignments.index') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/assignments') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Assignments
</a>

@if(Auth::check() && Auth::user()->user_role != 1 && Auth::user()->is_link_enabled == 1)
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
@endif

@if(Auth::check() && Auth::user()->user_role != 1 && Auth::user()->research_assistance == 1)
<div class="dropdown">
    <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/*') ? 'active ' : '' }}"
       data-bs-toggle="collapse" data-bs-target="#researchDropdown" aria-expanded="false">
        <span><i class="fas fa-flask"></i> Research Assistance</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/*') ? 'show ' : '' }}" id="researchDropdown">
        <a href="{{ route('tgg-fct.assignee.research-assistance.literature') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/literature') ? 'active' : '' }}"><i class="fas fa-chart-bar  "></i> Literature</a>
        <a href="{{ route('tgg-fct.assignee.research-assistance.videos') }}" class=" {{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/videos') ? 'active' : '' }}"><i class="fas fa-video 
            "></i> Videos</a>
        <a href="{{ route('tgg-fct.assignee.research-assistance.links') }}" class=" {{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/links') ? 'active' : '' }}"><i class="fas fa-link "></i> Links</a>
        <a href="{{ route('tgg-fct.assignee.research-assistance.linkedin') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/research-assistance/linkedin') ? 'active' : '' }}"><i class="fab fa-linkedin  "></i> LinkedIn</a>
    </div>
</div>
@endif


<a href="{{ route('tgg-fct.assignee.knowledge-research.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Knowledge and Research
</a>


<a href="{{ route('tgg-fct.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
