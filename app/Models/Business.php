<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

     public function owner()
    {
        return $this->belongsTo(UserSecondary::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(UserSecondary::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(UserSecondary::class, 'updated_by');
    }

    public function assignments()
    {
        return $this->hasMany(AssignmentSecondary::class, 'business_id');
    }
    
}
