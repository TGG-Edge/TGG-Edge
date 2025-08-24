<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'videos';
    protected $guarded = ['id'];

       public function moduleInstance()
    {
        return $this->belongsTo(ModuleInstance::class, 'module_instance_id');
    }

}
