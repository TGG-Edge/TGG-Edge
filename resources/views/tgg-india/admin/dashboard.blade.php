@extends('tgg-india.layouts.app')

@section('title', 'Admin Dashbaord | TGG Meta | TGG India')
@php
use App\Models\Incentive;
use App\Models\Reward;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\Referral;
use Illuminate\Support\Facades\Schema;

// ✅ Fetch status-based counts
$incentiveStatus = Incentive::select('status', \DB::raw('count(*) as total'))
    ->groupBy('status')->pluck('total', 'status')->toArray();

$paymentStatus = Payment::select('status', \DB::raw('count(*) as total'))
    ->groupBy('status')->pluck('total', 'status')->toArray();

$invoiceStatus = Invoice::select('status', \DB::raw('count(*) as total'))
    ->groupBy('status')->pluck('total', 'status')->toArray();

$receiptStatus = Receipt::select('status', \DB::raw('count(*) as total'))
    ->groupBy('status')->pluck('total', 'status')->toArray();

$donationCount = Donation::count();
$rewardCount = Reward::count();
$referralCount = Referral::count();

// ✅ Safe amount calculations
$incentiveAmount = Incentive::sum('amount');
$rewardAmount    = Reward::sum('amount');
$invoiceAmount   = Schema::connection('mysql2')->hasColumn('invoices', 'amount') ? Invoice::sum('amount') : 0;
$receiptAmount   = Schema::connection('mysql2')->hasColumn('receipts', 'amount') ? Receipt::sum('amount') : 0;
$donationAmount  = Schema::connection('mysql2')->hasColumn('donations', 'amount') ? Donation::sum('amount') : 0;
$paymentAmount = Schema::connection('mysql2')->hasColumn('payments', 'amount') ? Payment::sum('amount') : 0;
@endphp
@section('content')
<div class="admin-container">
            @include('tgg-india.layouts.includes.message')
            @php
                    $user = \App\Models\UserSecondary::find(auth('web2')->id());
                    $mainApplicant = \App\Models\UserSecondary::where('rhm_number', $user->parent_rhm_number ?? '')->first();
                @endphp

                <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 mb-2">
                    <span><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</span>
                    <span><strong>Role:</strong> {{ $user->role_name ?? 'N/A' }}</span>
                    <span><strong>RHM No:</strong> {{ $user->rhm_number ?? 'N/A' }}</span>
                    
                </div>

            <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('tgg-india.logout') }}">Log out</a>)</p>

            <p><strong>WELCOME TO TGG-EDGE</strong></p>

            <p>It is a dynamic hub where ethical research meets grassroots action. This is where your inquiries, insights, and efforts converge to shape meaningful change through collaborative, well-coordinated projects.</p>

            <p>
                As a volunteer or researcher, you are part of a unified ecosystem committed to experiential learning, rigorous documentation, and outcome-oriented exploration. Here, you’ll find streamlined tools to manage assignments, exchange knowledge, and align your work with the broader values of sustainability, compassion, and community empowerment.
            </p>

            <p>Let’s co-create solutions that bridge theory and practice, deepen local impact, and contribute to a global narrative of self-reliance and human unity. Welcome aboard and onward with purpose.</p>

            {{-- <p>Let us work hand in hand to build a future where learning, working, and living harmoniously with nature and society become the foundation of true well-being. Welcome to a community that believes in the power of mindful transformation!</p> --}}

            <p>With gratitude,<br><strong>TGG Family</strong></p>
             {{-- =================== DASHBOARD CARDS =================== --}}
    @php
        $summary = [
            ['title' => 'Incentives', 'count' => array_sum($incentiveStatus), 'icon' => 'bi-gift', 'color' => 'primary', 'statuses' => $incentiveStatus, 'amount'=>$incentiveAmount],
            ['title' => 'Rewards', 'count' => $rewardCount, 'icon' => 'bi-trophy', 'color' => 'success','amount'=>$rewardAmount],
            ['title' => 'Donations', 'count' => $donationCount, 'icon' => 'bi-heart', 'color' => 'danger','amount'=>$donationAmount],
            ['title' => 'Payments', 'count' => array_sum($paymentStatus), 'icon' => 'bi-cash-coin', 'color' => 'info','amount'=>$paymentAmount, 'statuses' => $paymentStatus],
            ['title' => 'Invoices', 'count' => array_sum($invoiceStatus), 'icon' => 'bi-receipt', 'color' => 'warning', 'statuses' => $invoiceStatus,'amount'=>$invoiceAmount],
            ['title' => 'Receipts', 'count' => array_sum($receiptStatus), 'icon' => 'bi-file-earmark-text', 'color' => 'secondary', 'statuses' => $receiptStatus,'amount'=>$receiptAmount],
            ['title' => 'Referrals', 'count' => $referralCount, 'icon' => 'bi-people', 'color' => 'dark'],
        ];
    @endphp

    <div class="row g-4 mb-5">
        @foreach ($summary as $item)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-lg rounded-4 h-100 dashboard-card position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-box bg-{{ $item['color'] }} bg-opacity-10 rounded-3 p-3">
                                <i class="bi {{ $item['icon'] }} text-{{ $item['color'] }}" style="font-size: 2rem;"></i>
                            </div>
                            <span class="badge bg-{{ $item['color'] }}  text-{{ $item['color'] }}" style="--bs-bg-opacity: 0.2;">{{ strtoupper($item['title']) }} </span>
                        </div>
                        <h2 class="fw-bold text-dark mb-1">{{ $item['count'] }}</h2>
                        @if(isset($item['amount']))
                            @if( $item['title'] == 'Rewards')
                                <p class="text-muted small mb-3">Total Points: {{ number_format($item['amount'],0) }}</p>
                            @else
                                <p class="text-muted small mb-3">Total Amount: ₹{{ number_format($item['amount'],2) }}</p>
                            @endif
                        @else
                            <p class="text-muted small mb-3">{{ $item['title'] }} Total</p>
                        @endif

                        {{-- Show status-wise breakdown (if present) --}}
                        @if (!empty($item['statuses']))
                            <div class="status-breakdown mt-3">
                                @foreach ($item['statuses'] as $status => $total)
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span class="text-capitalize">{{ $status }}</span>
                                        <span class="fw-semibold">{{ $total }}</span>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-{{ $item['color'] }}" role="progressbar"
                                             style="width: {{ ($total / max(1, array_sum($item['statuses']))) * 100 }}%">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- =================== OUR SERVICES (SLIDER) =================== --}}
