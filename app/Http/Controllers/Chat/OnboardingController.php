<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Chat\OnboardingService;
use App\Services\Chat\ChatMessageService;
use App\Models\ChatSession;
use App\Models\UserSecondary;

class OnboardingController extends Controller
{

    public function __construct(
        protected OnboardingService $onboardingService,
        protected ChatMessageService $chatMessageService
    ) {}


    public function submit(Request $request)
    {
         $validated = $request->validate([
            'session_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'address' => 'required',
            'role_type' => 'required',
            'referred_by' => 'nullable'
        ]);

        $session = ChatSession::where('session_id', $request->session_id)->firstOrFail();
        

        $enquiry = $this->onboardingService->store([
            'session_id' => $request->input('session_id'),
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'number'     => $request->input('number'),
            'address'    => $request->input('address'),
            'role_type'  => $request->input('role_type'),
            'referred_by'=> $request->input('referred_by'),
        ]);

        $this->chatMessageService->store([
            'chat_session_id' => $session->id,
            'email'           => $request->email,
            'type'            => 1,
            'sender'          => 'user',
            'description'     => 'Onboarding form submitted',
            'payload'         => NULL,
            'step'            => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thanks! Please proceed to payment.',
            'enquiry_id' => $enquiry->id  
        ]);
    }

    public function form(Request $request)
    {

        $roleTypes = collect(UserSecondary::$user_types)
        ->only([3, 6, 7, 8]) // Associate, Freelancer, Co Creator, Facilitator
        ->toArray();

        // Dummy referred users for testing
        $users = UserSecondary::select('id', 'name')
            ->orderBy('name')
            ->get();

        $userTypeFromUrl = $request->user_type;

        return response()->json([
            'html' => view('chatbot.onboarding.form', compact(
                'roleTypes',
                'users','userTypeFromUrl'
            ))->render()
        ]);
    }

}
