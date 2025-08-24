<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\FeatureLimit;
use App\Models\FeatureUsage;
use App\Models\Link;
use App\Services\AIService;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user_id = auth('web2')->id();

    $links = Link::whereHas('moduleInstance', function ($q) use ($user_id) {
        $q->where('user_id', $user_id);
    })->latest()->paginate(5);
        $features = featureList();
        $feature_key = $features[1]['key'];
        $user = auth('web2')->user();
        $feature_usage = FeatureUsage::where('user_id', $user->id)->where('feature_key', $feature_key)->first();
        $feature_limit = FeatureLimit::where('feature_key', $feature_key)->first();

        $is_exceeded = false; // default

        if ($feature_limit) {
            $used_count = $feature_usage ? $feature_usage->count : 0;
            $is_exceeded = $used_count >= $feature_limit->free_limit ? true : false;
        }
        return view('tgg-india.trainer.links.index', compact('links', 'feature_usage', 'is_exceeded'));
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


        $user = auth('web2')->user();

        // Get the first assigned module_instance of this user
        $moduleInstance = $user->modules()
            ->withPivot('id') // ensure pivot id is loaded
            ->first();
        if (!$moduleInstance) {
            return back()->withErrors(['error' => 'No module instance found for this user.']);
        }

        Link::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'module_instance_id' => $moduleInstance->pivot->id, // Or set dynamically based on logged-in trainer
            'url' => $request->url,
        ]);

        $features = featureList();
        $feature_key = $features[1]['key'];
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

    public function aigen(AIService $aiService)
    {
        $user = auth('web2')->user();

        // Prompt for AI
        $prompt = "Generate a useful resource link for {$user->modules[0]->name}. 
               Respond in JSON format with keys: 
               - title: short and clear title of the resource
               - url: a realistic learning resource URL
               - description: detailed HTML content compatible with CKEditor, 
                              including <p>, <ul>, <ol>, <strong>, <em>, etc. 
                              Optionally include one relevant <img> tag with a free-to-use image.";

        // Get AI response
        $response = $aiService->getAiResponseWithFallback($prompt);

        if (!$response) {
            return back()->with('error', 'AI failed to generate link.');
        }

        $parsed = $aiService->parseJsonResponse($response['content']);

        if (!$parsed || !isset($parsed['title'], $parsed['url'], $parsed['description'])) {
            return back()->with('error', 'Invalid AI response.');
        }

        // Get the first assigned module_instance of this user
        $moduleInstance = $user->modules()->withPivot('id')->first();
        if (!$moduleInstance) {
            return back()->withErrors(['error' => 'No module instance found for this user.']);
        }

        // Save new Link with CKEditor-compatible content
        $link = Link::create([
            'title'              => $parsed['title'],
            'url'                => $parsed['url'],
            'description'        => $parsed['description'], // rich HTML for CKEditor
            'module_instance_id' => $moduleInstance->pivot->id,
        ]);

        // Track usage
        $features = featureList();
        $feature_key = $features[1]['key'] ?? 'links'; // safe fallback

        $usage = FeatureUsage::firstOrNew([
            'user_id'     => $user->id,
            'feature_key' => $feature_key,
        ]);

        $usage->count = ($usage->count ?? 0) + 1;
        $usage->save();

        return redirect()
            ->route('tgg-india.trainer.links.index')
            ->with('success', 'AI Generated Link added successfully!');
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
