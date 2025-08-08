<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $togetherModels = [
        'meta-llama/Llama-3.3-70B-Instruct-Turbo',
        'deepseek-ai/DeepSeek-V3',
        'Qwen/Qwen2.5-72B-Instruct-Turbo',
        'NousResearch/Nous-Hermes-2-Mixtral-8x7B-DPO',
        'mistralai/Mixtral-8x7B-Instruct-v0.1',
    ];

    protected $geminiModels = [
        'gemini-1.5-flash-latest',
        'gemini-pro',
    ];

    public function createPrompt($topic, $academicLevel = "Graduate", $researchArea = "", $keywords = "", $userContext = "")
    {
        return <<<EOT
            You are an advanced research assistant. Generate comprehensive research content for: "{$topic}"

            Context:
            - Academic Level: {$academicLevel}
            - Research Area: {$researchArea}
            - Keywords: {$keywords}
            - User: {$userContext}

            Requirements:
            - 10-15 literature, 10-15 links, 10-15 LinkedIn profiles, 5-10 video queries
            - All URLs must be real and valid.
            - linkedin profiles data & url should be public and real.

            Return ONLY a valid **raw JSON object** (no markdown, no explanation, no formatting). The output must contain the following **exact keys and structure**:
            {
                "content": "Detailed summary (2000+ words)...",
                "video_search_queries": ["Query 1", "Query 2"],
                "literature": [{
                "title": "Literature Title",
                "description": "Description (500-1000)",
                }],
                "links": [{
                "title": "Resource Title",
                "url": "https://example.com",
                "description": "Brief explanation",
                "type": "database / organization / tool",
                }],
                "linkedin_profiles": [{
                "name": "Expert Name",
                "title": "Position",
                "institution": "Organization",
                "linkedin_url": "https://www.google.com/search?q=site:linkedin.com/in+%22Expert+Name%22+%22Full+Professional+Title%22+%22Institution%22+location+keywords",
                "expertise": "Fields of knowledge",
                "background": "Professional experience",
                "relevance": "Why relevant for research",
                "contact_potential": "High / Medium / Low"
                }]
            }

            Requirements:
            - 10-15 literature, 10-15 links, 10-15 LinkedIn profiles, 5-10 video queries
            - All URLs must be real and valid.
            Note:
            - Do **not** include any extra text, explanations, markdown syntax, or comments. Only raw JSON should be returned.
            - Important: Output ONLY a pure JSON object. Do NOT wrap it in triple backticks, markdown, explanations, or tags.
            EOT;
    }

    // public function getFromGemini($prompt, $model = null)
    // {

    //     $model = $model ?: $this->geminiModels[0];

    //     try {
    //     $response = Http::timeout(90)
    //         ->withHeaders(['Content-Type' => 'application/json'])
    //         ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . env('GEMINI_API_KEY'), [
    //             "contents" => [["parts" => [["text" => $prompt]]]],
    //             "generationConfig" => ["temperature" => 0.7, "maxOutputTokens" => 8192],
    //         ]);

    //     if ($response->successful()) {
    //         return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
    //     }

    //     Log::error('Gemini Error', ['response' => $response->body()]);
    //     return null;
    //     } catch (\Exception $e) {
    //     Log::error('Unexpected error in getFromGemini', [
    //         'message' => $e->getMessage(),
    //         'code' => $e->getCode(),
    //     ]);
    //     return null;
    //     }
    // }

     public function getFromGemini($prompt, $model = null)
    {
        $model = $model ?: $this->geminiModels[0];

        // Register shutdown handler for fatal errors
        register_shutdown_function(function () {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                Log::error('Fatal error in getFromGemini', ['error' => $error]);
            }
        });

        try {
            // Increase time limit to reduce fatal error chance
            set_time_limit(120); 

            $response = Http::timeout(90)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . env('GEMINI_API_KEY'), [
                    "contents" => [["parts" => [["text" => $prompt]]]],
                    "generationConfig" => ["temperature" => 0.7, "maxOutputTokens" => 8192],
                ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }

            Log::error('Gemini API error response', ['status' => $response->status(), 'body' => $response->body()]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Exception in getFromGemini', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return null;
        }

        // Always return null in fallback (redundant but safe)
        return null;
    }

    public function getFromTogether($prompt, $model = null)
    {
        $model = $model ?: $this->togetherModels[0];
        $response = Http::timeout(90)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('TOGETHER_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post("https://api.together.xyz/v1/chat/completions", [
                "model" => $model,
                "messages" => [
                    ["role" => "system", "content" => "You are a research assistant..."],
                    ["role" => "user", "content" => $prompt],
                ],
                "temperature" => 0.7,
                "max_tokens" => 8192
            ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }

        Log::error('Together AI Error', ['response' => $response->body()]);
        return null;
    }

    public function getAiResponseWithFallback($prompt, $preferred = 'gemini')
    {
        $providers = ['gemini', 'together'];
        if (($key = array_search($preferred, $providers)) !== false) {
            unset($providers[$key]);
            array_unshift($providers, $preferred);
        }
        foreach ($providers as $provider) {
            $models = $provider === 'gemini' ? $this->geminiModels : $this->togetherModels;

            foreach (array_slice($models, 0, 2) as $model) {
                $content = $provider === 'gemini'
                    ? $this->getFromGemini($prompt, $model)
                    : $this->getFromTogether($prompt, $model);

                if ($content) {
                    return ['content' => $content, 'provider' => $provider, 'model' => $model];
                }
            }
        }

        return null;
    }

    // public function parseJsonResponse($text)
    // {
    //     try {
    //         $jsonStart = strpos($text, '{');
    //         $jsonEnd = strrpos($text, '}') + 1;
    //         $json = substr($text, $jsonStart, $jsonEnd - $jsonStart);
    //         return json_decode($json, true);
    //     } catch (\Throwable $e) {
    //         Log::error("JSON Parse Error", ['text' => $text, 'error' => $e->getMessage()]);
    //         return null;
    //     }
    // }

    function parseJsonResponse($response)
    {
        // Step 1: Clean up common wrapping artifacts (```json ... ```)
        $response = trim($response);

        // Remove wrapping ```json or ``` if present
        if (preg_match('/```(?:json)?\s*(.*?)```/is', $response, $matches)) {
            $response = $matches[1];
        }

        // Step 2: Remove any trailing non-JSON content (sometimes Gemini adds extra logs)
        $response = preg_replace('/^[^{\[]*/', '', $response); // Remove anything before JSON starts
        $response = preg_replace('/[^}\]]*$/', '', $response); // Remove anything after JSON ends

        // Step 3: Decode JSON safely
        $decoded = json_decode($response, true);

        // Step 4: Handle errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Optionally log: error_log("JSON Decode Error: " . json_last_error_msg());
            return null;
        }

        return $decoded;
    }

}
