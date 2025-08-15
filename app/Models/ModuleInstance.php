<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleInstance extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'module_instances';
    protected $guarded = ['id'];
}
