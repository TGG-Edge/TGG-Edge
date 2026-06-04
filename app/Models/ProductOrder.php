<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

     public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(UserSecondary::class, 'user_id');
    }
}