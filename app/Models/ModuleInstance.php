<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleInstance extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'module_instances';
    protected $guarded = ['id'];

     public function module()
    {
        return $this->belongsTo(Module::class);
    }

    // Each instance belongs to a user
    public function user()
    {
        return $this->belongsTo(UserSecondary::class);
    }   

     public function literatures()
    {
        return $this->hasMany(Literature::class, 'module_instance_id');
    }
}
