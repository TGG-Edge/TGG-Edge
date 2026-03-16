<?php

namespace App\Services\Chat\AI;

class OpenAIService implements AIInterface
{
    public function reply(string $question, array $context = []): string
    {
        // Example only (pseudo)
        return "This is an AI-generated answer related to your system.";
    }
}
