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
    <a href="{{ route('tgg-india.facilitator.dashboard') }}"
        class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <a href="{{ route('tgg-india.facilitator.profile.index') }}" class="{{ request()->is('user/profile') ? 'active' : '' }}"><i
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
        <a href="{{ route('tgg-india.facilitator.assignments.index') }}"
            class="{{ request()->is('tgg-edge/tgg-fct/assignee/assignments*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Assignments
        </a>
    @endif

    <div class="dropdown">
        <a href="#"
            class="dropdown-toggle d-flex justify-content-between align-items-center
            {{ request()->is('tgg-meta/tgg-india/*/templates*') ? 'active' : '' }}"
            data-bs-toggle="collapse"
            data-bs-target="#campaignDropdown"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/*/templates*') ? 'true' : 'false' }}">
            
            <span>
                <i class="fas fa-bullhorn me-2"></i> Campaign
            </span>
            <i class="fas fa-caret-down"></i>
        </a>

        <div class="collapse ps-3
            {{ request()->is('tgg-meta/tgg-india/*/templates*') ? 'show' : '' }}"
            id="campaignDropdown">

            {{-- Templates --}}
            {{-- <a href="{{ route('tgg-india.templates.index', 'facilitator') }}"
            class="d-block py-1
            {{ request()->is('tgg-meta/tgg-india/*/templates') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text me-2"></i> Templates
            </a> --}}

            {{-- Future (campaigns, logs, reports) --}}
            
            <a href="{{ route('tgg-india.campaigns.index', 'facilitator') }}"
                class="d-block py-1
                {{ request()->is('tgg-meta/tgg-india/*/campaigns*') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane me-2"></i> Campaigns
            </a>
        
            <a href="{{ route('tgg-india.email-check.index', 'facilitator') }}"
            class="d-block py-1
            {{ request()->is('tgg-meta/tgg-india/*/email-check*') ? 'active' : '' }}">
                <i class="fas fa-envelope-circle-check me-2"></i> Email Check
            </a>


        </div>
    </div>

    <div class="dropdown">
        <a href="#"
            class="dropdown-toggle d-flex justify-content-between align-items-center 
        {{ request()->is('tgg-meta/tgg-india/facilitator/incentives*') || request()->is('tgg-meta/tgg-india/facilitator/rewards*') || request()->is('tgg-meta/tgg-india/facilitator/invoices*') || request()->is('tgg-meta/tgg-india/facilitator/receipts*') ? 'active' : '' }}"
            data-bs-toggle="collapse" data-bs-target="#advancementDropdown"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/facilitator/incentives*') || request()->is('tgg-meta/tgg-india/facilitator/rewards*') || request()->is('tgg-meta/tgg-india/facilitator/invoices*') || request()->is('tgg-meta/tgg-india/facilitator/receipts*') ? 'true' : 'false' }}">
            <span><i class="fas fa-arrow-up me-2"></i> Advancement</span>
            <i class="fas fa-caret-down"></i>
        </a>
        <div class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/facilitator/incentives*') || request()->is('tgg-meta/tgg-india/facilitator/rewards*') || request()->is('tgg-meta/tgg-india/facilitator/invoices*') || request()->is('tgg-meta/tgg-india/facilitator/receipts*') ? 'show' : '' }}"
            id="advancementDropdown">
            <a href="{{ route('tgg-india.facilitator.invoices.index') }}" class="d-block py-1">
                <i class="fas fa-file-invoice me-2"></i> Invoice
            </a>
            <a href="{{ route('tgg-india.facilitator.receipts.index') }}" class="d-block py-1">
                <i class="fas fa-receipt me-2"></i> Receipt
            </a>
        </div>
    </div>


    <div class="dropdown">
        <a href="#referrallink"
            class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('tgg-meta/tgg-india/facilitator/referral/program*') || request()->is('tgg-india/facilitator/referral/tracking*') ? 'active' : '' }}"
            data-bs-toggle="collapse" role="button"
            aria-expanded="{{ request()->is('tgg-meta/tgg-india/facilitator/referral/program*') || request()->is('tgg-india/facilitator/referral/tracking*') ? 'true' : 'false' }}"
            aria-controls="referrallink">
            <span><i class="fas fa-share-alt me-2"></i>Lead Generate</span>
            <i class="fas fa-caret-down"></i>
        </a>

        <div id="referrallink"
            class="collapse ps-3 {{ request()->is('tgg-meta/tgg-india/facilitator/referral/program*') || request()->is('tgg-india/facilitator/referral/tracking*') ? 'show' : '' }}">
            <a href="{{ route('tgg-india.facilitator.referral.program') }}"
                class="d-block py-1 {{ request()->is('tgg-meta/tgg-india/facilitator/referral/program*') ? 'active' : '' }}">
                <i class="fas fa-project-diagram me-2"></i>Lead Referral Link
            </a>

            <a href="{{ route('tgg-india.facilitator.enquiry.referral.tracking') }}"
                class="d-block py-1 {{ request()->is('tgg-india/facilitator/enquiry.referral/tracking*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>Lead Generated Tracking
            </a>
        </div>
    </div>


    <a href="{{ route('tgg-india.logout') }}"><i class="fas fa-sign-out-alt"></i> Log out</a>

   
