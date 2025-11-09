<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetailSecondary extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'user_bank_details';

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'bank_document',
    ];

    public function user()
    {
        return $this->belongsTo(UserSecondary::class, 'user_id');
    }
}
