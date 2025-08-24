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
   public function edit($section)
    {
        $showcase = Showcase::firstOrCreate(['id' => 1]); // Always use single row

        return view('tgg-india.admin.showcase', compact('showcase', 'section'));
    }

    public function update(Request $request, $section)
    {
        $showcase = Showcase::firstOrCreate(['id' => 1]);

        switch ($section) {
            case 'welcome_note':
                $showcase->update(['welcome_note' => $request->welcome_note]);
                break;

            case 'entrepreneurship':
                $showcase->update(['entrepreneurship_opportunities' => $request->entrepreneurship_opportunities]);
                break;

            case 'woodpecker':
                $showcase->update(['woodpecker_collection' => $request->woodpecker_collection]);
                break;

            case 'travel':
                $showcase->update(['travel_and_events' => $request->travel_and_events]);
                break;

            case 'homes':
                $showcase->update(['tgg_homes' => $request->tgg_homes]);
                break;

            case 'news':
                $showcase->update(['tgg_news' => $request->tgg_news]);
                break;

            case 'investment':
                $showcase->update(['investment_opportunities' => $request->investment_opportunities]);
                break;
        }

        return redirect()->back()->with('success', ucfirst($section) . ' updated successfully!');
    }

}
