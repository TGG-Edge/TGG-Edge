<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

    protected $casts = [
        'payload' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(ChatSession::class);
    }
}
