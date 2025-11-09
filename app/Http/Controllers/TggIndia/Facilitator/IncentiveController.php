<?php

namespace App\Http\Controllers\TggIndia\Facilitator;

use App\Http\Controllers\Controller;
use App\Models\Incentive;
use Illuminate\Http\Request;

class IncentiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $incentives = Incentive::where('source_id',auth('web2')->id())->paginate(10);
        return view('tgg-india.facilitator.incentives.index', compact('incentives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
