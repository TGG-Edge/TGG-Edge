<?php
namespace App\Services\Chat;

use App\Models\Setting;
use App\Services\Chat\AI\OpenAIService;
use App\Services\Chat\AI\GeminiService;

class QuestionFilterService
{
    protected OpenAIService $openAIService;
    protected GeminiService $geminiService;
    protected $basedOnContext;

    public function __construct(
        OpenAIService $openAIService,
        GeminiService $geminiService
    ) {
        $this->openAIService = $openAIService;
        $this->geminiService = $geminiService;
        $this->basedOnContext = Setting::where('key', 'business_prompt')->value('value')
                ?? "You are an expert assistant for TGG India, a platform that helps NGOs and social enterprises with technology solutions, capacity building, and funding support.
        You have in-depth knowledge about TGG India's platform features, programs, RHM (Resource Hub for Members), member organizations, journeys, user roles, dashboards, and other functionalities.
        Your task is to determine whether user questions are related to TGG India and its offerings.";

    }

    protected array $keywords = [
        'website', 'software', 'system', 'login',
        'payment', 'onboarding', 'account',
        'feature', 'module', 'dashboard'
    ];

    public function isRelated(string $question): bool
    {
       
        $prompt = $this->basedOnContext .
            " You must decide if the user's question is related to TGG India (its platform, programs, RHM, members, journeys, roles, dashboards, or features). 
            Answer in STRICT JSON format only: {\"related\": true} or {\"related\": false}. 
            Do NOT add any explanation, text, or markdown.";

        $response = $this->geminiService->isRelated($question, $prompt);
        
        $data = json_decode(trim($response), true);
        return isset($data['related']) ? (bool)$data['related'] : false;

    }
}
