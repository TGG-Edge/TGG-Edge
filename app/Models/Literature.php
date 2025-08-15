<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Literature extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'literatures';
    protected $guarded = ['id'];
}