<h4 class="fw-semibold mb-3 mt-4">Our Services</h4>

@php
$services = [
    ['title'=>'Website Development','image'=>'images/Website_Development.png','content'=>'Static ₹5,000 (5 pages)<br>Non-Member ₹7,000<br>Dynamic: Ask for quote'],
    ['title'=>'Digital Marketing','image'=>'images/Digital_Marketing.jpg','content'=>'Member ₹8,000/month<br>Non-Member ₹10,000/month'],
    ['title'=>'TGG News','image'=>'images/News.jpg','content'=>'AI Podcast / Video Promotion<br>Members only ₹4,000'],
    ['title'=>'Business Development Support','image'=>'images/Business_Development_Support.jpg','content'=>'Members only<br>₹8,000 / month'],
    ['title'=>'Incorporation Support','image'=>'images/Incorporation_Support.png','content'=>'Members only<br>Pricing varies'],
    ['title'=>'Accounting & Auditing Support','image'=>'images/Accounting_Auditing_Support.jpg','content'=>'Only for members'],
    ['title'=>'Legal Support','image'=>'images/Legal_Support.jpg','content'=>'Only for members'],
    ['title'=>'AI Powered Problem Solving','image'=>'images/AI_Powered_Problem_Solving.jpg','content'=>'Instant solutions<br>TGG Family only'],
    ['title'=>'App Development','image'=>'images/App_Development.jpg','content'=>'Member ₹10,000<br>Non-Member ₹15,000'],
    ['title'=>'Custom Software','image'=>'images/Custom_Software.jpg','content'=>'Member ₹10,000<br>Non-Member ₹15,000'],
];
@endphp

@php
$perSlide = 3;
$remainder = count($services) % $perSlide;

if ($remainder !== 0) {
    $services = array_merge(
        $services,
        array_slice($services, 0, $perSlide - $remainder)
    );
}
@endphp

<div class="services-carousel-wrapper">
    <div id="servicesCarousel"
     class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="5000"
     data-bs-pause="false">
    <div class="carousel-inner">

        @foreach(array_chunk($services, 3) as $index => $chunk)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
            <div class="row g-4">
                @foreach($chunk as $service)
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg rounded-4 service-card text-center">
                        <div class="card-body p-4 service-card-body">

                            <img
                                src="{{ asset($service['image']) }}"
                                alt="{{ $service['title'] }}"
                                class="service-img mb-3"
                            >

                            <h6 class="fw-semibold mb-2 text-center">
                                {{ $service['title'] }}
                            </h6>

                            <p class="text-muted small mb-0 text-center">
                                {!! $service['content'] !!}
                            </p>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    {{-- controls --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
</div>


    {{-- =================== OVERVIEW SECTION =================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-light border-0 fw-semibold fs-5">
            Platform Overview
        </div>
        <div class="card-body">
            <p class="text-muted">
                The dashboard provides a unified view of your contributions, incentives, rewards, and financial transactions.
                Stay updated on your progress and collaborate effectively within the TGG ecosystem.
            </p>
            <div class="row text-center mt-4">
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold text-primary mb-0">{{ array_sum($incentiveStatus) + $rewardCount }}</h5>
                    <small class="text-muted">Engagements</small>
                </div>
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold text-success mb-0">{{ $donationCount + $referralCount }}</h5>
                    <small class="text-muted">Community Interactions</small>
                </div>
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold text-info mb-0">{{ array_sum($paymentStatus) + array_sum($invoiceStatus) }}</h5>
                    <small class="text-muted">Transactions</small>
                </div>
                <div class="col-md-3 mb-3">
                    <h5 class="fw-bold text-warning mb-0">{{ array_sum($receiptStatus) }}</h5>
                    <small class="text-muted">Acknowledgements</small>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- =================== EXTRA CSS =================== --}}
<style>
.dashboard-card {
    transition: all 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.1);
}
.icon-box {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 58px;
    height: 58px;
}
.status-breakdown .progress {
    margin-bottom: 0.5rem;
}
.bg-opacity-10 {
    opacity: 0.1 !important;
}
.bg-opacity-20 {
    opacity: 0.2 !important;
}
</style>
@endsection
