@extends('tgg-india.layouts.app')

@section('title', 'TGG India Referral Program | TGG Meta | TGG India')
@section('content')

<style>
    .referral-page h1 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #222;
    }
    .referral-page h2 {
        font-size: 16px;
        font-weight: 600;
        margin-top: 25px;
        margin-bottom: 10px;
        color: #333;
    }
    .referral-page p, 
    .referral-page li {
        font-size: 14px;
        line-height: 1.7;
        color: #555;
    }
    .referral-box {
        background: #f9f9f9;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 8px;
    }
    .referral-box input {
        font-size: 14px;
    }
</style>

<div class="container referral-page">
    <div class="card shadow-lg p-4">
        <!-- Hero Section -->
        <h1 class="text-center text-primary">TGG India Referral Program</h1>
        <p class="text-center" style="font-size:14px; max-width: 700px; margin: auto;">
            You are a proud advisor of <strong>TGG India</strong>. Invite your friends to join our program.  
            When they register successfully and their account is verified, you will receive a reward of 
            <strong>₹1000</strong> directly in your account.  
        </p>
        <hr>

        <!-- About Section -->
        <h2>About TGG India</h2>
        <p>
            TGG India is a trusted platform built on innovation, collaboration, and shared success.  
            Our vision is to empower individuals with opportunities to earn, learn, and grow.  
            By joining our referral program, you not only get rewards but also help us create a stronger 
            network of achievers across India.  
        </p>

        <!-- What is Referral Program -->
        <h2>What is the Referral Program?</h2>
        <p>
            The TGG India Referral Program allows advisors to earn rewards by inviting others to join.  
            Each successful referral that leads to a verified registration will reward you with 
            <strong>₹1000</strong>. There’s no cap on how much you can earn—your efforts decide your success.  
        </p>

        <!-- Why Join -->
        <h2>Why Join?</h2>
        <ul>
            <li><strong>Earn ₹1000</strong> for every successful referral.</li>
            <li>No upper limit—earn as much as you want.</li>
            <li>Be part of a growing, trusted community.</li>
            <li>Track rewards transparently via your dashboard.</li>
        </ul>

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
        <p><strong>Q: When do I get my reward?</strong><br> After your referral’s account is verified.</p>
        <p><strong>Q: How many people can I refer?</strong><br> Unlimited.</p>
        <p><strong>Q: How will I know my rewards?</strong><br> You can track them on your dashboard.</p>

        <!-- T&C -->
        <h2>Terms & Conditions</h2>
        <ul>
            <li>Rewards apply only to verified accounts.</li>
            <li>Fake or fraudulent referrals will be disqualified.</li>
            <li>TGG India reserves the right to change program rules anytime.</li>
        </ul>

        <hr>

        <!-- Referral Link Box -->
        @php
            $referralLink = url('/register?ref=' . auth()->id());
        @endphp

        <h2 class="page-heading">YOUR REFERRAL LINK</h2>
        <div class="referral-box">
    <div class="input-group" style="    justify-content: space-between;">
        @php
            // Example referral code (replace with dynamic value later if needed)
            $referralCode = 'XASFSDF3223WDSCDW';
            $referralLink = url('tgg-meta/tgg-india/referral/' . $referralCode);
        @endphp

        <input type="hidden" id="referralLink" class="form-control" value="{{ $referralLink }}" readonly>

        <a href="{{ $referralLink }}" target="_blank" class="" style="
    color: black;
    text-decoration: none;
">
          {{ $referralLink }}
        </a>

        {{-- <button class="btn btn-success" onclick="copyReferral()">Copy</button> --}}
    </div>
</div>

<script>
    function copyReferral() {
        let input = document.getElementById("referralLink");
        input.select();
        input.setSelectionRange(0, 99999); // For mobile
        document.execCommand("copy");
        alert("Referral link copied: " + input.value);
    }
</script>
    </div>
</div>
@endsection