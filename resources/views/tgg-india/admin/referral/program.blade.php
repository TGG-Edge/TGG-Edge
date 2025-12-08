@extends('tgg-india.layouts.app')

@section('title', 'TGG India Referral Program | TGG Meta | TGG India')
@section('content')

<div>
    {!! $content->content !!}
</div>
<hr>

<!-- Referral Link Box -->
@php
    $referralLink = url('/register?ref=' . auth()->id());
@endphp

<div class="referral-box mb-4 refbox">
    <h5>Your Referral Link</h5>
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
        @php
            $referralCode = Auth('web2')->user()->referral_code;
            $referralLink = url('tgg-meta/tgg-india/register/referral/' . $referralCode);
        @endphp

        <input type="text" id="referralLink" class="form-control flex-grow-1" value="{{ $referralLink }}" readonly>
        <button type="button" class="btn btn-sm btn-primary" onclick="copyReferralLink()">
            Copy
        </button>
    </div>
</div>

<hr>

<div class="referral-box mb-4 refbox">
    <h5>Your Lead Referral Link</h5>
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
        @php
            $referralLink = url('tgg-meta/tgg-india/enquiry/referral/' . $referralCode);
        @endphp

        <input type="text" id="referralLink1" class="form-control flex-grow-1" value="{{ $referralLink }}" readonly>
        <button type="button" class="btn btn-sm btn-primary" onclick="copyReferralLeadLink()">
            Copy
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function copyReferralLink() {
        let input = document.getElementById("referralLink");
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(input.value).then(() => {
            alert("Referral link copied: " + input.value);
        });
    }

    function copyReferralLeadLink() {
        let input = document.getElementById("referralLink1");
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(input.value).then(() => {
            alert("Referral Lead link copied: " + input.value);
        });
    }
</script>
@endpush
