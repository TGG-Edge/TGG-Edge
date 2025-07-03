<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait GeneratesDeepSeekResponse
{
    public function DSResponse($test)
    {
        $client = new Client();
        $timeout = 120;

        $subject = $test->subject;
        $topic = $test->topic;
        $number_of_questions = $test->number_of_questions;
        $language = $test->language;
        $level = $test->level;

         $prompt = "I am preparing for the MP PNST exam and need a high-quality practice test in {$subject}, specifically focused on the topic {$topic}.\n\n" .
              "Please generate { $number_of_questions } multiple-choice questions (MCQs) in {$language}, targeting a hard difficulty { $level}, based on actual exam trends. " .
              "Prioritize previously asked questions and those with a high likelihood of appearing in upcoming exams.\n\n" .
              "🔹 Instructions for Output:\n\n" .
              "Output should only be a clean array.\n\n" .
              "Each question should include:\n\n" .
              "question\n\n" .
              "options (a, b, c, d)\n\n" .
              "answer (correct option letter)\n\n" .
              "explanation (explanation of currect answer under 10-100 words)\n\n" .
              "Do not include any explanation or extra text outside the array.\n\n" .
              "Output format:\n" .
              "[\n" .
              "    [\n" .
              "        \"question\" => \"______\",\n" .
              "        \"options\" => [\"...\", \"...\", \"...\", \"...\"],\n" .
              "        \"answer\" => \"a\"\n" .
              "        \"explanation\" => \"______\",\n" .
              "    ],\n" .
              "    ...\n" .
              "]";

        $response = $client->post('https://openrouter.ai/api/v1/chat/completions', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer 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',
            ],
            'timeout' => $timeout,
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

        $result = json_decode($response->getBody(), true);

        // Extract content from the first message of the response
        $content = $result['choices'][0]['message']['content'] ?? '[]';

        return $content;
    }
}
