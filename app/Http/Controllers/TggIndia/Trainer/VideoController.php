<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\FeatureLimit;
use App\Models\FeatureUsage;
use App\Models\Video;
use App\Services\AIService;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class videoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth('web2')->id();

        $videos = Video::whereHas('moduleInstance', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        })->latest()->paginate(5);
        $features = featureList();
        $feature_key = $features[2]['key'];
        $user = auth('web2')->user();
        $feature_usage = FeatureUsage::where('user_id', $user->id)->where('feature_key', $feature_key)->first();
        $feature_limit = FeatureLimit::where('feature_key', $feature_key)->first();

        $is_exceeded = false; // default

        if ($feature_limit) {
            $used_count = $feature_usage ? $feature_usage->count : 0;
            $is_exceeded = $used_count >= $feature_limit->free_limit ? true : false;
        }
        return view('tgg-india.trainer.videos.index', compact('videos', 'feature_usage', 'is_exceeded'));
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

        $features = featureList();
        $feature_key = $features[2]['key'];
        $user = auth('web2')->user();
        FeatureUsage::updateOrCreate(
            [
                'user_id'     => $user->id,
                'feature_key' => $feature_key,
            ],
            [
                'count' => \DB::raw('count + 1')
            ]
        );
        return redirect()->route('tgg-india.trainer.videos.index')
            ->with('success', 'Video created successfully.');
    }

    public function aigen(AIService $aiService, YouTubeService $yt)
    {
        $user = auth('web2')->user();

        // --- 1. AI Prompt to generate video search query ---
        $prompt = "Suggest an effective YouTube search query to find high-quality educational videos 
               for the module: {$user->modules[0]->name}.
               Respond in JSON with key: query.";

        $response = $aiService->getAiResponseWithFallback($prompt);

        if (!$response) {
            return back()->with('error', 'AI failed to generate query.');
        }

        $parsed = $aiService->parseJsonResponse($response['content']);

        if (!$parsed || !isset($parsed['query'])) {
            return back()->with('error', 'Invalid AI query response.');
        }

        $query = $parsed['query'];

        // --- 2. Fetch videos from YouTube API ---
        $videos = $yt->fetchVideos($query, 5);

        if (empty($videos)) {
            return back()->with('error', 'No YouTube videos found.');
        }

        // Pick first video
        $videoData = $videos[0];

        // --- 3. Get user module_instance ---
        $moduleInstance = $user->modules()->withPivot('id')->first();
        if (!$moduleInstance) {
            return back()->withErrors(['error' => 'No module instance found for this user.']);
        }

        // --- 4. Save video ---
        $video = Video::create([
            'title'              => $videoData['title'],
            'url'                => $videoData['url'],
            'description'        => $videoData['description'], // CKEditor-ready plain text
            'image'              => $videoData['thumbnail'],   // thumbnail into image column
            'module_instance_id' => $moduleInstance->pivot->id,
        ]);

        // --- 5. Track usage ---
        $features = featureList();
        $feature_key = $features[2]['key'] ?? 'videos_aigen';

        $usage = FeatureUsage::firstOrNew([
            'user_id'     => $user->id,
            'feature_key' => $feature_key,
        ]);
        $usage->count = ($usage->count ?? 0) + 1;
        $usage->save();

        return redirect()
            ->route('tgg-india.trainer.videos.index')
            ->with('success', 'AI Generated Video added successfully!');
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
