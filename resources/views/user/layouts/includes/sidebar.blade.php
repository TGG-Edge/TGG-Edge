<a href="{{ route('user.dashboard') }}" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>

<div class="dropdown">
    <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
       data-bs-toggle="collapse" data-bs-target="#researchDropdown" aria-expanded="false">
        <span><i class="fas fa-flask"></i> Research Assistance</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('user/research-assistance/*') ? 'show' : '' }}" id="researchDropdown">
        <a href="{{ route('user.research-assistance.literature') }}"><i class="fas fa-chart-bar"></i> Literature</a>
        <a href="{{ route('user.research-assistance.videos') }}"><i class="fas fa-video"></i> Videos</a>
        <a href="{{ route('user.research-assistance.links') }}"><i class="fas fa-link"></i> Links</a>
        <a href="{{ route('user.research-assistance.linkedin') }}"><i class="fab fa-linkedin"></i> LinkedIn</a>
    </div>
</div>

<a href="{{ route('user.knowledge-research.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Knowledge and Research
</a>

{{-- @if(Auth::check() && Auth::user()->role_id == 1) --}}
        <a href="{{ route('user.users.requests') }}"><i class="fas fa-users"></i> User Requests</a>
{{-- @endif --}}


<a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
