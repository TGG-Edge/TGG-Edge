<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIdProofSecondary extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'user_id_proofs';

    protected $fillable = [
        'user_id',
        'id_proof_type',
        'id_proof_number',
        'id_proof_file',
    ];

    public function user()
    {
        return $this->belongsTo(UserSecondary::class, 'user_id');
    }
}

