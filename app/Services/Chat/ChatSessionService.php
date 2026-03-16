<?php

namespace App\Services\Chat;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;

class ChatSessionService
{
    public function getOrCreate(string $sessionId, string $ip)
    {
        return ChatSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => Auth::id(),
                'ip' => $ip
            ]
        );
    }

    public function findBySessionId(string $sessionId)
    {
        return ChatSession::where('session_id', $sessionId)->first();
    }
}
