<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Faq::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Faq::class, 'parent_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\UserSecondary::class, 'created_by');
    }
}
