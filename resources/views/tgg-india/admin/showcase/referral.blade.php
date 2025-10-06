@extends('tgg-india.layouts.app')

@section('title', ucfirst($source_type) . ' Content | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 showcase-heading">{{ ucfirst($source_type) }} Content Update</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 mb-4">
        <form action="{{ route('tgg-india.admin.showcases.content.update', $source_type) }}" 
              method="POST">
            @csrf

            <input type="hidden" name="source_type" value="{{ $source_type }}">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" 
                       value="{{ old('title', $content->title ?? '') }}" required>
            </div>

            {{-- <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" id="slug" name="slug" class="form-control" 
                       value="{{ old('slug', $content->slug ?? '') }}" required>
            </div> --}}

             @php
            $defaultContent = <<<HTML
            <div class="container referral-page">
                <div class="card shadow-lg p-4">
                    <!-- Hero Section -->
                    <h1 class="text-center text-primary">TGG India Referral Program</h1>
                    <p class="text-center" style="font-size:14px; max-width: 700px; margin: auto;">
                    As a proud member and  <strong> co-creator </strong> of TGG India, you are part of a transformative movement toward self-reliance and ethical entrepreneurship. Now, you can extend this opportunity to others across India.
                    </p>
                    <hr>

                    <!-- About Section -->
                    <h2>About TGG India</h2>
                    <p>
                    TGG India is a trusted platform rooted in innovation, collaboration, and shared success. Our vision is to empower individuals across India with meaningful opportunities to earn, learn, and grow, not in isolation, but through collective action.

            By joining the TGG India Referral Program, you become a catalyst for change. You not only receive rewards but also expand your entrepreneurial reach by building a network of achievers committed to ethical growth and regenerative impact.

            Together, we are shaping a future where self-reliance meets solidarity, and where every referral strengthens the movement toward a more dignified and transparent economy.
                    </p>

                    <!-- What is Referral Program -->
                    <h2>What is the TGG India Referral Program?</h2>
                    <p>
                    The TGG India Referral Program is a gateway to collective prosperity. It empowers members to expand their network by inviting others to join a sustainable income generation initiative rooted in transparency and ethicality.
                    </p>
                    <p>
                        For every successful referral — when your invitee registers and their account is verified — you receive a ₹500 reward directly in your account.
            There’s no limit to how much you can earn. Your dedication, outreach, and belief in shared success determine your growth.
            This is more than a reward system — it’s a movement toward
                        <strong>self-reliance</strong>. through collective action, where every connection strengthens the foundation of a regenerative economy.
                    </p>

                    <!-- Why Join -->
                    <h2>Why Join the TGG India Referral Program?</h2>
                    <p>
                    Charity Begins at Home
                    </p>

                    <p>
                    As part of our commitment to ethical growth and regenerative development, we invite you to contribute 10% of your monthly earnings toward the creation and nurturing of the RHM Center in Wayanad — a sanctuary for responsible human missions and experiential learning.
                    </p>
                    <p>
                    This contribution will be automatically deducted before your monthly payment is disbursed, ensuring seamless support for a cause that uplifts us all.
                    </p>
                    <p>
                    Your referrals build your network.
                    </p>
                    <p>
                    Your contribution builds a future.
                    </p>

                    <ul>
                        <li>✅ Earn with purpose — receive ₹500 for every verified referral</li>
                        <li>✅ Grow your network — connect with<strong>like-minded</strong> individuals in your contact</li>
                        <li>✅ Empower others — share access to sustainable income generation.</li>
                        <li>✅ Lead the change — become a beacon of ethical action in your community.</li>
                    </ul>

                    <p>
                    This is your chance to build, belong, and become — not just for yourself, but for a better India
                    </p>

                    <!-- How It Works -->
                    <h2>How It Works</h2>
                    <ol>
                        <li>Copy your unique referral link.</li>
                        <li>Share it with your network (friends, family, colleagues).</li>
                        <li>They register using your link.</li>
                        <li>Once verified, you earn ₹1000 instantly.</li>
                    </ol>

                    <!-- Rewards -->
                    <h2>Rewards</h2>
                    <p>
                        Each referral = <strong>₹1000</strong>.  
                        Invite 10 people → earn ₹10,000.  
                        Invite 100 people → earn ₹1,00,000.  
                        The possibilities are endless.  
                    </p>

                    <!-- FAQ -->
                    <h2>FAQs</h2>
                    <p><strong>Q:  When do I get my reward?</strong><br>Once your referral’s account is successfully verified and approved by our team, the reward amount will be reflected in your dashboard. At the end of each month, your total earnings are calculated, and the corresponding amount is transferred to your bank account on or before the 3rd of the following month.</p>
                    <p><strong>Q: How many people can I refer?</strong><br>There’s no limit to the number of people you can refer. However, we encourage you to invite individuals you know and trust, as you’ll be collaborating with them to build your network and establish your presence within the TGG India ecosystem.</p>
                    <p><strong>Q:  How will I know my rewards?</strong><br> You can track them on your dashboard.</p>

                    <!-- T&C -->
                    <h2>Terms & Conditions</h2>
                    <ul>
                        <li>Rewards apply only to verified accounts.</li>
                        <li>Fake or fraudulent referrals will be disqualified.</li>
                        <li>TGG India reserves the right to change program rules anytime.</li>
                    </ul>
                </div>
            </div>
            HTML;
            @endphp

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea id="content" name="content" rows="5" class="form-control js-ckeditor">{{ old('content', $content->content ?? $defaultContent) }}</textarea>
            </div>

            {{-- <div class="mb-3">
                <label for="min_size" class="form-label">Min Size</label>
                <input type="number" id="min_size" name="min_size" class="form-control" 
                       value="{{ old('min_size', $content->min_size ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="max_size" class="form-label">Max Size</label>
                <input type="number" id="max_size" name="max_size" class="form-control" 
                       value="{{ old('max_size', $content->max_size ?? '') }}">
            </div> --}}

            <button type="submit" class="btn btn-primary">Update Content</button>
        </form>
    </div>
</div>
@endsection
