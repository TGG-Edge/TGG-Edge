<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'literature_sections';
    protected $guarded = ['id'];

    public function literature()
    {
        return $this->belongsTo(Literature::class, 'literature_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'section_id');
    }
}
