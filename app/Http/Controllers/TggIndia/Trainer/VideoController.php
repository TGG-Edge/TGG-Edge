<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'url'         => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $user = auth('web2')->user();

        // Get the first assigned module_instance of this user
        $moduleInstance = $user->modules()
            ->withPivot('id') // ensure pivot id is loaded
            ->first();
        if (!$moduleInstance) {
            return back()->withErrors(['error' => 'No module instance found for this user.']);
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('videos', 'public');
        }

        Video::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'module_instance_id' => $moduleInstance->pivot->id, // Or set dynamically based on logged-in trainer
            'url' => $request->url ?? '#',
            'image'              => $imagePath,
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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $video = Video::findOrFail($id);

        // Handle image update
        $imagePath = $video->image; // keep old image if no new one uploaded
        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($video->image && Storage::disk('public')->exists($video->image)) {
                Storage::disk('public')->delete($video->image);
            }
            // upload new one
            $imagePath = $request->file('image')->store('videos', 'public');
        }

        // Update only safe fields
        $video->update([
            'title'       => $request->title,
            'description' => $request->description,
            'url'         => $request->url ?? '#',
            'image'       => $imagePath,
        ]);

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
