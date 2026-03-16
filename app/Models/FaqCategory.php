<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(FaqCategory::class, 'parent_id');
    }

    // Child categories
    public function children()
    {
        return $this->hasMany(FaqCategory::class, 'parent_id');
    }

    // FAQs
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }
}
