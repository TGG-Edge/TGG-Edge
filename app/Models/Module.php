<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'modules';
    protected $guarded = ['id'];
}
