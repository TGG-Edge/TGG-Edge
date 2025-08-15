<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleFeature extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'module_features';
    protected $guarded = ['id'];
}
