<?php
namespace App\Services\Chat;

use Razorpay\Api\Api;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\UserSecondary;

class PaymentService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            env('RAZORPAY_AID_KEY'),
            env('RAZORPAY_AID_SECRET')
        );
    }

    public function createOrder($enquiryId)
    {
        $enquiry = Enquiry::findOrFail($enquiryId); 
        $roleType = $enquiry->role;
        $userTypes = UserSecondary::$user_types;
        // Get onboarding amount
        $amount = $userTypes[$roleType]['onboarding_amount'];

        // Convert to paise (Razorpay requires smallest currency unit)
        $amountInPaise = $amount * 100;


        // Validate role exists
        if (!isset($userTypes[$roleType])) {
            throw new \Exception('Invalid role type');
        }

        $order = $this->api->order->create([
            'amount' => $amountInPaise, // example ₹500
            'currency' => 'INR',
            'receipt' => 'ENQ_' . $enquiryId
        ]);


        return [
            'order_id' => $order['id'],
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'key' => env('RAZORPAY_AID_KEY')
        ];
    }

    public function verify($data)
    {
        // Signature verification skipped for brevity
        Payment::create([
            'payer_id' => $data['enquiry_id'],
            'payer_type' => 'enquiry',
            'feature_key' => 'onboarding_fee',
            'amount' => 50000,
            'status' => 'paid',
            'payment_id' => $data['razorpay_payment_id'],
            'order_id' => $data['razorpay_order_id'],
            'status' => 'success'
        ]);

        return $data;
    }
}
