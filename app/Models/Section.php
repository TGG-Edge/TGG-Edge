<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'literature_sections';
    protected $guarded = ['id'];
}
