

<a href="#" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>

<a href="{{ route('tgg-fct.assignee.profile') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

<a href="{{ route('tgg-fct.assignee.assignments.index') }}" class="{{ request()->is('tgg-edge/tgg-fct/assignee/assignments') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Assignments
</a>

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

<a href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
