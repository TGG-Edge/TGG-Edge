@extends('tgg-india.layouts.app')

@section('title', 'Venture Bench Support | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    {{-- Page Header (Like Feature Limits) --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="mb-3 trainer-heading">Venture Bench Support</h4>
    </div>

    {{-- @php
        $services = [
            [
                'title' => 'Website Development',
                'image' => 'images/Website_Development.png',
                'short_description' => 'Static & Dynamic Websites<br>Responsive & SEO Friendly<br>Secure & scalable build',
                'description' => 'Our website development service focuses on building fast, secure, and scalable digital platforms tailored to your needs. We design both static and dynamic websites with strong emphasis on UI/UX, performance, and SEO best practices.',
                'member_price' => '₹5,000 (5 Pages)',
                'non_member_price' => '₹7,000',
            ],
            [
                'title' => 'Digital Marketing',
                'image' => 'images/Digital_Marketing.jpg',
                'short_description' => 'SEO & Social Media Campaigns<br>Brand Promotion<br>Analytics & Reporting',
                'description' => 'We deliver data-driven digital marketing strategies including SEO, social media marketing, content creation, and performance tracking to help you grow sustainably.',
                'member_price' => '₹8,000 / month',
                'non_member_price' => '₹10,000 / month',
            ],
            [
                'title' => 'TGG News',
                'image' => 'images/News.jpg',
                'short_description' => 'AI Podcast & Media Promotion<br>Monthly Exposure<br>Storytelling Focus',
                'description' => 'TGG News offers AI-powered podcast and media exposure designed to amplify meaningful initiatives through ethical storytelling and digital reach.',
                'member_price' => '₹4,000',
                'non_member_price' => 'Members Only',
            ],
            [
                'title' => 'Business Development Support',
                'image' => 'images/Business_Development_Support.jpg',
                'short_description' => 'Growth Strategy<br>Partnership Planning<br>Execution Support',
                'description' => 'We support startups and organizations with structured business growth planning, partnerships, and execution frameworks.',
                'member_price' => '₹8,000 / month',
                'non_member_price' => 'Members Only',
            ],
            [
                'title' => 'Incorporation Support',
                'image' => 'images/Incorporation_Support.png',
                'short_description' => 'Company Registration<br>Compliance Assistance<br>End-to-End Support',
                'description' => 'Our incorporation support simplifies company registration, documentation, and compliance with complete guidance.',
                'member_price' => 'Custom Pricing',
                'non_member_price' => 'Custom Pricing',
            ],
            [
                'title' => 'Accounting & Auditing Support',
                'image' => 'images/Accounting_Auditing_Support.jpg',
                'short_description' => 'Bookkeeping<br>Audits & Compliance<br>Financial Reporting',
                'description' => 'We provide accurate accounting, audit preparation, and financial compliance services to ensure transparency.',
                'member_price' => 'Custom Pricing',
                'non_member_price' => 'Custom Pricing',
            ],
            [
                'title' => 'Legal Support',
                'image' => 'images/Legal_Support.jpg',
                'short_description' => 'Legal Documentation<br>Contracts<br>Compliance Guidance',
                'description' => 'Our legal support covers contracts, documentation, policy drafting, and regulatory guidance.',
                'member_price' => 'Case Based',
                'non_member_price' => 'Case Based',
            ],
            [
                'title' => 'AI Powered Problem Solving',
                'image' => 'images/AI_Powered_Problem_Solving.jpg',
                'short_description' => 'AI Decision Support<br>Knowledge Assistance<br>Smart Tools',
                'description' => 'AI-powered problem solving provides intelligent support for research, planning, and decision-making.',
                'member_price' => 'Usage Based',
                'non_member_price' => 'TGG Family Only',
            ],
            [
                'title' => 'App Development',
                'image' => 'images/App_Development.jpg',
                'short_description' => 'Android & iOS Apps<br>UI/UX Design<br>Performance Optimized',
                'description' => 'We build scalable, high-performance mobile apps with modern UI/UX and best development practices.',
                'member_price' => '₹10,000',
                'non_member_price' => '₹15,000',
            ],
            [
                'title' => 'Custom Software',
                'image' => 'images/Custom_Software.jpg',
                'short_description' => 'Tailor-Made Solutions<br>Process Automation<br>Secure Systems',
                'description' => 'Custom software solutions designed to automate workflows and scale with your organization.',
                'member_price' => '₹10,000',
                'non_member_price' => '₹15,000',
            ],
        ];
    @endphp --}}

    @php
    $services = [
        [
            'title' => 'Website Development',
            'image' => 'images/Website_Development.png',
            'short_description' => 'Design and development of static and dynamic websites<br>Responsive, SEO-optimized, and performance-driven layouts<br>Secure, scalable architecture built for long-term growth',
            'description' => '
                Our website development service focuses on delivering high-quality, scalable, and secure digital solutions tailored to your business objectives.
                <ul>
                    <li>Design and development of static and dynamic websites using modern frameworks</li>
                    <li>Responsive layouts optimized for mobile, tablet, and desktop devices</li>
                    <li>SEO-friendly structure to improve search engine visibility</li>
                    <li>Performance optimization for faster load times and better user experience</li>
                    <li>Secure coding practices to protect data and prevent vulnerabilities</li>
                    <li>Scalable architecture that supports future growth and feature expansion</li>
                </ul>
                This service is ideal for startups, organizations, and individuals looking to establish a strong and professional digital presence.
            ',
            'member_price' => '₹5,000 (5 Pages)',
            'non_member_price' => '₹7,000',
        ],
        [
            'title' => 'Digital Marketing',
            'image' => 'images/Digital_Marketing.jpg',
            'short_description' => 'Strategic SEO and social media marketing campaigns<br>Brand visibility, audience engagement, and lead generation<br>Data-driven analytics and performance optimization',
            'description' => '
                Our digital marketing services are designed to drive measurable growth through targeted and data-driven strategies.
                <ul>
                    <li>Search Engine Optimization (SEO) to improve organic rankings</li>
                    <li>Social media marketing to increase brand awareness and engagement</li>
                    <li>Content creation and promotion aligned with brand messaging</li>
                    <li>Campaign planning focused on lead generation and conversions</li>
                    <li>Performance tracking through analytics and reporting tools</li>
                    <li>Continuous optimization based on audience behavior and insights</li>
                </ul>
                We focus on sustainable growth rather than short-term spikes, ensuring long-term digital success.
            ',
            'member_price' => '₹8,000 / month',
            'non_member_price' => '₹10,000 / month',
        ],
        [
            'title' => 'TGG News',
            'image' => 'images/News.jpg',
            'short_description' => 'AI-powered podcast production and digital media promotion<br>Monthly visibility across multiple content channels<br>Purpose-driven and ethical storytelling initiatives',
            'description' => '
                TGG News is a unique media platform designed to amplify meaningful initiatives through AI-powered content.
                <ul>
                    <li>AI-generated podcast creation and media storytelling</li>
                    <li>Monthly digital exposure across selected platforms</li>
                    <li>Video and audio content promotion</li>
                    <li>Ethical and purpose-driven storytelling approach</li>
                    <li>Curated visibility within the TGG ecosystem</li>
                </ul>
                This service is ideal for members seeking impactful media exposure with credibility and purpose.
            ',
            'member_price' => '₹4,000',
            'non_member_price' => 'Members Only',
        ],
        [
            'title' => 'Business Development Support',
            'image' => 'images/Business_Development_Support.jpg',
            'short_description' => 'Structured business growth and market expansion strategies<br>Partnership identification and opportunity development<br>Execution support and performance monitoring',
            'description' => '
                Our business development support service helps organizations grow through structured planning and execution.
                <ul>
                    <li>Market analysis and opportunity identification</li>
                    <li>Growth strategy planning aligned with business goals</li>
                    <li>Partnership development and collaboration support</li>
                    <li>Operational guidance for scaling efficiently</li>
                    <li>Execution frameworks and progress monitoring</li>
                </ul>
                This service is best suited for startups and growing organizations seeking sustainable expansion.
            ',
            'member_price' => '₹8,000 / month',
            'non_member_price' => 'Members Only',
        ],
        [
            'title' => 'Incorporation Support',
            'image' => 'images/Incorporation_Support.png',
            'short_description' => 'End-to-end company registration and incorporation services<br>Regulatory compliance and statutory documentation support<br>Professional guidance throughout the incorporation lifecycle',
            'description' => '
                Our incorporation support service simplifies the complete business setup process.
                <ul>
                    <li>Guidance on selecting the right business structure</li>
                    <li>Preparation and filing of incorporation documents</li>
                    <li>Regulatory and statutory compliance assistance</li>
                    <li>Coordination for registrations and approvals</li>
                    <li>Post-incorporation advisory and support</li>
                </ul>
                We ensure a smooth, compliant, and hassle-free incorporation experience.
            ',
            'member_price' => 'Custom Pricing',
            'non_member_price' => 'Custom Pricing',
        ],
        [
            'title' => 'Accounting & Auditing Support',
            'image' => 'images/Accounting_Auditing_Support.jpg',
            'short_description' => 'Professional accounting and bookkeeping services<br>Audit preparation and regulatory compliance management<br>Accurate financial reporting and review',
            'description' => '
                Our accounting and auditing services provide accurate financial oversight and compliance support.
                <ul>
                    <li>Bookkeeping and financial record maintenance</li>
                    <li>Preparation for audits and regulatory filings</li>
                    <li>Periodic financial reporting and reviews</li>
                    <li>Compliance with accounting standards</li>
                    <li>Improved financial transparency and control</li>
                </ul>
                This service reduces financial risk while improving clarity and accountability.
            ',
            'member_price' => 'Custom Pricing',
            'non_member_price' => 'Custom Pricing',
        ],
        [
            'title' => 'Legal Support',
            'image' => 'images/Legal_Support.jpg',
            'short_description' => 'Comprehensive legal documentation and contract drafting<br>Policy formulation and compliance advisory<br>Regulatory and legal risk guidance',
            'description' => '
                Our legal support services assist organizations with clear and compliant legal documentation.
                <ul>
                    <li>Drafting and review of contracts and agreements</li>
                    <li>Legal documentation and policy preparation</li>
                    <li>Regulatory and compliance guidance</li>
                    <li>Risk identification and mitigation support</li>
                    <li>Structured legal advisory for business operations</li>
                </ul>
                We focus on clarity, compliance, and risk reduction.
            ',
            'member_price' => 'Case Based',
            'non_member_price' => 'Case Based',
        ],
        [
            'title' => 'AI Powered Problem Solving',
            'image' => 'images/AI_Powered_Problem_Solving.jpg',
            'short_description' => 'AI-driven analytical and decision support systems<br>Knowledge-based assistance and research automation<br>Intelligent tools for strategic planning',
            'description' => '
                AI Powered Problem Solving provides intelligent support using modern AI tools.
                <ul>
                    <li>AI-driven insights for faster decision-making</li>
                    <li>Research assistance and information summarization</li>
                    <li>Problem analysis and solution recommendations</li>
                    <li>Support for planning, strategy, and execution</li>
                    <li>User-friendly tools without technical complexity</li>
                </ul>
                This service enhances productivity and improves decision quality across domains.
            ',
            'member_price' => 'Usage Based',
            'non_member_price' => 'TGG Family Only',
        ],
        [
            'title' => 'App Development',
            'image' => 'images/App_Development.jpg',
            'short_description' => 'Custom Android and iOS application development<br>User-centric interface and experience design<br>Scalable, secure, and high-performance mobile solutions',
            'description' => '
                Our app development service delivers end-to-end mobile solutions.
                <ul>
                    <li>Android and iOS app development</li>
                    <li>UI/UX design focused on usability</li>
                    <li>Performance optimization and testing</li>
                    <li>Secure data handling and integrations</li>
                    <li>Scalable architecture for future updates</li>
                </ul>
                We ensure reliable, user-friendly, and future-ready mobile applications.
            ',
            'member_price' => '₹10,000',
            'non_member_price' => '₹15,000',
        ],
        [
            'title' => 'Custom Software',
            'image' => 'images/Custom_Software.jpg',
            'short_description' => 'Bespoke software solutions aligned with business needs<br>Process automation and system integration<br>Secure, scalable, and future-ready architecture',
            'description' => '
                Our custom software development service delivers tailored solutions for unique business requirements.
                <ul>
                    <li>Requirement analysis and custom solution design</li>
                    <li>Automation of operational workflows</li>
                    <li>Integration with existing systems</li>
                    <li>Secure and scalable application architecture</li>
                    <li>Long-term maintainability and performance</li>
                </ul>
                This service is ideal for organizations seeking efficiency through technology.
            ',
            'member_price' => '₹10,000',
            'non_member_price' => '₹15,000',
        ],
    ];
    @endphp



    {{-- Services Grid --}}
    <div class="row g-4">
        @foreach($services as $index => $service)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex flex-column text-center">

                        <img src="{{ asset($service['image']) }}"
                             class="img-fluid mb-3 rounded-3"
                             style="max-height:160px; object-fit:cover;"
                             alt="{{ $service['title'] }}">

                        <h5 class="fw-semibold mb-2">
                            {{ $service['title'] }}
                        </h5>

                        <p class="text-muted small mb-3">
                            {!! $service['short_description'] !!}
                        </p>

                        <div class="mt-auto">
                            <button class="btn btn-primary assignment-button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#serviceModal{{ $index }}">
                               See More
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="serviceModal{{ $index }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4 border-0">
                        <div class="modal-header">
                            <h5 class="modal-title fw-semibold">{{ $service['title'] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body text-muted">
                            {!! $service['description'] !!}
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <span class="fw-semibold text-success">
                                Member: {{ $service['member_price'] }}
                            </span>
                            <span class="fw-semibold text-danger">
                                Non-Member: {{ $service['non_member_price'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
