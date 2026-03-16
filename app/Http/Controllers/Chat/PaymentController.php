<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Chat\PaymentService;
use App\Services\Chat\UserRegistrationService;
use App\Models\ChatSession;

class PaymentController extends Controller
{

    public function __construct(
        protected PaymentService $paymentService,
        protected UserRegistrationService $userRegistrationService
    ) {}

    public function createOrder(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required'
        ]);

        $order = $this->paymentService->createOrder($request->enquiry_id);

        return response()->json($order);
    }

    public function verifyPayment(Request $request)
    {
        // ✅ Validate Razorpay response
        $validated = $request->validate([
            'session_id' => 'required|string',
            'enquiry_id' => 'required|integer',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        // ✅ Verify payment via service
        $data = $this->paymentService->verify($validated);

        // ✅ Register user from enquiry
        $user = $this->userRegistrationService
            ->registerFromEnquiry($data['enquiry_id']);

        // ✅ Update chat session
        $session = ChatSession::where('session_id', $validated['session_id'])->firstOrFail();

        $session->update([
            'user_id' => $user->id,
            'status'  => 'completed'
        ]);

        return response()->json([
            'status'  => true,
            'message' => '🎉 Thank you! You are successfully registered.',
            'html'    => view('chatbot.payment.success')->render()
        ]);
    }
}
