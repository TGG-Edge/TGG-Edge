@extends('tgg-india.layouts.app')

@section('title', 'Assignment Dashboard | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <h4 class="fw-semibold mb-4 mt-2">Venture Bench Services</h4>

    @php
        $services = [
            [
                'title' => 'Website Development',
                'image' => 'images/Website_Development.png',
                'content' => 'Static & Dynamic Websites<br>Responsive & SEO Friendly<br>Optimized for speed, security, and long-term digital growth, Static ₹5,000 (5 pages)<br>Non-Member ₹7,000<br>Dynamic: Ask for quote<br>',
                'details' => 'Our website development service focuses on building fast, secure, and scalable digital platforms tailored to your needs. We design both static and dynamic websites with a strong emphasis on user experience, responsiveness, and search engine optimization. From simple informational websites to complex web applications, our solutions are structured to support long-term growth. We follow modern development practices, clean code standards, and security best practices to ensure reliability. This service is ideal for startups, organizations, and individuals looking to establish or enhance their digital presence with a professional and future-ready website.',
            ],
            [
                'title' => 'Digital Marketing',
                'image' => 'images/Digital_Marketing.jpg',
                'content' => 'SEO & Social Media Campaigns<br>Content & Brand Promotion<br>Analytics & Performance Tracking<br>Focused on reach, engagement, and conversions<br>Member ₹8,000 / month<br>Non-Member ₹10,000 / month',
                'details' => 'Our digital marketing services are designed to help you reach the right audience and convert engagement into measurable results. We create data-driven strategies covering SEO, social media campaigns, content marketing, and performance tracking. Each campaign is optimized based on analytics, audience behavior, and platform trends to maximize visibility and ROI. We focus on sustainable growth rather than short-term spikes. This service is suitable for brands aiming to strengthen their online presence, improve engagement, and generate consistent leads across digital platforms.',
            ],
            [
                'title' => 'TGG News',
                'image' => 'images/News.jpg',
                'content' => 'AI Podcast & Media Promotion<br>Video & Audio Storytelling<br>Monthly Digital Exposure<br>Designed to amplify meaningful initiatives<br>Members Only ₹4,000',
                'details' => 'TGG News provides a unique media promotion platform powered by AI-driven podcasts, video content, and digital storytelling. This service helps individuals and initiatives gain visibility within the TGG ecosystem and beyond. Participants receive curated exposure through monthly media features, interviews, and content distribution across selected channels. The focus is on meaningful storytelling and ethical promotion. This service is ideal for members who want to amplify their voice, projects, or impact-driven initiatives through modern digital media.',
            ],
            [
                'title' => 'Business Development Support',
                'image' => 'images/Business_Development_Support.jpg',
                'content' => 'Growth & Partnership Strategy<br>Market & Operational Guidance<br>Execution & Planning Support<br>Structured approach to sustainable growth<br>Members Only<br>₹8,000 per month',
                'details' => 'Our business development support service assists organizations in identifying growth opportunities, forming strategic partnerships, and improving operational efficiency. We work closely with you to understand your objectives, market positioning, and challenges. Based on this, we provide guidance on strategy planning, execution frameworks, and performance improvement. This service is well-suited for early-stage startups, growing enterprises, and community-driven ventures seeking structured growth support.',
            ],
            [
                'title' => 'Incorporation Support',
                'image' => 'images/Incorporation_Support.png',
                'content' => 'Company Registration & Compliance<br>Documentation & Legal Filings<br>End-to-End Incorporation Support<br>Simplifying the business setup process<br>Members Only<br>Pricing Varies',
                'details' => 'Incorporation support covers the complete process of company registration, documentation, and statutory compliance. We simplify complex legal and procedural steps to help you get started smoothly. Our team assists with choosing the right structure, preparing required documents, and ensuring compliance with regulatory requirements. Ongoing guidance is also provided for post-incorporation needs. This service is intended for founders and entrepreneurs looking for a hassle-free and compliant incorporation experience. ',
            ],
            [
                'title' => 'Accounting & Auditing Support',
                'image' => 'images/Accounting_Auditing_Support.jpg',
                'content' => 'Bookkeeping & Financial Records<br>Audit Preparation & Compliance<br>Periodic Financial Reporting<br>Ensuring accuracy and transparency<br>Members Only<br>Custom Pricing',
                'details' => 'Our accounting and auditing support service ensures accurate financial management and regulatory compliance. We provide bookkeeping, financial reporting, audit preparation, and compliance assistance. The service is designed to give you clear visibility into your financial health while reducing operational risk. We follow standardized accounting practices and ensure timely reporting. This offering is ideal for organizations that want reliable financial oversight without maintaining a large in-house accounting team. ',
            ],
            [
                'title' => 'Legal Support',
                'image' => 'images/Legal_Support.jpg',
                'content' => 'Contracts & Legal Documentation<br>Policy Drafting & Review<br>Regulatory & Compliance Guidance<br>Helping you manage legal requirements<br>Members Only<br>Case-Based Pricing',
                'details' => 'Legal support services include assistance with documentation, contracts, agreements, and policy drafting. We help ensure that your legal framework aligns with applicable regulations and best practices. Our approach emphasizes clarity, risk reduction, and compliance. Whether you need contract review or policy guidance, we provide structured and understandable legal assistance. This service is suitable for organizations, startups, and individuals who require dependable legal support for operational and strategic needs. ',
            ],
            [
                'title' => 'AI Powered Problem Solving',
                'image' => 'images/AI_Powered_Problem_Solving.jpg',
                'content' => 'AI-Based Instant Solutions<br>Decision & Research Support<br>Knowledge Assistance Tools<br>Smart assistance for better outcomes<br>TGG Family Only<br>Usage-Based Access',
                'details' => 'AI-powered problem solving leverages intelligent tools to provide quick insights, decision support, and knowledge assistance. This service helps users address challenges efficiently using AI-based analysis. It is designed to support research, planning, and everyday problem-solving through guided prompts and contextual intelligence. The focus is on practical outcomes rather than complex technical setups. This service is ideal for members who want faster, smarter assistance across multiple domains using modern AI capabilities. ',
            ],
            [
                'title' => 'App Development',
                'image' => 'images/App_Development.jpg',
                'content' => 'Android & iOS Applications<br>User-Friendly UI/UX Design<br>Performance-Optimized Builds<br>Designed for scalability and reliability<br>Member ₹10,000<br>Non-Member ₹15,000',
                'details' => 'Our app development service delivers high-quality mobile applications for Android and iOS platforms. We focus on performance, usability, and scalability to ensure a smooth user experience. From concept to deployment, we handle UI/UX design, development, testing, and optimization. Applications are built using modern frameworks and best practices. This service is suitable for businesses and individuals looking to launch reliable mobile applications tailored to their specific requirements.',
            ],
            [
                'title' => 'Custom Software',
                'image' => 'images/Custom_Software.jpg',
                'content' => 'Tailor-Made Software Solutions<br>Process Automation Systems<br>Secure & Scalable Architecture<br>Built to match your operational workflows<br>Member ₹10,000<br>Non-Member ₹15,000',
                'details' => 'Custom software development provides tailored solutions designed specifically for your operational needs. We build systems that automate processes, improve efficiency, and scale with your organization. Each solution is developed after understanding your workflows, challenges, and long-term goals. Security, performance, and maintainability are core priorities.This service is ideal for organizations that require specialized software rather than off-the-shelf solutions. ',
            ],
        ];
    @endphp

    <div class="row g-4">
        @foreach($services as $index => $service)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="service-grid-card h-100">
                    <div class="service-grid-body d-flex flex-column text-center">

                        {{-- Image --}}
                        <div class="service-img-wrapper mb-3">
                            <img src="{{ asset($service['image']) }}"
                                 alt="{{ $service['title'] }}"
                                 class="service-grid-img">
                        </div>

                        {{-- Title --}}
                        <h5 class="fw-semibold mb-2">
                            {{ $service['title'] }}
                        </h5>

                        {{-- ✅ ACTUAL CONTENT FROM ARRAY --}}
                        <div class="service-content mb-3">
                            {!! $service['content'] !!}
                        </div>

                        {{-- Button aligned bottom --}}
                        <div class="mt-auto">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#serviceModal{{ $index }}">
                                Learn More
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- MODAL --}}
            <div class="modal fade" id="serviceModal{{ $index }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4 border-0">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $service['title'] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-muted">
                            {{ $service['details'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
