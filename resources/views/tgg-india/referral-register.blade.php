@extends('tgg-india.layouts.app')

@section('title', 'User Registration | TGG Meta | TGG India')
@php $is_sidebar = false; @endphp

@section('content')
<div class="container py-4">
    
    {{-- Section 1: Heading + Intro --}}
    <h3 class="mb-4 text-center">Welcome to TGG's  Eco-Entrepreneurship Program</h3>
    
    {{-- Image + Content --}}
    <div class="row g-4 mb-5">
        {{-- Left Image --}}
        <div class="col-md-4">
            <div class="card shadow rounded-4 overflow-hidden">
                <img src="{{ asset('assets/tgg-india/images/referral-registration-image.png') }}"
                alt="TGG Registration" class="img-fluid w-100">
            </div>
        </div>
        
        {{-- Right Content --}}
        <div class="col-md-8 d-flex align-items-center">
            <p class="text-muted small mb-0">
                TGG’s Eco-Entrepreneurship Program is a regenerative pathway for individuals seeking to build purpose-driven enterprises that honor nature, uplift communities, and foster ethical self-reliance. In a world shaped by rapid technological change and rising unemployment, true success demands more than technical skill—it calls for purpose, connection, and a mindset rooted in regeneration. This program offers immersive training, personalized mentorship, and access to the TGG-Meta platform, enabling participants to launch sustainable ventures across diverse domains such as conscious products, ethical investment, responsible travel, and social impact services. Grounded in the values of TGG’s Responsible Human Mission, it transforms livelihood into legacy—empowering changemakers to co-create a future where profit and purpose walk hand in hand. Whether you are a youth seeking direction, a professional in transition, or a visionary ready to serve, this program invites you to align your enterprise with compassion, sustainability, and the joy of meaningful contribution.

            </p>
        </div>
    </div>
     

    {{-- Section 2: Registration Form with Image on Right --}}
    <div class="row g-4 mb-5 ">
        @include('tgg-india.layouts.includes.message')
        {{-- Left: Form --}}
        <div class="col-md-8">
            <div class="card shadow rounded-4 p-4 mb-4">
                <h4 class="text-center mb-4">Registration</h4>
                 <p class="text-muted small mb-4">
                    To enroll in TGG's Eco-Entrepreneurship Program, participants are required to complete the registration form and submit a one-time program access fee of ₹10,000. This fee covers 14 hours of training, mentorship, Co-Creating access, TGG-Meta "POWER OF 5" platform for self-employment and an "Art of Gifting" pack. Upon successful payment, participants will receive a confirmation email with onboarding details and access credentials wtihin 3 working days.  
                    </p>
                <form method="POST" action="{{ route('tgg-india.register.referral.store', [$user_type, 'referral_code' => $referrer_code]) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Age (above 20) *</label>
                            <input type="number" class="form-control" name="age" min="21" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nationality *</label>
                            <input type="text" class="form-control" name="nationality" value="INDIA" readonly required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Area of Expertise / Interest *</label>
                            <input type="text" class="form-control" name="expertise" required>
                        </div>
                       
                        <div class="col-md-4">
                            <label class="form-label">Address *</label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pincode *</label>
                              <input type="text" class="form-control" name="pin_code" placeholder="Please enter Pin Code " required>
                        </div>
                         <div class="col-md-6">
                            <label class="form-label">Responsible Human Mission Number *</label>
                            <input type="text" class="form-control" name="rhm_number" placeholder="Please enter RHM number" required>

                        </div>
                        <div class="col-md-6">`
                            <label class="form-label">LinkedIn / Social Profile (Optional)</label>
                            <input type="url" class="form-control" name="social_profile">
                        </div>
                        <div class="col-md-12">
                        <a href="https://razorpay.me/@tggindia"  target="_blank"  class="btn w-100 mt-3 text-white" style="background-color: #033576; border-color: #033576;">Payment</a>
                        <p class="alert alert-info mt-2" style="font-size: 12px; line-height: 1.6;">
                              Please complete your registration payment first. Once the payment is successful, you will receive your transaction ID. Kindly input the same below.
                        </p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Transaction Id *</label>
                            <input type="text" class="form-control" name="transaction_id" required>
                           

                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert" style="font-size: 12px; line-height: 1.6;">
                                <strong>Consent & Declaration:</strong><br>
                                I am fully aligned with the journey of TGG Family and I consider humanity above all ideologies 
                                and belief systems that exist in this world. I have not been convicted by any court for any 
                                criminal offence & sentenced to imprisonment. I am committed to transform myself by being 
                                responsible and accountable to all my actions. I have understood the Values and have also 
                                read and accepted the CODE OF PRACTICE & ETHOS OF TGG. I am a community being and understand 
                                the significance of Collective Actions. I hereby endorse my participation with TGG consciously 
                                to be a part of this Global Family.
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="consent_agree" required>
                                <label class="form-check-label">I Agree</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-3 text-white">Register</button>
                </form>
            </div>
        </div>

        {{-- Right: Image --}}
        <div class="col-md-4">
            <div class="card shadow rounded-4 overflow-hidden">
                <img src="{{ asset('assets/tgg-india/images/tgg-india-registration-new.png') }}" style="height: 500px" class="img-fluid w-100" alt="Registration Image">
            </div>
        </div>
    </div>

    {{-- Section 3: Donation with Image Left --}}
    <div class="row g-4 ">
        {{-- Left: Image --}}
        <div class="col-md-4">
            <div class="card shadow rounded-4 overflow-hidden">
                <img style="height: 500px" src="{{ asset('assets/tgg-india/images/donation-left.png') }}" class="img-fluid w-100" alt="Donation Image">
            </div>
        </div>

        {{-- Right: Donation Form --}}
        <div class="col-md-8">
            <div class="card shadow rounded-4 p-4 mb-4">
                <h5 class="mb-3"> Make a Donation <small class="text-muted">(Optional)</small></h5>
                <p class="text-muted small">
                    TGG AID is a social initiative by the TGG Family, managed through the TGG Foundation Charitable Trust with the active participation of its advisors. Its primary focus is the education and well-being of children, with ongoing support for Anganwadi projects that nurture early childhood development. The second priority is empowering women in rural areas through livelihood opportunities that foster dignity and self-reliance. The third focus is compassionate care for the elderly, ensuring they live with respect, comfort, and community support.
                </p>

                <form action="{{ route('tgg-india.donate.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="returnUrl" value="{{ request()->fullUrl() }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Name in full (as per PAN Card)</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Address with PIN Code</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PAN Card Number</label>
                            <input type="text" name="pan_card_number" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Donation Amount (₹)</label>
                            <input type="number" name="amount" min="100" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Purpose of Donation</label>
                            <input type="text" class="form-control" value="TGG AID- A Social Initiative by TGG Family" readonly>
                        </div>
                        <div class="col-md-12">
                         <a href="https://razorpay.me/@tggfoundationcharitabletr3236"  target="_blank"  class="btn w-100 mt-3 text-white" style="background-color: #033576; border-color: #033576;">Donate</a>
                         <p class="alert alert-info mt-2" style="font-size: 12px; line-height: 1.6;">
                              Please complete your registration payment first. Once the payment is successful, you will receive your transaction ID. Kindly input the same below.
                        </p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Transaction Id *</label>
                            <input type="text" class="form-control" name="transaction_id" required>
                           
                        </div>
                    </div>
                    <p class="text-muted small mt-2">
                      Note: An 80G receipt will be provided for your donation TGG Foundation Charitable Trust, enabling you to claim income tax exemption as per applicable regulations.
                    </p>
                    <button type="submit" class="btn btn-success w-100 mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
