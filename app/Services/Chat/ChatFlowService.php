<?php
namespace App\Services\Chat;

use App\Services\Chat\AI\AIInterface;

class ChatFlowService
{
    public function handleOtherTalk( string $question,QuestionFilterService $filter,  AIInterface $ai, array $context = []): string {
        
        // if (!$filter->isRelated($question)) {
        //     return "❌ This question is not related to our system. Please ask something relevant.";
        // }

        return $ai->reply($question,$context);
    }
}
