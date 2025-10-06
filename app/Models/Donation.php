<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
    public function referrerUser()
    {
        return $this->belongsTo(UserSecondary::class, 'referrer_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(UserSecondary::class, 'referred_id');
    }

}
