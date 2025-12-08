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

<div class="referral-box">
    <h2>YOUR REFERRAL LINK</h2>
    <div class="input-group" style="justify-content: space-between; align-items: center;">
        @php
            $referralCode = Auth('web2')->user()->referral_code;
            $referralLink = url('tgg-meta/tgg-india/register/referral/' . $referralCode);
        @endphp

        <input type="text" id="referralLink" class="form-control" value="{{ $referralLink }}" readonly style="max-width: 70%;">

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