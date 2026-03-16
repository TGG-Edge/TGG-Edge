<?php

namespace App\Services\Chat\AI;

use Illuminate\Support\Facades\Http;

class GeminiService implements AIInterface
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        // $this->apiKey = env('GEMINI_API_KEY', 'AIzaSyCgTwy4OG2TsA3ifd9HYS-53GXEnigTxBM');
        // $this->model  = env('GEMINI_MODEL', 'gemini-1.5-flash');
        $this->apiKey =  env('GEMINI_API_KEY');
        $this->model  =  'gemini-2.5-flash';
    }

    public function reply(string $question, array $context = []): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        $response = Http::post(
            $url . '?key=' . $this->apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $this->buildPrompt($question, $context)]
                        ]
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
            return $response;
        }

        return $response->json('candidates.0.content.parts.0.text')
            ?? 'No response from AI.';
    }

    protected function buildPrompt(string $question,  $context): string
    {
        if (empty($context)) {
            return $question;
        }

        return "Context:\n"
            . json_encode($context, JSON_PRETTY_PRINT)
            . "\n\nUser Question:\n"
            . $question;
    }


    public function isRelated(string $question, string $context = ''): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        $response = Http::post(
            $url . '?key=' . $this->apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $this->buildPrompt($question, $context)]
                        ]
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
            return $response;
        }

        return $response->json('candidates.0.content.parts.0.text')
            ?? 'No response from AI.';
    }
}
