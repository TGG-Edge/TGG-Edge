@extends('tgg-india.layouts.app')

@section('title', 'Complete Payment')
@php
    $is_sidebar = false;
@endphp
@section('content')
<div class="container py-5">
    <div class="card p-4" style="max-width:720px;margin:auto;">
        <h4 class="mb-3">Complete Payment</h4>
        <p>Details: {{ $description ?? 'Payment' }}</p>
        <p>Amount: <strong>₹{{ number_format($amount,2) }}</strong></p>
        @if(isset($user_name))
         <p>User Name: <strong>{{ $user_name ?? '' }}</strong></p>
          <p>User Details: <strong>{{ $user_details ?? "" }}</strong></p>
        @endif  
        <div class="text-center mt-4">
            <button id="rzp-button" class="btn btn-success">Pay with Razorpay</button>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const options = {
        "key": "{{ $razorpayKey }}",
        "amount": "{{ intval($amount*100) }}",
        "currency": "{{ $currency ?? 'INR' }}",
        "name": "{{ $name ?? 'TGG India' }}",
        "description": "{{ $description ?? 'Payment' }}",
        "order_id": "{{ $orderId }}",
        "handler": function (response){
            // send verification to server
            fetch("{{ $verifyRoute ?? route('tgg-india.register.payment.verify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(response)
            }).then(r => r.json())
              .then(data => {
                  if (data.success) {
                      // redirect to success page if provided, else show message
                      let redirectUrl = "{{ $returnUrl ?? '' }}"; // server-side default

                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        } else if (data.returnUrl) {
                            window.location.href = data.returnUrl;
                        } else {
                            alert('Payment successful');
                            window.location.href = "{{ route('tgg-india.show') }}";
                        }
                  } else {
                      alert('Payment verification failed: ' + (data.error || ''));
                  }
              }).catch(err=>{
                  alert('Network error while verifying payment');
              });
        },
        "prefill": {!! json_encode($prefill ?? []) !!},
        "theme": {"color": "{{ $themeColor ?? '#033576' }}"}
    };
    const rzp = new Razorpay(options);
    document.getElementById('rzp-button').onclick = function(e){
        rzp.open();
        e.preventDefault();
    };
</script>
@endsection
