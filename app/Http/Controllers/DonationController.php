<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Traits\RazorpayPaymentTrait;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Incentive;
use App\Models\Reward;

class DonationController extends Controller
{
    use RazorpayPaymentTrait;

    // Show donation page
    public function showDonationForm()
    {
        return view('tgg-india.donations.form');
    }

    // Create Razorpay order
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100', // minimum ₹100 donation
        ]);

        Donation::create([
            'user_id' => auth('web2')->id() ?? null, // if logged in
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'pan_card_number' => $request['pan_card_number'],
            'amount' => $request['amount'],
            'purpose' => 'TGG-AID program',
        ]);

         $paymentRecord = Payment::create([
            'payer_id'       =>  0,
            'payer_type'     => 'donation',
            'feature_key'    => 'donation',
            'amount'         => null,
            'status'         => 'captured',
            'transaction_id' =>  null,
            'payment_method' => null,
            'currency'       =>  'INR',
            'meta'           =>  null,
            'source_id'      =>  null,
            'source_type'    => 'donation',
        ]);


        return response()->json(['success' => true, 'message' => 'Donation successful! Thank you for supporting TGG India.', 'returnUrl' =>  $data['returnUrl']]);

        return redirect()->away('https://razorpay.me/@tggfoundationcharitabletr3236');


        $amount = $request->amount;
        $description = "Donation to TGG India. Supporting community development and growth.";
        $name = 'TGG India Donation';
        $user_name = $request->name ?? '';
        $user_details = $request->details ?? '';
        
        session(['razorpay_key_type' => 'donation']);

        $order = $this->createRazorpayOrder($amount, 'INR', 'don_' . time(), ['purpose' => 'donation'], 1);

        session([
            'donation.order_id' => $order['id'],
            'donation.amount'   => $amount,
            'donation.meta'     => [
                'data' => $request->all(),
                'description' => $description,
                'name'        => $name,
            ]
        ]);

        return view('tgg-india.rozarpay-payments', [
            'razorpayKey' => env('RAZORPAY_KEY'),
            'orderId'     => $order['id'],
            'amount'      => $amount,
            'name'        => $name,
            'description' => $description,
            'currency'    => 'INR',
            'themeColor'  => '#033576',
            'verifyRoute'  => route('tgg-india.donate.verify'),
            
        ]);
    }

    // Verify donation payment
    public function verifyDonation(Request $request)
    {
        $payload = $request->all();

        $expectedOrderId = session('donation.order_id');
        $expectedAmount  = session('donation.amount');
        $meta = session('donation.meta', []);
        $data = $meta['data'] ?? [];


        $result = $this->validateAndVerifyPayment($payload, $expectedOrderId, $expectedAmount);

        if (!$result['success']) {
            return response()->json(['success' => false, 'error' => $result['error']]);
        }

        $payment = $result['payment'];

        // Save donation payment
        $paymentRecord = Payment::create([
            'payer_id'       =>  0,
            'payer_type'     => 'donation',
            'feature_key'    => 'donation',
            'amount'         => (intval($payment['amount']) / 100),
            'status'         => $payment['status'] ?? 'captured',
            'transaction_id' => $payment['id'] ?? null,
            'payment_method' => $payment['method'] ?? null,
            'currency'       => $payment['currency'] ?? 'INR',
            'meta'           => json_encode($payment),
            'source_id'      =>  null,
            'source_type'    => 'donation',
        ]);

        Donation::create([
            'user_id' => auth('web2')->id() ?? null, // if logged in
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'pan_card_number' => $data['pan_card_number'],
            'amount' => $data['amount'],
            'purpose' => 'TGG-AID program',
        ]);
        // 💰 Reward 10% incentive for referrer/admin
        // $rewardAmount = round(($paymentRecord->amount * 0.10), 2);

        // Reward::create([
        //     'title'       => 'Donation Incentive',
        //     'source_id'   => $paymentRecord->id,  // link to payment
        //     'source_type' => 'donation',
        //     'target_id'   => 1, 
        //     'target_type' => null,
        //     'description' => 'Reward for supporting TGG India through donation from ' .session('donation.meta.user_name') ?? null .' '. session('donation.meta.user_details') ?? null,
        //     'reason'      => 'donation_reward',
        //     'amount'      => $rewardAmount,
        //     'status'      => 'completed',
        // ]);

        session()->forget('donation');

        return response()->json(['success' => true, 'message' => 'Donation successful! Thank you for supporting TGG India.', 'returnUrl' =>  $data['returnUrl']]);
    }
}
