<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignCheckEmail extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

    protected $casts = [
        'format' => 'boolean',
        'domain' => 'boolean',
        'disposable' => 'boolean',
        'dns' => 'boolean',
        'whitelist' => 'boolean',
        'is_valid' => 'boolean',
        'payload' => 'array',
    ];
}
