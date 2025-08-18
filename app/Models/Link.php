<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'links';
    protected $guarded = ['id'];

   
}
