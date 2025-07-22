<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $guarded = ['id'];

    public function researcher() {
        return $this->belongsTo(User::class, 'researcher_id', 'id');
    }

    // 2. A Project HAS MANY volunteer collaborations
    public function collaborations() {
        return $this->hasMany(ProjectCollaboration::class, 'project_id', 'id');
    }
}
