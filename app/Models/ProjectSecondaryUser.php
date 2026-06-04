<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSecondaryUser extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'project_users';
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(UserSecondary::class);
    }

    public function assigner()
    {
        return $this->belongsTo(UserSecondary::class, 'assigned_by');
    }
}
