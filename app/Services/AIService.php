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

            Return ONLY a valid JSON object with these exact keys:
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
                "linkedin_url": "https://linkedin.com/in/username",
                "expertise": "Fields of knowledge",
                "background": "Professional experience",
                "relevance": "Why relevant for research",
                "contact_potential": "High / Medium / Low"
                }]
            }

            Requirements:
            - 8-10 literature, 8-10 links, 6-8 LinkedIn profiles, 3-5 video queries
            - Use real URLs
            - Return JSON only
            EOT;
    }

    public function getFromGemini($prompt, $model = null)
    {
        $model = $model ?: $this->geminiModels[0];
        $response = Http::timeout(90)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . env('GEMINI_API_KEY'), [
                "contents" => [["parts" => [["text" => $prompt]]]],
                "generationConfig" => ["temperature" => 0.7, "maxOutputTokens" => 8192],
            ]);

        if ($response->successful()) {
            return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
        }

        Log::error('Gemini Error', ['response' => $response->body()]);
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

    public function parseJsonResponse($text)
    {
        try {
            $jsonStart = strpos($text, '{');
            $jsonEnd = strrpos($text, '}') + 1;
            $json = substr($text, $jsonStart, $jsonEnd - $jsonStart);
            return json_decode($json, true);
        } catch (\Throwable $e) {
            Log::error("JSON Parse Error", ['text' => $text, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
