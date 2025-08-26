
<a href="#" class="{{ request()->is('user/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>

<a href="{{ route('tgg-fct.admin.profile') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>

<a href="{{ route('tgg-fct.admin.knowledge-research.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-book"></i> Knowledge and Research
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
        <a href="{{ route('tgg-fct.admin.login') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
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
        <a href="{{ route('tgg-fct.admin.new-applications') }}" class="d-block py-1">
            <i class="fas fa-user-plus me-2"></i> New Applications
        </a>
        <a href="{{ route('tgg-fct.admin.processed-applications') }}" class="d-block py-1">
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
        <a href="{{ route('tgg-fct.admin.researcher-projects') }}" class="d-block py-1">
            <i class="fas fa-flask me-2"></i> Researcher Projects
        </a>
        
        <a href="{{ route('tgg-fct.admin.volunteer-projects') }}" class="d-block py-1">
            <i class="fas fa-hands-helping me-2"></i> Volunteer Projects
        </a>
    </div>
</div>


<div class="dropdown">
    <a href="#manage-content"
       class="dropdown-toggle d-flex justify-content-between align-items-center text-decoration-none py-2"
       data-bs-toggle="collapse"
       role="button"
       aria-expanded="{{ request()->is('admin/welcome-note*') || request()->is('admin/wood-collection*') || request()->is('admin/entrepreneurship*') ? 'true' : 'false' }}"
       aria-controls="manage-content">
        <span><i class="fas fa-sitemap me-2"></i> Manage Content</span>
        <i class="fas fa-caret-down"></i>
    </a>

    <div class="collapse ps-3 {{ request()->is('admin/welcome-note*') || request()->is('admin/wood-collection*') || request()->is('admin/entrepreneurship*') ? 'show' : '' }}"
         id="manage-content">
        <a href="{{ route('tgg-fct.admin.manage-content.welcome-note.edit') }}" class="d-block py-1 text-decoration-none">
            <i class="fas fa-handshake me-2"></i> Welcome Note
        </a>
        <a href="{{ route('tgg-fct.admin.manage-content.wood-collection.index') }}" class="d-block py-1 text-decoration-none">
            <i class="fas fa-tree me-2"></i> Wood Collection
        </a>
        <a href="{{ route('tgg-fct.admin.manage-content.entrepreneurship.index') }}" class="d-block py-1 text-decoration-none">
            <i class="fas fa-briefcase me-2"></i> Entrepreneurship
        </a>
    </div>
</div>


<a href="{{ route('tgg-fct.admin.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
