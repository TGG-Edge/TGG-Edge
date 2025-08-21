<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureLimit extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'feature_limits';
    protected $guarded = ['id'];
}
