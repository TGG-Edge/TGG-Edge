
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
<a href="{{route('tgg-india.admin.dashboard')}}" class="{{ request()->is('tgg-meta/tgg-india/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>


<a href="{{ route('tgg-india.admin.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fas fa-user"></i> Profile</a>


{{-- <a href="{{ route('tgg-india.admin.showcases.edit') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i class="fa-solid fa-display"></i> Showcase</a> --}}
<div class="dropdown">
    <a href="#"
       class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/admin/showcases*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       data-bs-target="#showcaseDropdown"
       aria-expanded="{{ request()->is('tgg-meta/tgg-india/admin/showcases*') ? 'true' : 'false' }}">
        <span><i class="fa-solid fa-display me-2"></i> Showcase</span>
        <i class="fas fa-caret-down"></i>
    </a>
    <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/admin/showcases*') ? 'show' : '' }}"
         id="showcaseDropdown">
        <a href="{{ route('tgg-india.admin.showcases.welcome-notes.edit') }}#welcome-notes" class="d-block py-1">
            <i class="fas fa-sticky-note me-2"></i> Welcome Notes
        </a>
        <a href="{{ route('tgg-india.admin.showcases.collaborative-projects.edit') }}#collaborative-projects" class="d-block py-1">
            <i class="fas fa-handshake me-2"></i> Collaborative Projects
        </a>
        <a href="{{ route('tgg-india.admin.showcases.main-projects.edit') }}#main-projects" class="d-block py-1">
            <i class="fas fa-project-diagram me-2"></i> Main Projects
        </a>
        <a href="{{ route('tgg-india.admin.showcases.freelance-opportunities.edit') }}#freelance-opportunities" class="d-block py-1">
            <i class="fas fa-briefcase me-2"></i> Freelance Opportunities
        </a>

        <a href="{{ route('tgg-india.admin.showcases.referral.edit') }}#main-projects" class="d-block py-1">
            <i class="fas fa-user-friends me-2"></i> Referral Content
        </a>

        <a href="{{ route('tgg-india.admin.showcases.reward.edit') }}#freelance-opportunities" class="d-block py-1">
            <i class="fas fa-gift me-2"></i> Reward Content
</a>

    </div>
</div>


<a href="{{ route('tgg-india.admin.assignments.index') }}" class="{{ request()->is('user/knowledge-research') ? 'active' : '' }}">
    <i class="fas fa-clipboard-list"></i> Assignments
</a>

@php
    $isAdvancementActive = request()->is('tgg-meta/tgg-india/admin/incentives*')
        || request()->is('tgg-meta/tgg-india/admin/rewards*')
        || request()->is('tgg-meta/tgg-india/admin/donations*')
        || request()->is('tgg-meta/tgg-india/admin/payments*')
        || request()->is('tgg-meta/tgg-india/admin/invoices*')
        || request()->is('tgg-meta/tgg-india/admin/receipts*');
@endphp

<div class="dropdown">
    <a href="#"
       class="dropdown-toggle d-flex justify-content-between align-items-center {{ $isAdvancementActive ? 'active' : '' }}"
       data-bs-toggle="collapse"
       data-bs-target="#advancementDropdown"
       aria-expanded="{{ $isAdvancementActive ? 'true' : 'false' }}">
        <span><i class="fas fa-arrow-up me-2"></i> Advancement</span>
        <i class="fas fa-caret-down"></i>
    </a>

    <div class="collapse ps-3 {{ $isAdvancementActive ? 'show' : '' }}" id="advancementDropdown">
        <a href="{{ route('tgg-india.admin.incentives.index') }}" class="d-block py-1">
            <i class="fas fa-gift me-2"></i> Incentive
        </a>
        <a href="{{ route('tgg-india.admin.rewards.index') }}" class="d-block py-1">
            <i class="fas fa-trophy me-2"></i> Reward
        </a>
        <a href="{{ route('tgg-india.admin.donations.index') }}" class="d-block py-1">
            <i class="fas fa-donate me-2"></i> Donation
        </a>
        <a href="{{ route('tgg-india.admin.payments.index') }}" class="d-block py-1">
            <i class="fas fa-credit-card me-2"></i> Payment
        </a>
        <a href="{{ route('tgg-india.admin.invoices.index') }}" class="d-block py-1">
            <i class="fas fa-file-invoice me-2"></i> Invoice
        </a>
        <a href="{{ route('tgg-india.admin.receipts.index') }}" class="d-block py-1">
            <i class="fas fa-receipt me-2"></i> Receipt
        </a>
    </div>
</div>
    


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
        <a href="{{ route('tgg-india.login') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-sign-in-alt me-2"></i> Login
        </a>
        <a href="{{ url('tgg-meta/tgg-india/register/trainer') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-edit me-2"></i> Trainer Register
        </a>
        <a href="{{ url('tgg-meta/tgg-india/register/members') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Members Register
        </a>
        @php
         $referralCode = Auth('web2')->user()->referral_code;
         $referralLink = url('tgg-meta/tgg-india/register/referral/' . $referralCode);
        @endphp
        <a href="{{ $referralLink }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Members Register - By Referral
        </a>

         <a href="{{ url('tgg-meta/tgg-india/register/rhm-club') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Rhm Club Register
        </a>

         <a href="{{ url('tgg-meta/tgg-india/register/nomad-community') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i>Nomad Community Register
        </a>

         <a href="{{ url('tgg-meta/tgg-india/register/freelancers') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Freelancers Register
        </a>

         <a href="{{ url('https://www.modicare.com/sign-in') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Modicare Register
        </a>

        <a href="{{ url('https://invest.motilaloswal.com/') }}" class="d-block py-1" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-user-friends me-2"></i> Motilaloswal Register
        </a>
    </div>
</div>

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

<a href="{{ route('tgg-india.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>
