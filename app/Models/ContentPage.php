<?php

namespace App\Models;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    //
    protected $connection = 'mysql2';
    protected $guarded = ['id'];
   
}
