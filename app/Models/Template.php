<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
    protected $casts = [
        'content' => 'array',
    ];

}
