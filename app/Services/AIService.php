<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AIService
{
    protected string $geminiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';
    // public function generateSlug($title)
    // {
    //     return Str::slug($title) . '-' . Str::random(5);
    // }

    // public function generateSummary($content)
    // {
    //     return substr(strip_tags($content), 0, 150) . '...';
    // }


    public function generateSlug(string $title, string $content): ?string
    {
        $prompt = "Generate a short, lowercase hyphenated slug for an article with the following:\n\nTitle: $title\n\nContent: $content\n\nSlug should not include special characters or numbers.";
        return $this->askGemini($prompt);
    }

    public function generateSummary(string $content): ?string
    {
        $prompt = "Write a short summary (2-3 sentences) for the following article content:\n\n$content";
        return $this->askGemini($prompt);
    }

    protected function askGemini(string $prompt): ?string
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->geminiEndpoint . '?key=' . env('GEMINI_API_KEY'), [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            $data = $response->json();

            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        } catch (\Throwable $e) {
            Log::error('Gemini 1.5 Flash API Error: ' . $e->getMessage());
            return null;
        }
    }
}

