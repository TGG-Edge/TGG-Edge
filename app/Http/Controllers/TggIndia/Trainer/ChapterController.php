<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\FeatureLimit;
use App\Models\FeatureUsage;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chapters = Chapter::latest();

        if ($request->has('section_id') && !empty($request->section_id)) {
            $chapters->where('section_id', $request->section_id);
        }

        $chapters = $chapters->get();

        $features = featureList();
        $feature_key = $features[0]['key'];
        $user = auth('web2')->user();
        $feature_usage = FeatureUsage::where('user_id',$user->id)->where('feature_key',$feature_key)->first();
        $feature_limit = FeatureLimit::where('feature_key', $feature_key)->first();

        $is_exceeded = false; // default

        if ($feature_limit) {
            $used_count = $feature_usage ? $feature_usage->count : 0;
            $is_exceeded = $used_count >= $feature_limit->free_limit ? true : false;
        }
        return view('tgg-india.trainer.chapters.index', compact('chapters','feature_usage','is_exceeded'));
    }

    public function create()
    {
        return view('tgg-india.trainer.chapters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'section_id' => 'required',
        ]);

        Chapter::create($request->all());

        $features = featureList();
        $feature_key = $features[0]['key'];
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



        return redirect()->route('tgg-india.trainer.chapters.index', ['section_id' =>  $request->section_id])
            ->with('success', 'Chapter created successfully.');
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('tgg-india.trainer.chapters.edit', compact('chapter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'section_id' => 'required',
        ]);

        $chapter = Chapter::findOrFail($id);
        $chapter->update($request->all());

        return redirect()->route('tgg-india.trainer.chapters.index')
            ->with('success', 'Chapter updated successfully.');
    }

    public function destroy($id)
    {
        Chapter::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.chapters.index')
            ->with('success', 'Chapter deleted successfully.');
    }

    public function show(Chapter $chapter)
    {
        // Eager load section and literature
        $chapter->load('section.literature');

        return view('tgg-india.trainer.chapters.show', compact('chapter'));
    }
}
