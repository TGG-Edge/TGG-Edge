<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCollaboration extends Model
{
    //
    protected $guarded = ['id'];

    public function volunteer() {
    return $this->belongsTo(User::class, 'volunteer_id', 'id');
    }

    // 2. A collaboration BELONGS TO one project
    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
