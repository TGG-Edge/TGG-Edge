<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showcase  extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];

   protected $casts = [
        'entrepreneurship_opportunities' => 'array',
        'woodpecker_collection' => 'array',
        'travel_and_events' => 'array',
        'tgg_homes' => 'array',
        'tgg_news' => 'array',
        'investment_opportunities' => 'array',
    ];
}
