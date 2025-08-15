<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'literature_chapters';
    protected $guarded = ['id'];
}
