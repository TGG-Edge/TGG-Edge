<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\ShowCase;
use App\Models\User;
use App\Models\UserSecondary;
use App\Services\AIService;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use App\Traits\HandlesAiResearch;


class ShowCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HandlesAiResearch;
   public function edit()
    {
        $showcase = Showcase::first(); // always first row
        return view('tgg-india.admin.showcase', compact('showcase'));
    }

   public function update(Request $request)
{
    $showcase = Showcase::first();

    $data = $request->only(['welcome_note']);

    // Handle multiple text-based fields
    foreach (['entrepreneurship_opportunities','tgg_news','investment_opportunities'] as $field) {
        $data[$field] = $request->$field ? explode(',', $request->$field) : [];
    }

    // Handle file uploads for image fields
    foreach (['woodpecker_collection','travel_and_events','tgg_homes'] as $field) {
        $existing = $showcase->$field ?? [];

        // Remove selected images
        if ($request->has("remove_$field")) {
            $removeImages = $request->input("remove_$field");
            $existing = array_diff($existing, $removeImages);
        }

        // Upload new files
        if ($request->hasFile($field)) {
            foreach ($request->file($field) as $file) {
                $path = $file->store('showcase', 'public');
                $existing[] = '/storage/' . $path;
            }
        }

        $data[$field] = array_values($existing); // reindex
    }

    $showcase->update($data);

    return redirect()->route('tgg-india.admin.showcases.edit')->with('success', 'Showcase updated successfully.');
}



}
