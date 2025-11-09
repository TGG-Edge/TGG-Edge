<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSecondary;
use App\Models\Enquiry;
use App\Models\Incentive;
use App\Models\ModuleInstance;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Traits\RazorpayPaymentTrait;
use App\Traits\MailTrait;


class RegisterController extends Controller
{
    use RazorpayPaymentTrait,MailTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $user_type)
    {
        //
        if ($user_type == 'trainer') {
            $user_type = 2;
        } elseif ($user_type == 'advisor') {
            $user_type = 3;
        } elseif ($user_type == 'admin') {
            $user_type = 1;
        } elseif ($user_type == 'rhm-club') {
            $user_type = 4;
        } elseif ($user_type == 'nomad-community') {
            $user_type = 5;
        }elseif ($user_type == 'co-creator') {
            $user_type = 7;
        }elseif ($user_type == 'facilitator') {
            $user_type = 8;
        }
        elseif ($user_type == 'spouse') {
            $user_type = 9;
        }
         else {
            $user_type = 10;
        }

        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'number' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('mysql2.users', 'email')->where(function ($query) use ($user_type) {
                    return $query->where('user_role', $user_type);
                }),
            ],
            'address' => 'required|string',
            'rhm_number' => 'required'
        ]);

        // Store user
        $user = UserSecondary::create([
            'name' => $request->name,
            'age' => $request->age,
            'project' => $request->project ?? null,
            'phone' => $request->number,
            'email' => $request->email,
            'address' => $request->address,
            'user_role' => $user_type,
            'rhm_number' => $request->rhm_number,
            'parent_rhm_number' => $request->parent_rhm_number,
            'password' => Hash::make('default-password'),
            'referral_code' => generateUniqueReferralCode(),
        ]);

        // if ($refCode = $request->query('ref')) {
        //     $referrer = UserSecondary::where('referral_code', $refCode)->first();
        //     if ($referrer && $referrer->id != $user->id) {
        //         Referral::create([
        //             'referrer_id' => $referrer->id,
        //             'referred_id' => $user->id,
        //             'step' => 0
        //         ]);
        //     }
        // }

        // if ($request->has('modules') && is_array($request->modules)) {
        //     foreach ($request->modules as $moduleId) {
        //         ModuleInstance::create([
        //             'module_id' => $moduleId,
        //             'user_id' => $user->id,
        //         ]);
        //     }
        // }

        if ($request->has('modules') && is_array($request->modules)) {
            $modules = $request->modules;
        } else {
            $modules = [];
        }

        if (!in_array(1, $modules)) {
            $modules[] = 1;
        }

        foreach ($modules as $moduleId) {
            ModuleInstance::create([
                'module_id' => $moduleId,
                'user_id'   => $user->id,
            ]);
        }

        return redirect()->route('tgg-india.login')->with('success', 'Registration successful!');
    }

    public function referralStore(Request $request, $user_type)
    {
        
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'email' => [
                'required',
                'email',
                Rule::unique('mysql2.users', 'email')->where(function ($query) use ($user_type) {
                    return $query->where('user_role', $user_type);
                }),
            ],
            'address' => 'required|string',
        ]);

        if($request->rhm_alignment == 'No'){
             return redirect()->back()->with('error', 'This opportunity is for Responsible Humans only.');
        }
        $amount = 1000;
        $description = 'Thank you for joining the Eco-Entrepreneurship Program by TGG India. A one-time fee of ₹1,000 covers training, mentorship & TGG-Meta access. Pay via UPI, card, bank transfer, or wallet. Confirmation email will be sent within 48 hours.';

        
        $user_type_id = 3;

         $referredUser = UserSecondary::create([
            'name' => $request['name'],
            'age' => $request['age'] ?? null,
            'nationality' => $request['nationality'] ?? null,
            'gender' => $request['gender'] ?? null,
            'area_of_expertise' => $request['expertise'] ?? null,
            'responsible_human_mission' => isset($request['rhm_alignment']) && $request['rhm_alignment'] === 'yes' ? 1 : 0,
            'linkedin_profile' => $request['linkedin'] ?? null,
            'consent_declaration' => isset($request['consent']) ? 1 : 0,
            'rhm_number' => $request->rhm_number ?? null,
            'project' => $request['project'] ?? null,
            'phone' => $request['phone'],
            'email' => $request['email'],
            'address' => $request['address'],
            'user_role' => $user_type_id,
            // 'rhm_number' => $request['rhm_number'],
            'password' => Hash::make('default-password'),
            'referral_code' => generateUniqueReferralCode(),
        ]);

       
        $modules = $request['modules'] ?? [];
        if (!in_array(1, $modules)) {
            $modules[] = 1;
        }
        foreach ($modules as $moduleId) {
            ModuleInstance::create([
                'module_id' => $moduleId,
                'user_id'   => $referredUser->id,
            ]);
        }

         if (!empty($request['referral_code'])) {
            $referrerUser = UserSecondary::where('referral_code', $request['referral_code'])->first();
            if ($referrerUser) {
                Referral::create([
                    'referrer_id' => $referrerUser->id,
                    'referred_id' => $referredUser->id,
                    'step' => 0
                ]);
            }
        }

          $paymentRecord = Payment::create([
            'payer_id' => $referredUser->id,
            'payer_type' => 'registration',
            'feature_key' => 'registration',
            'amount' => 1000,
            'status' => $payment['status'] ?? 'captured',
            'transaction_id' => $request['transaction_id'] ?? null,        
            'payment_method' => $payment['method'] ?? null,  
            'currency' => $payment['currency'] ?? 'INR',
            'meta' => json_encode([
                'order_id' => $payment['order_id'] ?? null,
                'description' => session('payment.meta.description') ?? 'registration',
                'name' => session('payment.meta.name') ?? null,
                'extra' => session('payment.meta.extra') ?? [],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
            'source_id' => $referredUser->id,
            'source_type' => 'UserSecondary',
        ]);

        Incentive::create([
            'title'       => 'Referral Incentive',
            'source_id'   => $referrerUser->id,
            'source_type' => 'registration',
            'target_id'   =>  1,  
            'target_type' => null,
            'description' => 'Incentive for successful registration via referral',
            'reason'      => 'registration_referral',
            'amount'      => 250,   
            'status'      => 'pending',
        ]);

        $to = $request['email'];
        $subject = 'Welcome to TGG India - Registration Successful';
        $view = 'tgg-india.emails.tgg-template';
        $data = [
            'name' => $request['name'],
            'message' => 'Thank you for registering with TGG India! Your account has been successfully created. We’re excited to have you on board and look forward to your journey with us.',
            'button_text' => 'Login to Your Account',
            'button_url' => url('https://thegoldengreens.com/tgg-meta/tgg-india/login')
        ];

        $ok = $this->sendMail($to, $subject, $view, $data);


        return redirect()->route('tgg-india.login')->with('success', 'Registration successful!');

       session(['razorpay_key_type' => 'tgg-india']);
        // create order on razorpay
        $order = $this->createRazorpayOrder($amount, 'INR', 'rcpt_' . time(), ['purpose' => $description], 1);

        // store registration data in session until payment verified
        session([
            'pending_registration' => [
                'data' => $request->all(),
                'user_type' => $user_type,
            ],
            'payment.order_id' => $order['id'],
            'payment.amount' => $amount,
            'payment.meta' => [
                'description' => $description,
                'name' => 'TGG India',
                'return_url' => '',
            ]
        ]);

        return view('tgg-india.rozarpay-payments', [
            'razorpayKey' => env('RAZORPAY_KEY'),
            'orderId' => $order['id'],
            'amount' => $amount,
            'name' => 'TGG India',
            'description' => $description,
            'currency' => 'INR',
            'themeColor' => '#033576',
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $payload = $request->all();

        $expectedOrderId = session('payment.order_id');
        $expectedAmount = session('payment.amount');

        $result = $this->validateAndVerifyPayment($payload, $expectedOrderId, $expectedAmount);

        if (!$result['success']) {
            return response()->json(['success' => false, 'error' => $result['error']]);
        }

        $payment = $result['payment'];
        $regData = session('pending_registration.data');
        $userType = session('pending_registration.user_type');

        
        $roleMap = [
            'admin' => 1,
            'trainer' => 2,
            'advisor' => 3,
            'rhm-club' => 4,
            'nomad-community' => 5,
            'researcher' => 6,
            'facilitator' => 8,
            'spouse' => 9,
        ];
        $user_type_id = $roleMap[$userType] ?? 3;

        
        $referredUser = UserSecondary::create([
            'name' => $regData['name'],
            'age' => $regData['age'] ?? null,
            'nationality' => $regData['nationality'] ?? null,
            'gender' => $regData['gender'] ?? null,
            'area_of_expertise' => $regData['expertise'] ?? null,
            'responsible_human_mission' => isset($regData['rhm_alignment']) && $regData['rhm_alignment'] === 'yes' ? 1 : 0,
            'linkedin_profile' => $regData['linkedin'] ?? null,
            'consent_declaration' => isset($regData['consent']) ? 1 : 0,
            'project' => $regData['project'] ?? null,
            'phone' => $regData['phone'],
            'email' => $regData['email'],
            'address' => $regData['address'],
            'user_role' => $user_type_id,
            // 'rhm_number' => $regData['rhm_number'],
            'password' => Hash::make('default-password'),
            'referral_code' => generateUniqueReferralCode(),
        ]);

       
        $modules = $regData['modules'] ?? [];
        if (!in_array(1, $modules)) {
            $modules[] = 1;
        }
        foreach ($modules as $moduleId) {
            ModuleInstance::create([
                'module_id' => $moduleId,
                'user_id'   => $referredUser->id,
            ]);
        }

        if (!empty($regData['referral_code'])) {
            $referrerUser = UserSecondary::where('referral_code', $regData['referral_code'])->first();
            if ($referrerUser) {
                Referral::create([
                    'referrer_id' => $referrerUser->id,
                    'referred_id' => $referredUser->id,
                    'step' => 0
                ]);
            }
        }

        
          $paymentRecord = Payment::create([
            'payer_id' => $referredUser->id,
            'payer_type' => 'registration',
            'feature_key' => 'registration',
            'amount' => (intval($payment['amount']) / 100),
            'status' => $payment['status'] ?? 'captured',
            'transaction_id' => $payment['id'] ?? null,        
            'payment_method' => $payment['method'] ?? null,  
            'currency' => $payment['currency'] ?? 'INR',
            'meta' => json_encode([
                'order_id' => $payment['order_id'] ?? null,
                'description' => session('payment.meta.description') ?? 'registration',
                'name' => session('payment.meta.name') ?? null,
                'extra' => session('payment.meta.extra') ?? [],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
            'source_id' => $referredUser->id,
            'source_type' => 'UserSecondary',
        ]);

        Incentive::create([
            'title'       => 'Referral Incentive',
            'source_id'   => $referrerUser->id,
            'source_type' => 'registration',
            'target_id'   =>  1,  
            'target_type' => null,
            'description' => 'Incentive for successful registration via referral',
            'reason'      => 'registration_referral',
            'amount'      => 250,   
            'status'      => 'pending',
        ]);

        session()->forget(['pending_registration', 'payment']);

        return response()->json(['success' => true, 'message' => 'Registration completed successfully!']);
    }


    /**
     * Display the specified resource.
     */
    public function show($user_type)
    {
        $user_types = collect(UserSecondary::$user_types);

        // Find the ID where the name matches (case-insensitive)
        $foundKey = $user_types
            ->search(fn($info) => strcasecmp($info['key'], $user_type) === 0);

        if ($foundKey === false) {
            abort(404);
        }

        return view('tgg-india.register', compact('user_type', 'user_types'));
    }

    public function showReferral($referrer_code)
    {
        $user_type = 'advisor';
        return view('tgg-india.referral-register', compact('user_type', 'referrer_code'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showEnquiry($referral_code)
    {
        return view('tgg-india.enquiry', compact('referral_code'));
    }

    public function storeEnquiry(Request $request, $referral_code)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|string',
            'message' => 'nullable|string',
        ]);

        Enquiry::create([
            'referral_code' => $referral_code,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Your enquiry has been submitted successfully!');
    }

}
