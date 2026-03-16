<?php
namespace App\Services\Chat\AI;

interface AIInterface
{
    public function reply(string $question, array $context = []): string;
}