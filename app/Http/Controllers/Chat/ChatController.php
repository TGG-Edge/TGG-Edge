<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\Chat\ChatSessionService;
use App\Services\Chat\ChatMessageService;
use App\Services\Chat\ChatFlowService;
use App\Services\Chat\QuestionFilterService;
use App\Services\Chat\AI\OpenAIService;
use App\Services\Chat\AI\GeminiService;


class ChatController extends Controller
{
    // protected $sessionService;
    // protected $messageService;
    protected ChatSessionService $sessionService;
    protected ChatMessageService $messageService;
    protected ChatFlowService $chatFlowService;
    protected QuestionFilterService $questionFilterService;
    protected OpenAIService $openAIService;
    protected GeminiService $geminiService;


    public function __construct(
        ChatSessionService $sessionService,
        ChatMessageService $messageService,
        ChatFlowService $chatFlowService,
        QuestionFilterService $questionFilterService,
        OpenAIService $openAIService,
        GeminiService $geminiService
    ) {
        $this->sessionService = $sessionService;
        $this->messageService = $messageService;
        $this->chatFlowService = $chatFlowService;
        $this->questionFilterService = $questionFilterService;
        $this->openAIService = $openAIService;
        $this->geminiService = $geminiService;

    }

    /**
     * Initialize chat session
     */
    public function init(Request $request)
    {
        
        $session = $this->sessionService->getOrCreate(
            session()->getId(),
            request()->ip(),
        );

        // Initial bot message
        $this->messageService->store([
            'chat_session_id' => $session->id,
            'type' => 0,
            'sender' => 'bot',
            'description' => 'Hello! What do you want to do?',
            'step' => 'welcome'
        ]);

        return response()->json([
            'status' => true,
            'session_id' => $session->session_id
        ]);
    }


    public function welcome()
    {
        $faqs = \App\Models\Faq::whereNull('parent_id')
                ->where('is_active', 1)
                ->with(['children' => function($q){
                    $q->where('is_active', 1);
                }])
                ->orderBy('sort_order')
                ->get();

        $categories = \App\Models\FaqCategory::with([
                        'faqs' => function ($q) {
                            $q->whereNull('parent_id')
                            ->where('is_active', 1)
                            ->with('children');
                        }
                    ])
                    ->where('is_active', 1)
                    ->get();

        return response()->json([
            'html' => view('chatbot.chat.welcome',compact('faqs','categories'))->render()
        ]);
    }


    public function askEmail()
    {
        return response()->json([
            'html' => view('chatbot.chat.ask-email')->render()
        ]);
    }

    /**
     * Handle chat message
     */
    public function message(Request $request)
    {
        // $request->validate([
        //     'session_id' => 'required',
        //     'message' => 'nullable|string',
        //     'action' => 'nullable|string'
        // ]);

        $session = $this->sessionService->findBySessionId( $request->session_id );

        if (!$session) {
            return response()->json(['status' => false], 404);
        }

        // Store user message / action
        // if ($request->message) {
        //     $this->messageService->store([
        //         'chat_session_id' => $session->id,
        //         'email' => $request->email,
        //         'type' => 0,
        //         'sender' => 'user',
        //         'description' => $request->message,
        //     ]);
        // }

        if ($request->message) {

            $this->messageService->store([
                'chat_session_id' => $session->id,
                'email' => $request->email,
                'type' => 0,
                'sender' => 'user',
                'description' => $request->message,
            ]);

            $context = Setting::where('key', 'business_prompt')->value('value')
                    ?? "You are an expert assistant for TGG India, a platform that helps NGOs and social enterprises with technology solutions, capacity building, and funding support.
            You have in-depth knowledge about TGG India's platform features, programs, RHM (Resource Hub for Members), member organizations, journeys, user roles, dashboards, and other functionalities.
            Your task is to determine whether user questions are related to TGG India and its offerings.";
            $context = compact('context');

            $reply = $this->chatFlowService->handleOtherTalk( $request->message,$this->questionFilterService, $this->geminiService, $context );

            $this->messageService->store([
                'chat_session_id' => $session->id,
                'sender' => 'bot',
                'type' => 0,
                'description' => $reply,
            ]);

            return response()->json(['reply' => $reply]);
        }

        // Handle flow switch
        if ($request->action === 'onboarding') {
            return response()->json([
                'reply' => 'Please fill the onboarding form.'
            ]);
        }

        if ($request->action === 'other_talk') {
            return response()->json([
                'reply' => 'Please enter your email to continue.'
            ]);
        }

        return response()->json([
            'reply' => 'Message received',
            'html' => view('chatbot.chat.ai-reply', [
                'reply' => 'This is AI generated response'
            ])->render()
        ]);
    }


    public function technologSolutionMessage(Request $request)
    {
        // $request->validate([
        //     'session_id' => 'required',
        //     'message' => 'nullable|string',
        //     'action' => 'nullable|string'
        // ]);

        $session = $this->sessionService->findBySessionId( $request->session_id );

        if (!$session) {
            return response()->json(['status' => false], 404);
        }


        if ($request->message) {

            $this->messageService->store([
                'chat_session_id' => $session->id,
                'email' => $request->email,
                'type' => 2,
                'sender' => 'user',
                'description' => $request->message,
            ]);

            $context = Setting::where('key', 'technolog_solution_prompt')->value('value')
                    ?? "You are an expert assistant for TGG India, a platform that helps NGOs and social enterprises with technology solutions, capacity building, and funding support.
            You have in-depth knowledge about TGG India's platform features, programs, RHM (Resource Hub for Members), member organizations, journeys, user roles, dashboards, and other functionalities.
            Your task is to determine whether user questions are related to TGG India and its offerings.";
            $context = compact('context');

            $reply = $this->chatFlowService->handleOtherTalk( $request->message,$this->questionFilterService, $this->geminiService, $context );

            $this->messageService->store([
                'chat_session_id' => $session->id,
                'sender' => 'bot',
                'type' => 2,
                'description' => $reply,
            ]);

            return response()->json(['reply' => $reply]);
        }

        // Handle flow switch
        if ($request->action === 'onboarding') {
            return response()->json([
                'reply' => 'Please fill the onboarding form.'
            ]);
        }

        if ($request->action === 'other_talk') {
            return response()->json([
                'reply' => 'Please enter your email to continue.'
            ]);
        }

        return response()->json([
            'reply' => 'Message received',
            'html' => view('chatbot.chat.ai-reply', [
                'reply' => 'This is AI generated response'
            ])->render()
        ]);
    }
}
