<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::latest()->get();
        return view('tgg-india.trainer.links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('tgg-india.trainer.links.create');
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

        Link::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'module_instance_id' => 2, // Or set dynamically based on logged-in trainer
            'url' => '#',
        ]);

        return redirect()->route('tgg-india.trainer.links.index')
                         ->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $links = Link::paginate(5);
        return view('tgg-india.trainer.links.show', compact('links'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $link = Link::findOrFail($id);
        return view('tgg-india.trainer.links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $link = Link::findOrFail($id);
        $link->update($request->all());

        return redirect()->route('tgg-india.trainer.links.index')
                         ->with('success', 'Link updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Link::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.links.index')
                         ->with('success', 'Link deleted successfully.');
    }
}
