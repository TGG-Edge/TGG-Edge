<?php

namespace App\Http\Controllers\TggIndia\Facilitator;

use App\Http\Controllers\Controller;
use App\Models\ShowCase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $showcase = ShowCase::first();  
        return view('tgg-india.facilitator.dashboard', compact('showcase'));
    }
}
