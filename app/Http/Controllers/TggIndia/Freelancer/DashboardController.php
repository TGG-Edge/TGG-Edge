<?php

namespace App\Http\Controllers\TggIndia\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\ShowCase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $showcase = ShowCase::first();  
        return view('tgg-india.freelancer.dashboard', compact('showcase'));
    }
}
