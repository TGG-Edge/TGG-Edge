<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureUsage extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'feature_usage';
    protected $guarded = ['id'];

}
