<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSecondary extends Model
{
    //
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'assignments';
    protected $guarded = ['id'];

    public function associate()
    {
        return $this->belongsTo(UserSecondary::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(UserSecondary::class, 'created_by');
    }

     public function parent()
    {
        return $this->belongsTo(Assignment::class, 'parent_id');
    }

    
     public function children()
    {
        return $this->hasMany(Assignment::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
