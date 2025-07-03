<?php

namespace App\Traits;

use App\Models\AiResearchAssistance;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HandlesAiResearch
{
    public function generateResearchForUser($user)
    {
        if (!$user || empty($user->project)) {
            return ['success' => false, 'error' => 'Project information missing.'];
        }

        $prompt = $this->createPrompt($user);
        $aiResponse = $this->callAiApi($prompt);

        if (!$aiResponse['success']) {
            return ['success' => false, 'error' => $aiResponse['error']];
        }

        $store = AiResearchAssistance::create([
            'user_id'   => $user->id,
            'literature'=> json_encode($aiResponse['data']['literature']),
            'videos'    => json_encode($aiResponse['data']['videos']),
            'links'     => json_encode($aiResponse['data']['links']),
            'linkedin'  => json_encode($aiResponse['data']['linkedin_profiles']),
        ]);

        return ['success' => true, 'data' => $store];
    }

    private function createPrompt($user)
    {
        $project = $user->project;
        $academic_level = 'Graduate';
        $research_area = '';
        $keywords = '';
        $user_context = $user->name;

        return <<<EOT
            You are an advanced research assistant. Generate comprehensive research content for: "{$project}"

            Context:
            - Academic Level: {$academic_level}
            - Research Area: {$research_area}
            - Keywords: {$keywords}
            - User: {$user_context}

            Return ONLY a valid JSON object with these keys:
            {
                "literature": [...],
                "videos": [...],
                "links": [...],
                "linkedin_profiles": [...]
            }

            Requirements:
            - 8-10 items per list
            - Real accessible URLs
            - JSON only
            EOT;
    }

    // private function callAiApi($prompt)
    // {
    //     try {
    //         $response = Http::withToken('e92a90d4ebefc6be4da08b35deeab6593f3e84111fbae36219cb2415b8ad0be4')->post('https://api.together.xyz/v1/chat/completions', [
    //             'model' => 'deepseek-ai/DeepSeek-V3',
    //             'messages' => [
    //                 ['role' => 'system', 'content' => 'You are a research assistant that provides valid JSON only.'],
    //                 ['role' => 'user', 'content' => $prompt]
    //             ],
    //             'temperature' => 0.7,
    //             'max_tokens' => 4000,
    //         ]);

    //         if (!$response->ok()) return ['success' => false];

    //         $text = $response->json('choices')[0]['message']['content'] ?? '';
    //         $jsonStart = strpos($text, '{');
    //         $jsonEnd = strrpos($text, '}');

    //         if ($jsonStart !== false && $jsonEnd !== false) {
    //             $clean = substr($text, $jsonStart, $jsonEnd - $jsonStart + 1);
    //             $parsed = json_decode($clean, true);

    //             if (json_last_error() === JSON_ERROR_NONE) {
    //                 return [
    //                     'success' => true,
    //                     'data' => [
    //                         'literature' => $parsed['literature'] ?? [],
    //                         'videos' => $parsed['videos'] ?? [],
    //                         'links' => $parsed['links'] ?? [],
    //                         'linkedin_profiles' => $parsed['linkedin_profiles'] ?? [],
    //                     ]
    //                 ];
    //             }
    //         }

    //         return ['success' => false];

    //     } catch (\Exception $e) {
    //         Log::error('AI API call failed: ' . $e->getMessage());
    //         return ['success' => false,'error' => $e->getMessage()];
    //     }
    // }

    private function callAiApi($prompt)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer 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',
                ],
                'timeout' => 60, // adjust as needed
                'json' => [
                    'model' => 'deepseek/deepseek-r1:free',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ]
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                return ['success' => false];
            }

            $body = json_decode($response->getBody(), true);
            $text = $body['choices'][0]['message']['content'] ?? '';

            // Extract valid JSON from response
            $jsonStart = strpos($text, '{');
            $jsonEnd = strrpos($text, '}');

            if ($jsonStart !== false && $jsonEnd !== false) {
                $clean = substr($text, $jsonStart, $jsonEnd - $jsonStart + 1);
                $parsed = json_decode($clean, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'data' => [
                            'literature' => $parsed['literature'] ?? [],
                            'videos' => $parsed['videos'] ?? [],
                            'links' => $parsed['links'] ?? [],
                            'linkedin_profiles' => $parsed['linkedin_profiles'] ?? [],
                        ]
                    ];
                }
            }

            return ['success' => false];

        } catch (\Exception $e) {
            Log::error('OpenRouter AI API error: ' . $e->getMessage());
            return ['success' => false];
        }
    }

}
