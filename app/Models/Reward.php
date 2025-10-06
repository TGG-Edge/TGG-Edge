<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
    public function referrer()
    {
        return $this->belongsTo(UserSecondary::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(UserSecondary::class, 'referred_id');
    }

}
