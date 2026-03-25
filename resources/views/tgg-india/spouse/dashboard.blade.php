@extends('tgg-india.layouts.app', [
'pageCss' => '/TGG-Edge/public/assets/tgg-india/css/dashboard.css'
])

@section('title', 'Dashboard | TGG Meta | TGG India')

@section('content')

@php
$summaryStats = [
[
'icon' => 'ri-group-line',
'count' => '10',
'label' => 'Pending Orders',
'color' => '#155DFC',
'bg' => '#EFF6FF'
],
[
'icon' => 'ri-money-rupee-circle-line',
'count' => '45',
'label' => 'Completed Orders',
'color' => '#9810FA',
'bg' => '#FAF5FF'
],
[
'icon' => 'ri-shake-hands-line',
'count' => '08',
'label' => 'Vendors',
'color' => '#00A63E',
'bg' => '#F0FDF4'
],
[
'icon' => 'ri-shake-hands-line',
'count' => '57',
'label' => 'Total Orders',
'color' => '#00A63E',
'bg' => '#F0FDF4'
],
];

$announcements = [
[
'title' => 'New Partner Program Launch, Checkout for more details',
'date' => \Carbon\Carbon::parse('2026-03-01'),
'views' => 200
],
[
'title' => 'TGG new Service added',
'date' => \Carbon\Carbon::parse('2026-03-01'),
'views' => 200
],
[
'title' => 'Lets save the world with TGG',
'date' => \Carbon\Carbon::parse('2026-03-01'),
'views' => 200
]
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

$happinessProgram = [
    [
        'card-image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=600&q=80',
        'icon'       => 'ri-gift-line',
        'icon-color' => '#E60076',
        'heading'    => 'Art Of Gifting',
        'para'       => 'Discover curated gift collections and meaningful presents to...',
        'link'       => 'https://happiness.org/meditation'
    ],

    // Card 2: Breathwork (The "Sky" or "Sudarshan Kriya" style)
    [
        'card-image' => 'https://images.unsplash.com/photo-1518241353330-0f7941c2d9b5?auto=format&fit=crop&w=600&q=80',
        'icon'       => 'ri-flight-takeoff-line',
        'icon-color' => '#155DFC',
        'heading'    => 'Travel News and Updates',
        'para'       => 'Stay informed with the latest travel deals, destination guides,',
        'link'       => 'https://happiness.org/breathwork'
    ],

    // Card 3: Community & Connection
    [
        'card-image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=600&q=80',
        'icon'       => 'ri-hand-heart-line',
        'icon-color' => '#000000',
        'heading'    => 'Upcoming Projects',
        'para'       => 'Stay informed with the latest travel deals, destination guides',
        'link'       => 'https://happiness.org/community'
    ]
];


$RevenueReadyKitData = [
    [
        'icon'       => 'ri-price-tag-3-line',
        'bg'    => '#1F3C88',
        'color' => '#FFFFFF', 
        'title'      => 'Direct Selling',
        'desc'       => 'Your Journey to Purposeful Prosperity Begins Here...',
        'link'       => '#',
        'link-icon'  => 'ri-arrow-right-up-line'
    ],
    [
        'icon'       => 'ri-bank-line',
        'bg'    => '#1F3C88',
        'color' => '#FFFFFF',
        'title'      => 'Investments',
        'desc'       => 'Your Journey to Purposeful Prosperity Begins Here...',
        'link'       => '#',
        'link-icon'  => 'ri-arrow-right-up-line'
    ],
    [
        'icon'       => 'ri-hand-coin-line',
        'bg'    => '#1F3C88',
        'color' => '#FFFFFF',
        'title'      => 'Insurance',
        'desc'       => 'Your Journey to Purposeful Prosperity Begins Here...',
        'link'       => '#',
        'link-icon'  => 'ri-arrow-right-up-line'
    ],
        [
        'icon'       => 'ri-group-line',
        'bg'    => '#1F3C88',
        'color' => '#FFFFFF',
        'title'      => 'Social ',
        'desc'       => 'Your Journey to Purposeful Prosperity Begins Here...',
        'link'       => '#',
        'link-icon'  => 'ri-arrow-right-up-line'
    ]
];


$servicesData = [
    [
        'icon'      => 'ri-code-line',
        'bg'        => '#EFF6FF',
        'color'     => '#155DFC',
        'title'     => 'Web Development',
        'desc'      => 'Financial services firm offering wealth management solutions.',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-megaphone-line',
        'bg'        => '#FDF2F8',
        'color'     => '#E60076',
        'title'     => 'Digital Marketing',
        'desc'      => 'Financial services firm offering wealth management solutions.',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-shield-line',
        'bg'        => '#DBEAFE',
        'color'     => '#033576',
        'title'     => 'Legal Support',
        'desc'      => 'Comprehensive insurance solutions for individuals and businesses.',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-news-line',
        'bg'        => '#00A63E1A',
        'color'     => '#00A63E',
        'title'     => 'TGG News',
        'desc'      => 'Our core non-profit initiative for sustainable development.',
        'link'      => '#',
    ],
      [
        'icon'      => 'ri-flight-takeoff-line',
        'bg'        => '#DBEAFE',
        'color'     => '#1F3C88',
        'title'     => 'Travel Services',
        'desc'      => 'Comprehensive insurance solutions for individuals and businesses.',
        'link'      => '#',
    ],
 
];


$freelanceOpportunity = [
    [
        'icon'      => 'ri-linkedin-box-line', 
        'bg'        => '#DBEAFE',
        'color'     => '#033576',
        'title'     => 'LinkedIn Promotion',
        'desc'      => 'Use AI tools to boost reach',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-fire-line',
        'bg'        => '#FFEDD4',
        'color'     => '#F54900',
        'title'     => 'IRDA License Holder',
        'desc'      => 'Insurance POSP opportunities',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-group-line',
        'bg'        => '#F3E8FF',
        'color'     => '#9810FA',
        'title'     => 'Trainer - Biz Dev',
        'desc'      => 'Train new associates',
        'link'      => '#',
    ],
    [
        'icon'      => 'ri-edit-line',
        'bg'        => '#DCFCE7',
        'color'     => '#00A63E',
        'title'     => 'Content Writer',
        'desc'      => 'Eco-blogging contributions',
        'link'      => '#',
    ]
];


$newsArticles = [
    [
        'image' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?auto=format&fit=crop&w=600&q=80', // Solar panels
        'title' => 'New Solar Initiative Launched for Rural Partners',
        'desc'  => 'Empowering rural communities with sustainable energy solutions and new partnership opportunities.',
        'link'  => '#'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80', // Digital marketing/analytics
        'title' => 'Digital Marketing Strategies for Associate Success in 2026',
        'desc'  => 'Stay ahead of the curve with our latest guide on leveraging AI and social platforms for growth.',
        'link'  => '#'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80', // Team collaboration
        'title' => 'Building Stronger Teams Through Collaboration and Trust',
        'desc'  => 'Discover actionable insights on fostering a culture of teamwork and mutual respect in the workplace.',
        'link'  => '#'
    ]
];

@endphp

<main>
    <div class="heading-container">
        <h1>Dashboard</h1>
        <p>
            <x-ri-calendar-line class="icon" /> Today: {{ now()->format('M d, Y') }}
        </p>
    </div>

    <div class="top-section">

        <div class="top-section-container-left">
            <div class="welcome-card">
                <h2>Welcome to Ravi</h2>
                <p><span>Welcome to TGG Meta—</span>
                    a space for responsible humans to transform their lives through ethical
                    entrepreneurship and collective action. Anchor your journey in The Power of 5 and The Art of
                    Gifting.</p>
            </div>
            <div class="active-projects">
                <h2>My Projects</h2>

                <ul class="active-projects-list">
                    <li>
                        <h4>Your ongoing Projects</h4>
                        <div><span class="active-badge"></span> <span class="active-badge-status-text">2 Active</span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="top-section-container-right">
            <div class="announcement-header">
                <h2>Latest Announcements</h2>
                <a href="">View All</a>
            </div>

            <ul class="latest-announcements-list">
                {{-- Loop through the announcements array passed from the Controller --}}
                @foreach($announcements as $announcement)
                <li>
                    <h4 style="margin: 0 0 5px 0;">{{ $announcement['title'] }}</h4>

                    <div class="date-views-container">
                        <x-ri-calendar-line class="calender-icon" />
                        <span class="date">{{ $announcement['date']->format('M j, Y') }}</span>
                        <span class="dot"></span>
                        <span class="views">{{ number_format($announcement['views']) }} views</span>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
    </div>


    <!-- My Project Section -->
    <div class="section-container">
        <div class="heading-container">
            <div>
                <h2>My Projects</h2>
                <p>Track your active initiatives and campaigns</p>
            </div>
            <a href="">View All Projects</a>
        </div>


        <!-- stats -->
        <div class="stats-container">
            @foreach($summaryStats as $stat)
            <div class="stat-box">

                {{-- Added the 'stat-icon' class here --}}
                <div class="stats-icon-container" style="background-color: {{ $stat['bg'] }};">
                    <x-dynamic-component :component=" $stat['icon']" class="stat-icon"
                        style="color: {{ $stat['color'] }}; " />
                </div>


                <h3 class="stat-value">{{ $stat['count'] }}</h3>
                <p class="stat-label">{{ $stat['label'] }}</p>

            </div>
            @endforeach
        </div>

        <!-- Order Stats -->
        <div class="orders-grid">
            @foreach($recentOrders as $order)
            <div class="order-box">

                <!-- Top: Icon, Order Number, and Customer -->
                <div class="order-info">

                    <div class="orders-stats-actions-container">
                        <div class="orders-stats-icon-container">
                            <x-dynamic-component :component="$order['icon']" class="order-icon" />
                        </div>

                        <x-ri-more-2-line class="orders-stats-more-icon" />
                    </div>

                    <strong class="order-number">{{ $order['order_number'] }}</strong>

                    <div class="customer-date-order-container">
                        <!-- Customer Name -->
                        <p class="order-customer">
                            <x-ri-user-line class="order-stats-icon" />
                            Customer:<span>{{ $order['customer'] }}</span>
                        </p>
                        <!-- Order Date -->
                        <p class="order-date">
                            <x-ri-calendar-schedule-line class="order-stats-icon" /> Date:<span>{{ $order['date'] }}</span>
                        </p>
                    </div>
                </div>

                <!-- Bottom: Dynamic Status Badge -->
                <div class="order-status-wrapper">
                    <span>Status:</span>
                    <div class="order-status"
                        style="color: {{ $order['text_color'] }}; background-color: {{ $order['bg_color'] }};">
                        {{ $order['status'] }}
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>



<!-- Happiness Program  Section -->
<div class="section-container">
    
       <div class="happiness-program-heading-container">
            <div class="heading-container-text">
                <h2>Happiness Program</h2>
                <p>Enhance your lifestyle with exclusive member benefits and personalized services</p>
            </div>
            

            <div class="heading-container-more">
               <p>2 <span> Services Available</span></p>
               <span><x-ri-arrow-up-s-line class="card-icon"/></span>
            </div>

        </div>

    <!-- 1. Dynamic Cards Loop -->
<div class="happiness-program-card-container">
        <?php foreach ($happinessProgram as $card): ?>
        <div class="happiness-card">
            <div class="card-image-wrapper">
                <img src="<?php echo $card['card-image']; ?>" alt="<?php echo $card['heading']; ?>">
                <div class="floating-icon">
                  

                    <x-dynamic-component :component=" $card['icon']" class="card-icon"
                        style="color: {{ $card['icon-color'] }}; " />

                </div>
            </div>
            <div class="card-content">
                <h3 class="card-heading"><?php echo $card['heading']; ?></h3>
                <p class="card-desc"><?php echo $card['para']; ?></p>
                <a href="<?php echo $card['link']; ?>" class="card-link">Explore &rarr;</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <!-- 2. Static "Coming Soon" Card -->
<div class="future-service-widget">
    <div class="widget-content-stack">
        <div class="widget-icon-box">
            <x-ri-add-line class="icon-svg" />
        </div>
        <h3 class="widget-title">More Services Coming Soon</h3>
        <p class="widget-text">We're constantly adding new benefits to enhance your experience.</p>      
    </div>
</div>

</div>

<!-- Revenue Ready Kit -->
<div class="section-container">
        <div class="heading-container">
            <div>
                <h2>Revenue Ready Kit</h2>
              
            </div>
            <a href="">View All</a>
        </div>

<div class="revenue-ready-kit">
    @foreach($RevenueReadyKitData as $item)
        <div class="revenue-card">
            
            <div class="icon-wrapper main-icon" style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                  <x-dynamic-component :component="  $item['icon']" class="stat-icon"
                        style="color: {{  $item['color'] }}; " />
            </div>
            
            <h3 class="title">{{ $item['title'] }}</h3>
            <p class="desc">{{ $item['desc'] }}</p>
            
      <div class="card-action-row">
   
    <a href="{{ $item['link'] }}" class="get-more-btn">
        <span class="btn-text">Get More</span>
    </a>
    
    
    <div class="icon-wrapper btn-icon" style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
        <x-dynamic-component :component="$item['link-icon']" class="stat-icon" style="color: {{ $item['color'] }};" />
    </div>
</div>
            
        </div>
    @endforeach
</div>
      
</div>


<!-- Venture Bench Support -->
<div class="section-container">
        <div class="heading-container">
            <div>
                <h2>Venture Bench Support</h2>
            </div>
            <a href="">View All</a>
        </div>


<div class="venture-bench-support">
    @foreach($servicesData as $item)
        <div class="venture-bench-card">
            
            <div class="icon-wrapper main-icon" style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                  <x-dynamic-component :component="$item['icon']" class="stat-icon"
                        style="color: {{ $item['color'] }};" />
            </div>
            
       <div class="venture-bench-card-text-info">     <h3 class="title">{{ $item['title'] }}</h3>
            <p class="desc">{{ $item['desc'] }}</p></div>
            
            <div class="card-action-row">
                <a href="{{ $item['link'] }}" class="see-more-btn">
                    <span class="btn-text">See More</span>
                    
                </a>
            </div>
            
        </div>
    @endforeach
</div>
        
</div>



<!-- Freelancing Opportunities and Upcoming Projects Section -->


<div class="bottom-section">


<!-- Freelancing Opportunities  -->
<div class="section-container">
     <div class="heading-container">
            <div>
                <h2>Freelancing Opportunities</h2>
                <p>Earn extra by leveraging your skills</p>
            </div>
        </div>


 <div class="freelance-opportunity-list-container">
<div class="freelance-opportunity-list">
    @foreach($freelanceOpportunity as $item)
        <div class="freelance-list-item">
            
            <!-- Badge Icon -->
            <div class="badge-icon" style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                <x-dynamic-component :component="$item['icon']" class="list-icon-svg" 
                    style="color: {{ $item['color'] }};" />
            </div>
            
            <!-- Text Content -->
            <div class="list-content">
                <h4 class="list-title">{{ $item['title'] }}</h4>
                <p class="list-desc">{{ $item['desc'] }}</p>
            </div>
            
             <x-ri-arrow-right-s-line class="icon" />
        </div>
    @endforeach
</div>
<a class="view-all-opportunities-btn" href="">View All Opportunities</a>
 </div>

 
</div>

<!-- Upcoming Projects Sections  -->
<div class="section-container">
         <div class="heading-container">
            <div>
                <h2>Upcoming Projects</h2>
                <p>Professional happiness projects</p>
            </div>
         <a href="">Explore All</a>
        </div>

  <div class="upcoming-projects-cards">
    @foreach($servicesData as $item)
        <div class="upcoming-projects-card">
            
            <div class="icon-wrapper main-icon" style="background-color: {{ $item['bg'] }}; color: {{ $item['color'] }};">
                  <x-dynamic-component :component="$item['icon']" class="stat-icon"
                        style="color: {{ $item['color'] }};" />
            </div>
            <h3 class="title">{{ $item['title'] }}</h3>
     
            <div class="card-action-row">
                <a href="{{ $item['link'] }}" class="see-more">
                    See More
                   <span class="see-more-icon-wrapper"> <x-ri-arrow-right-up-long-fill class="see-more-icon" /></span>
                </a>

            </div>
            
        </div>
    @endforeach
     </div>
</div>

</div>

<!--  Latest Blogs & News Section -->
<div class="section-container">
    <div class="heading-container">
            <div>
                <h2>Latest Blogs & News</h2>
           
            </div>
         <a href="">View All</a>
        </div>

<div class="news-list-container">
    @foreach($newsArticles as $article)
        <a href="{{ $article['link'] }}" class="news-list-item">
            
            <!-- Thumbnail Image -->
            <div class="news-image-wrapper">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="news-thumbnail">
            </div>
            
            <!-- Text Content (Title Only) -->
            <div class="news-content">
                <h4 class="news-title">{{ $article['title'] }}</h4>
            </div>
            
            <!-- Right Arrow -->
            <x-ri-arrow-right-s-line class="news-arrow-icon" />
            
        </a>
    @endforeach
</div>
</div>

</main>

@endsection