<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
     protected $casts = [
        'items' => 'array',
        'payload' => 'array',
    ];


    public function source()
    {
        return $this->belongsTo(UserSecondary::class, 'source_id');
    }

    public function target()
    {
        return $this->belongsTo(UserSecondary::class, 'target_id');
    }

    public function model()
    {
        return $this->morphTo();
    }

}
