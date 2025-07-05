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
        $research_area = ''; // Optional: set dynamically
        $keywords = '';      // Optional: set dynamically
        $user_id = $user->id;
        $user_name = $user->name;

        return <<<EOT
            You are a smart AI research assistant. Generate useful research content for the topic: "{$project}"

            This request is associated with the user: {User ID: $user_id | User Name: $user_name}. Generate a unique research output for this user every time, ensuring that the response varies even when the base topic remains the same

            Return only a valid JSON object with the following structure:

            {
            "literature": [
                {
                "title": "Literature Title",
                "description": "Description (500-1000)",
                }
            ],
            "videos": [
                {
                "title": "Video Title",
                "channel": "YouTube Channel Name",
                "url": "Video Url [https://youtu.be/DxXo4x2lp94?feature=shared]",
                "thumbnail": "Thumbnail Url",
                "description": "Short summary",
                "duration": "Estimated duration",
                }
            ],
            "links": [
                {
                "title": "Resource Title",
                "url": "https://example.com",
                "description": "Brief explanation",
                "type": "database / organization / tool",
                }
            ],
            "linkedin_profiles": [
                {
                "name": "Expert Name",
                "title": "Position",
                "institution": "Organization",
                "linkedin_url": "https://linkedin.com/in/username",
                "expertise": "Fields of knowledge",
                "background": "Professional experience",
                "contact_potential": "High / Medium / Low"
                }
            ]
            }

            Requirements:
            - Include 1 to 2 items in each section.
            - All URLs must be real and working.
            - Return only the JSON. No extra text.
            EOT;
    }

    // private function callAiApi($prompt)
    // {
    //     try {
    //         $client = new \GuzzleHttp\Client();

    //         $response = $client->post('https://api.together.xyz/v1/chat/completions', [
    //             'headers' => [
    //                 'Content-Type'  => 'application/json',
    //                 'Authorization' => #,
    //             ],
    //             'timeout' => 240, // adjust as needed
    //             'json' => [
    //                 'model' => 'deepseek-ai/DeepSeek-V3',
    //                 'messages' => [
    //                     [
    //                         'role' => 'user',
    //                         'content' => $prompt
    //                     ]
    //                 ]
    //             ]
    //         ]);

    //         if ($response->getStatusCode() !== 200) {
    //             return ['success' => false,'error' => 'okagt'];
    //         }

    //         $body = json_decode($response->getBody(), true);
    //         $text = $body['choices'][0]['message']['content'] ?? '';

    //         // Extract valid JSON from response
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

    //         return ['success' => false,'error' =>  $jsonStart.$jsonEnd];

    //     } catch (\Exception $e) {
    //         Log::error('OpenRouter AI API error: ' . $e->getMessage());
    //         return ['success' => false,'error' => $e->getMessage()];
    //     }
    // }



    private function callAiApi($prompt)
    {
        try {
            return 'https://generativelanguage.googleapis.com/v1beta';
            $client = new \GuzzleHttp\Client();

            $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', [
                'headers' => [
                    'Content-Type'    => 'application/json',
                    'X-goog-api-key'  => env('GEMINI_API_KEY'),

                ],
                'timeout' => 240,
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                return ['success' => false, 'error' => 'Unexpected status code'];
            }

            $body = json_decode($response->getBody(), true);
            $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Optional JSON extraction from AI response
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

            return ['success' => true, 'data' => ['raw' => $text]];

        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

}
