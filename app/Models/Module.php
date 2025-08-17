<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'modules';
    protected $guarded = ['id'];

    public function moduleInstances(){
        return $this->hasMany(ModuleInstance::class);
    }

    public function users(){
       return $this->belongsToMany(UserSecondary::class, 'module_instances','module_id','user_id')
                    ->withTimestamps();
    }

    public function features()
    {
        return $this->hasMany(ModuleFeature::class, 'module_id');
    }

}
