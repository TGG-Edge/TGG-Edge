<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSecondary extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'projects';
    protected $guarded = ['id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function owner()
    {
        return $this->belongsTo(UserSecondary::class, 'owner_id');
    }

    public function creator()
    {
        return $this->belongsTo(UserSecondary::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(ProjectSecondaryUser::class, 'project_id');
    }

}
