<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql2';
    protected $guarded = ['id'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(ProductOrder::class);
    }

     public function user()
    {
        return $this->belongsTo(UserSecondary::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(ProductOrder::class);
    }
}