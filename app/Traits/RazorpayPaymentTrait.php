<?php
namespace App\Traits;

use Razorpay\Api\Api;
use Exception;

trait RazorpayPaymentTrait
{
    protected function getRazorpayApi(): Api
    {
        // $key_type = session('razorpay_key_type', 'tgg-india'); 
        $key_type =  'tgg-india'; 
        if($key_type == 'tgg-india'){
            $key = env('RAZORPAY_KEY');
            $secret = env('RAZORPAY_SECRET');
        }else{
            $key = env('RAZORPAY_AID_KEY');
            $secret = env('RAZORPAY_AID_SECRET');
        }
        if (!$key || !$secret) {
            throw new Exception("Razorpay keys missing in .env");
        }
        return new Api($key, $secret);
    }

    // Convert rupees (or numeric) to paise integer
    protected function toPaise($amount): int
    {
        return (int) round(floatval($amount) * 100);
    }

    /**
     * Create an order on Razorpay.
     * $amount in rupees (float/int)
     * returns order object/array from Razorpay SDK
     */
    public function createRazorpayOrder($amount, $currency = 'INR', $receipt = null, array $notes = [], $payment_capture = 1 ,$key_type = 'tgg-india')
    {
        $api = $this->getRazorpayApi();
        $data = [
            'amount' => $this->toPaise($amount),
            'currency' => $currency,
            'receipt' => $receipt ?? 'rcpt_' . time(),
            'payment_capture' => $payment_capture
        ];
        if (!empty($notes)) $data['notes'] = $notes;
        return $api->order->create($data);
    }

    /**
     * Fetch payment details by payment id
     */
    public function fetchPayment($paymentId)
    {
        $api = $this->getRazorpayApi();
        return $api->payment->fetch($paymentId);
    }

    /**
     * Capture a payment (if you created an order with capture=0)
     * $amount in rupees
     */
    public function capturePayment($paymentId, $amount)
    {
        $api = $this->getRazorpayApi();
        $paise = $this->toPaise($amount);
        return $api->payment->fetch($paymentId)->capture(['amount' => $paise]);
    }

    /**
     * Verify signature — throws exception on failure
     * Provide an array: ['razorpay_order_id'=>..., 'razorpay_payment_id'=>..., 'razorpay_signature'=>...]
     */
    public function verifyRazorpaySignature(array $attributes): bool
    {
        $api = $this->getRazorpayApi();
        $api->utility->verifyPaymentSignature($attributes); // throws on failure
        return true;
    }

    /**
     * Full validation + verification helper.
     * $payload must contain razorpay_order_id, razorpay_payment_id, razorpay_signature.
     * $expectedOrderId optional — to check order id matches
     * $expectedAmount optional (in rupees) — checks paid amount >= expected
     *
     * Returns ['success'=>true, 'payment'=><payment-object>] OR ['success'=>false,'error'=>...]
     */
    public function validateAndVerifyPayment(array $payload, $expectedOrderId = null, $expectedAmount = null)
    {
        try {
            // verify signature (will throw if invalid)
            $this->verifyRazorpaySignature([
                'razorpay_order_id'   => $payload['razorpay_order_id'] ?? null,
                'razorpay_payment_id' => $payload['razorpay_payment_id'] ?? null,
                'razorpay_signature'  => $payload['razorpay_signature'] ?? null,
            ]);

            // fetch payment from Razorpay to inspect amount/status
            $payment = $this->fetchPayment($payload['razorpay_payment_id']);

            // order id check
            if ($expectedOrderId && ($payment['order_id'] ?? null) !== $expectedOrderId) {
                return ['success' => false, 'error' => 'order_id_mismatch', 'payment' => $payment];
            }

            // amount check (payment['amount'] is in paise)
            if ($expectedAmount !== null) {
                $paidPaise = intval($payment['amount'] ?? 0);
                if ($paidPaise < $this->toPaise($expectedAmount)) {
                    return ['success' => false, 'error' => 'amount_mismatch', 'payment' => $payment];
                }
            }

            // status check
            $status = $payment['status'] ?? '';
            if (!in_array($status, ['captured', 'authorized'])) {
                return ['success' => false, 'error' => 'invalid_status:' . $status, 'payment' => $payment];
            }

            return ['success' => true, 'payment' => $payment];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
