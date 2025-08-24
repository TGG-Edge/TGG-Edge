<?php

namespace App\Http\Controllers\TggIndia\Member;

use App\Http\Controllers\Controller;
use App\Models\ShowCase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $showcase = ShowCase::first();  
        return view('tgg-india.member.dashboard', compact('showcase'));
    }
}
