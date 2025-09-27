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

    public function editWelcomeNotes()
    {
        $showcase = Showcase::first();
        return view('tgg-india.admin.showcase.welcome-notes', compact('showcase'));
    }

    public function editCollaborativeProjects()
    {
        $showcase = Showcase::first();
        return view('tgg-india.admin.showcase.collaborative-projects', compact('showcase'));
    }

    public function editMainProjects()
    {
        $showcase = Showcase::first();
        return view('tgg-india.admin.showcase.main-projects', compact('showcase'));
    }

    public function editFreelanceOpportunities()
    {
        $showcase = Showcase::first();
        return view('tgg-india.admin.showcase.freelance-opportunities', compact('showcase'));
    }


    // public function update(Request $request)
    // {
    //     $showcase = Showcase::first();

    //     // basic text fields
    //     $data = $request->only([
    //         'welcome_note',
    //         'welcome_note_trainer',
    //         'welcome_note_member',
    //         'welcome_note_rhm_club',
    //         'welcome_note_nomad_community',
    //         'welcome_note_freelancer',
    //     ]);

    //     // add partner single checkout notes (Modicare, Motilal)
    //     $data['modicare_checkout'] = $request->input('modicare_checkout');
    //     $data['motilal_checkout']  = $request->input('motilal_checkout');

    //     // Handle multiple comma-separated text fields
    //     foreach (['entrepreneurship_opportunities', 'tgg_news'] as $field) {
    //         $data[$field] = $request->input($field) ? array_values(array_filter(array_map('trim', explode(',', $request->input($field))))) : [];
    //     }
    //     // Freelancing opportunities
    //     $data['investment_opportunities'] = $request->input('investment_opportunities', []);

    //     // Fields that will now be stored as array of objects { img, note }
    //     $imageFields = ['woodpecker_collection', 'travel_and_events', 'tgg_homes', 'tgg_foundation'];

    //     foreach ($imageFields as $field) {
    //         $existing = [];

    //         // Existing items (hidden inputs that contain image path)
    //         if ($request->has("{$field}_existing")) {
    //             foreach ($request->input("{$field}_existing") as $i => $imgPath) {
    //                 // Skip if user marked it for removal
    //                 if ($request->has("remove_{$field}") && in_array($imgPath, $request->input("remove_{$field}"))) {
    //                     continue;
    //                 }
    //                 $note = $request->input("{$field}_notes")[$i] ?? '';
    //                 $link = ($field === 'tgg_foundation') ? ($request->input("{$field}_links")[$i] ?? '') : '';
    //                 $existing[] = [
    //                     'img' => $imgPath,
    //                     'note' => $note,
    //                     'link' => $link,
    //                 ];
    //             }
    //         }

    //         // New uploads (files) with new notes
    //         if ($request->hasFile($field)) {
    //             foreach ($request->file($field) as $i => $file) {
    //                 $path = $file->store('showcase', 'public');
    //                 $note = $request->input("{$field}_new_notes")[$i] ?? '';
    //                 $link = ($field === 'tgg_foundation') ? ($request->input("{$field}_new_links")[$i] ?? '') : '';
        
    //                 $existing[] = [
    //                     'img' => '/storage/' . $path,
    //                     'note' => $note,
    //                     'link' => $link,
    //                 ];
    //             }
    //         }

    //         // Backwards-compatibility: if no array built, check if DB already had string-array items
    //         if (empty($existing) && $showcase) {
    //             $current = $showcase->{$field} ?? null;
    //             if ($current && is_array($current)) {
    //                 // If current items are strings, convert to objects with empty note
    //                 foreach ($current as $item) {
    //                     if (is_string($item)) {
    //                         $existing[] = ['img' => $item, 'note' => ''];
    //                     } elseif (is_array($item) && isset($item['img'])) {
    //                         $existing[] = $item;
    //                     }
    //                 }
    //             }
    //         }

    //         $data[$field] = array_values($existing);
    //     }

    //     // Save
    //     if ($showcase) {
    //         $showcase->update($data);
    //     } else {
    //         $showcase = Showcase::create($data);
    //     }

    //     return redirect()->back()->with('success', 'Showcase updated successfully.');
    // }

    public function update(Request $request)
{
    $showcase = Showcase::first() ?? new Showcase();

    // Start with existing data so nothing is lost
    $data = $showcase->toArray();

    // ✅ Only overwrite if field is present in the request
    foreach ([
        'welcome_note',
        'welcome_note_trainer',
        'welcome_note_member',
        'welcome_note_rhm_club',
        'welcome_note_nomad_community',
        'welcome_note_freelancer',
        'modicare_checkout',
        'motilal_checkout',
    ] as $field) {
        if ($request->has($field)) {
            $data[$field] = $request->input($field);
        }
    }

    // ✅ Comma-separated fields
    foreach (['entrepreneurship_opportunities', 'tgg_news'] as $field) {
        if ($request->has($field)) {
            $data[$field] = $request->input($field)
                ? array_values(array_filter(array_map('trim', explode(',', $request->input($field)))))
                : [];
        }
    }

    // ✅ Freelancing opportunities
    if ($request->has('investment_opportunities')) {
        $data['investment_opportunities'] = $request->input('investment_opportunities', []);
    }

    // ✅ Image fields
    $imageFields = ['woodpecker_collection', 'travel_and_events', 'tgg_homes', 'tgg_foundation'];

    foreach ($imageFields as $field) {
        if ($request->has("{$field}_existing") || $request->hasFile($field)) {
            $existing = [];

            if ($request->has("{$field}_existing")) {
                foreach ($request->input("{$field}_existing") as $i => $imgPath) {
                    if ($request->has("remove_{$field}") && in_array($imgPath, $request->input("remove_{$field}"))) {
                        continue;
                    }
                    $note = $request->input("{$field}_notes")[$i] ?? '';
                    $link = ($field === 'tgg_foundation') ? ($request->input("{$field}_links")[$i] ?? '') : '';
                    $existing[] = [
                        'img' => $imgPath,
                        'note' => $note,
                        'link' => $link,
                    ];
                }
            }

            if ($request->hasFile($field)) {
                foreach ($request->file($field) as $i => $file) {
                    $path = $file->store('showcase', 'public');
                    $note = $request->input("{$field}_new_notes")[$i] ?? '';
                    $link = ($field === 'tgg_foundation') ? ($request->input("{$field}_new_links")[$i] ?? '') : '';
                    $existing[] = [
                        'img' => '/storage/' . $path,
                        'note' => $note,
                        'link' => $link,
                    ];
                }
            }

            $data[$field] = array_values($existing);
        }
    }

    // ✅ Save back
    $showcase->fill($data)->save();

    return redirect()->back()->with('success', 'Showcase updated successfully.');
}

}
