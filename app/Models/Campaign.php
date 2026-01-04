<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    //
    protected $connection = 'mysql2';

    protected $fillable = [
        'template_id',
        'created_by',
        'payload',
        'type',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function recipients()
    {
        return $this->hasMany(CampaignRecipient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
