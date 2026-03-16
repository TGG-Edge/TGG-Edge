<?php
namespace App\Services\Chat;

use App\Models\ChatMessage;

class ChatMessageService
{
    public function store(array $data)
    {
        return ChatMessage::create($data);
    }
}
