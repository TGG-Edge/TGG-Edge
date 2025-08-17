<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Literature extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'literatures';
    protected $guarded = ['id'];

    public function moduleInstance()
    {
        return $this->belongsTo(ModuleInstance::class, 'module_instance_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'literature_id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            UserSecondary::class,       // Final related model
            ModuleInstance::class,      // Intermediate model
            'id',                       // Foreign key on ModuleInstance table
            'id',                       // Foreign key on UserSecondary table
            'module_instance_id',       // Local key on Literature table
            'user_id'                   // Local key on ModuleInstance pivot
        );
    }
}
