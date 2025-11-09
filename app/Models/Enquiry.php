<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
    public function referrer()
    {
        return $this->belongsTo(UserSecondary::class, 'referral_code', 'referral_code');
    }
}
