@extends('tgg-india.layouts.app', [
    'pageCss' => 'resources/css/pages/dashboard.css'
])

@section('title', 'Admin Dashboard | TGG Meta | TGG India')

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
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    $paymentStatus = Payment::select('status', \DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    $invoiceStatus = Invoice::select('status', \DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    $receiptStatus = Receipt::select('status', \DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    $donationCount = Donation::count();
    $rewardCount = Reward::count();
    $referralCount = Referral::count();

    // ✅ Safe amount calculations
    $incentiveAmount = Incentive::sum('amount');
    $rewardAmount = Reward::sum('amount');

    if (Schema::connection('mysql2')->hasColumn('invoices', 'items')) {
        $invoiceAmount = Invoice::get()
            ->sum(function ($invoice) {
                $items = $invoice->items;
                if (is_array($items)) {
                    return collect($items)->sum('amount');
                }
                return 0;
            });
    } else {
        $invoiceAmount = 0;
    }

    $receiptAmount = Schema::connection('mysql2')->hasColumn('receipts', 'amount') ? Receipt::sum('amount') : 0;
    $donationAmount = Schema::connection('mysql2')->hasColumn('donations', 'amount') ? Donation::sum('amount') : 0;
    $paymentAmount = Schema::connection('mysql2')->hasColumn('payments', 'amount') ? Payment::sum('amount') : 0;
    
    $user = \App\Models\UserSecondary::find(auth('web2')->id());
    
    // ==================== SUMMARY ARRAY FOR STATS ====================
    $summaryStats = [
        [
            'icon' => 'bi-gift',
            'count' => array_sum($incentiveStatus),
            'label' => 'Incentives',
            'color' => '#155DFC',
            'bg' => '#EFF6FF',
            'amount' => $incentiveAmount,
            'statuses' => $incentiveStatus,
        ],
        [
            'icon' => 'bi-trophy',
            'count' => $rewardCount,
            'label' => 'Rewards',
            'color' => '#00A63E',
            'bg' => '#F0FDF4',
            'amount' => $rewardAmount,
        ],
        [
            'icon' => 'bi-heart',
            'count' => $donationCount,
            'label' => 'Donations',
            'color' => '#E60076',
            'bg' => '#FDF2F8',
            'amount' => $donationAmount,
        ],
        [
            'icon' => 'bi-receipt',
            'count' => array_sum($invoiceStatus),
            'label' => 'Invoices',
            'color' => '#F54900',
            'bg' => '#FFEDD4',
            'statuses' => $invoiceStatus,
            'amount' => $invoiceAmount,
        ],
        [
            'icon' => 'bi-file-earmark-text',
            'count' => array_sum($receiptStatus),
            'label' => 'Receipts',
            'color' => '#9810FA',
            'bg' => '#FAF5FF',
            'statuses' => $receiptStatus,
            'amount' => $receiptAmount,
        ],
        [
            'icon' => 'bi-people',
            'count' => $referralCount,
            'label' => 'Referrals',
            'color' => '#033576',
            'bg' => '#DBEAFE',
        ],
    ];

    

    $recentOrders = [
        [
            'order_number' => 'Order#001',
            'icon' => 'ri-shopping-cart-2-line',
            'customer' => 'Rahul',
            'date' => now()->format('M d, Y'),
            'status' => 'Pending',
            'text_color' => '#b45309',
            'bg_color' => '#fef3c7',
        ],
        [
            'order_number' => 'Order#002',
            'icon' => 'ri-shopping-cart-2-line',
            'customer' => 'Priya',
            'date' => now()->format('M d, Y'),
            'status' => 'Completed',
            'text_color' => '#15803d',
            'bg_color' => '#dcfce7',
        ],
        [
            'order_number' => 'Order#003',
            'icon' => 'ri-shopping-cart-2-line',
            'customer' => 'Amit',
            'date' => now()->format('M d, Y'),
            'status' => 'Processing',
            'text_color' => '#1d4ed8',
            'bg_color' => '#dbeafe',
        ]
    ];

   

    $RevenueReadyKitData = [
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#1F3C88',
            'color' => '#FFFFFF',
            'title' => 'Lorem ipsum dolor sit amet',
            'desc' => 'Consectetur adipiscing elit.',
            'link' => '#',
            'link-icon' => 'ri-arrow-right-up-line'
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#1F3C88',
            'color' => '#FFFFFF',
            'title' => 'Duis aute irure dolor in',
            'desc' => 'Reprehenderit in voluptate velit esse',
            'link' => '#',
            'link-icon' => 'ri-arrow-right-up-line'
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#1F3C88',
            'color' => '#FFFFFF',
            'title' => 'Sunt in culpa qui officia',
            'desc' => 'Deserunt mollit anim id est laborum.',
            'link' => '#',
            'link-icon' => 'ri-arrow-right-up-line'
        ]
    ];

    $servicesData = [
        [
            'icon' => 'ri-code-line',
            'bg' => '#EFF6FF',
            'color' => '#155DFC',
            'title' => 'Web Development',
            'desc' => 'Financial services firm offering wealth management solutions.',
            'link' => '#',
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#FDF2F8',
            'color' => '#E60076',
            'title' => 'Digital Marketing',
            'desc' => 'Financial services firm offering wealth management solutions.',
            'link' => '#',
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#DBEAFE',
            'color' => '#033576',
            'title' => 'Legal Support',
            'desc' => 'Comprehensive insurance solutions for individuals and businesses.',
            'link' => '#',
        ],
        [
            'icon' => 'ri-hand-heart-line',
            'bg' => '#00A63E1A',
            'color' => '#00A63E',
            'title' => 'TGG News',
            'desc' => 'Our core non-profit initiative for sustainable development.',
            'link' => '#',
        ],
    ];

    $freelanceOpportunity = [
        [
            'icon' => 'ri-linkedin-box-line',
            'bg' => '#DBEAFE',
            'color' => '#033576',
            'title' => 'LinkedIn Promotion',
            'desc' => 'Use AI tools to boost reach',
            'link' => '#',
        ],
        [
            'icon' => 'ri-fire-line',
            'bg' => '#FFEDD4',
            'color' => '#F54900',
            'title' => 'IRDA License Holder',
            'desc' => 'Insurance POSP opportunities',
            'link' => '#',
        ],
        [
            'icon' => 'ri-group-line',
            'bg' => '#F3E8FF',
            'color' => '#9810FA',
            'title' => 'Trainer - Biz Dev',
            'desc' => 'Train new associates',
            'link' => '#',
        ],
        [
            'icon' => 'ri-edit-line',
            'bg' => '#DCFCE7',
            'color' => '#00A63E',
            'title' => 'Content Writer',
            'desc' => 'Eco-blogging contributions',
            'link' => '#',
        ]
    ];

    $newsArticles = [
        [
            'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=600&q=80',
            'title' => 'New Solar Initiative Launched for Rural Partners',
            'desc' => 'Empowering rural communities with sustainable energy solutions and new partnership opportunities.',
            'link' => '#'
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80',
            'title' => 'Digital Marketing Strategies for Associate Success in 2026',
            'desc' => 'Stay ahead of the curve with our latest guide on leveraging AI and social platforms for growth.',
            'link' => '#'
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80',
            'title' => 'Building Stronger Teams Through Collaboration and Trust',
            'desc' => 'Discover actionable insights on fostering a culture of teamwork and mutual respect in the workplace.',
            'link' => '#'
        ]
    ];
@endphp

@section('content')
<main>
    <div class="heading-container">
        <h1>Dashboard</h1>
        <p>
            <x-ri-calendar-event-line class="icon" />Today: {{ now()->format('M d, Y') }}
        </p>
    </div>

    <div class="top-section">
        <div class="top-section-container-left">
            <div class="welcome-card">
                <h2>Hello {{ $user->name ?? 'Admin' }}</h2>
                <p><span>Welcome to TGG Meta—</span>
                    It is a dynamic hub where ethical research meets grassroots action. This is where your inquiries, insights, and efforts converge to shape meaningful change through collaborative, well-coordinated projects.
                    As a volunteer or researcher, you are part of a unified ecosystem committed to experiential learning, rigorous documentation, and outcome-oriented exploration. Here, you’ll find streamlined tools to manage assignments, exchange knowledge, and align your work with the broader values of sustainability, compassion, and community empowerment.
                    Let’s co-create solutions that bridge theory and practice, deepen local impact, and contribute to a global narrative of self-reliance and human unity. Welcome aboard and onward with purpose.
                </p>
            </div>
            <div class="active-projects">
                <h2>Platform Overview</h2>
                <ul class="active-projects-list">
                    <li>
                        <h4>Total Engagements</h4>
                        <div><span class="badge"></span> <span class="badge-status-text">{{ array_sum($incentiveStatus) + $rewardCount }} Active</span></div>
                    </li>
                    <li>
                        <h4>Community Interactions</h4>
                        <div><span class="badge"></span> <span class="badge-status-text">{{ $donationCount + $referralCount }}</span></div>
                    </li>
                    <li>
                        <h4>Total Transactions</h4>
                        <div><span class="badge"></span> <span class="badge-status-text">{{ array_sum($paymentStatus) + array_sum($invoiceStatus) }}</span></div>
                    </li>
                    <li>
                        <h4>Acknowledgements</h4>
                        <div><span class="badge"></span> <span class="badge-status-text">{{ array_sum($receiptStatus) }}</span></div>
                    </li>
                </ul>
            </div>
        </div>

        <x-latest-announcements />
    </div>

    <!-- My Project Section -->
    <div class="section-container">
        <div class="heading-container">
            <div>
                <h2>Platform Statistics</h2>
                <p>Track key metrics across the TGG ecosystem</p>
            </div>
            <a href="">View All Reports</a>
        </div>

        <!-- stats -->
        <div class="stats-container">
            @foreach($summaryStats as $stat)
            <div class="stat-box">
                <div class="my-project-stats-icon-container">
                    <div >
                        <i class="bi {{ $stat['icon'] }} stat-icon" style="color: {{ $stat['color'] }}; font-size: 24px;"></i>
                    </div>
                    <h3 class="stat-value">{{ $stat['count'] }}</h3>
                </div>
                <p class="stat-label">{{ $stat['label'] }}</p>
                @if(isset($stat['amount']))
                    <p class="stat-amount" style="font-size: 12px; color: #666; margin-top: 5px;">
                        @if($stat['label'] == 'Rewards')
                            Total Points: {{ number_format($stat['amount'], 0) }}
                        @else
                            Total Amount: ₹{{ number_format($stat['amount'], 2) }}
                        @endif
                    </p>
                @endif
                @if(!empty($stat['statuses']))
                    <div class="status-breakdown mt-2" style="width: 100%;">
                        @foreach($stat['statuses'] as $status => $total)
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span class="text-capitalize">{{ $status }}</span>
                                <span class="fw-semibold">{{ $total }}</span>
                            </div>
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ ($total / max(1, array_sum($stat['statuses']))) * 100 }}%; background-color: {{ $stat['color'] }};">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Venture Bench Support -->
    <x-venture-bench-support />
</main>
@endsection