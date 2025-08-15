<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Literature;
use Illuminate\Http\Request;

class LiteratureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $literatures = Literature::latest()->get();
        return view('tgg-india.trainer.literatures.index', compact('literatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('tgg-india.trainer.literatures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        ]);

        Literature::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'module_instance_id' => 2, // Or set dynamically based on logged-in trainer
        ]);

        return redirect()->route('tgg-india.trainer.literatures.index')
                         ->with('success', 'Literature created successfully.');
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
    public function edit($id)
    {
        $literature = Literature::findOrFail($id);
        return view('tgg-india.trainer.literatures.edit', compact('literature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $literature = Literature::findOrFail($id);
        $literature->update($request->all());

        return redirect()->route('tgg-india.trainer.literatures.index')
                         ->with('success', 'Literature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Literature::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.literatures.index')
                         ->with('success', 'Literature deleted successfully.');
    }
}
