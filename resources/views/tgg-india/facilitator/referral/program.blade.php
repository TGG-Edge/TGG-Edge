@extends('tgg-india.layouts.app')

@section('title', 'TGG India Referral Program | TGG Meta | TGG India')
@section('content')
<!-- Referral Link Box -->
<div>
        {!! $content->content !!}
    </div>
    <hr>
<div class="referral-box mb-4 refbox">
   
    <h5 class="page-heading">YOUR LEAD REFERRAL LINK</h5>
    <div class="input-group" style="justify-content: space-between; align-items: center;">
        @php
            $referralCode = Auth('web2')->user()->referral_code;
            $referralLink = url('tgg-meta/tgg-india/enquiry/referral/' . $referralCode);
        @endphp

        <input type="text" id="referralLink" class="form-control" value="{{ $referralLink }}" readonly style="max-width: 100%;">

        <button type="button" class="btn btn-sm btn-primary ms-2" onclick="copyReferral()">
            Copy
        </button>   
    </div>
</div>
@endsection
@push('scripts')
<script>
    function copyReferral() {
        let input = document.getElementById("referralLink");
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(input.value).then(() => {
            alert("Referral link copied: " + input.value);
        });
    }
</script>
@endpush