<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class videoController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('tgg-india.trainer.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        return view('tgg-india.trainer.videos.create');
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

        Video::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'module_instance_id' => 2, // Or set dynamically based on logged-in trainer
            'url' => '#',
        ]);

        return redirect()->route('tgg-india.trainer.videos.index')
                         ->with('success', 'Video created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        $videos = Video::paginate(5);
        return view('tgg-india.trainer.videos.show', compact('videos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('tgg-india.trainer.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $video = Video::findOrFail($id);
        $video->update($request->all());

        return redirect()->route('tgg-india.trainer.videos.index')
                         ->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Video::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.videos.index')
                         ->with('success', 'Video deleted successfully.');
    }
}
