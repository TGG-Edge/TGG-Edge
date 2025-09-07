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

    public function member()
    {
        return $this->belongsTo(UserSecondary::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(UserSecondary::class, 'created_by');
    }
}
