<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\ContentPage;
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

    public function editReferral()
    {
        $content = ContentPage::where('source_type', 'referral')->first();
        $source_type = 'referral';
        return view('tgg-india.admin.showcase.referral', compact('content', 'source_type'));
    }

    public function editReferralDescription($user_role = null)
    {
        $source_type = 'referral-description';
        if($user_role != 'admin'){
         $source_type = $user_role.'-referral-description';
        }
        $content = ContentPage::where('source_type',  $source_type)->first();
        // if($user_role != 'admin'){
        //     return view('tgg-india.' . $user_role . '.showcase.referral', compact('content', 'source_type'));
        // }else{
            return view('tgg-india.admin.showcase.referral', compact('content', 'source_type'));
        // }
    }

    public function editReferralLink($user_role = null)
    {
        $source_type = 'referral-link';
        if($user_role != 'admin'){
         $source_type = $user_role.'-referral-link';
        }
        $content = ContentPage::where('source_type',  $source_type)->first();
        // if($user_role != 'admin'){
        //     return view('tgg-india.' . $user_role . '.showcase.referral', compact('content', 'source_type'));
        // }else{
            return view('tgg-india.admin.showcase.referral-link', compact('content', 'source_type'));
        // }
    }

    public function editReward()
    {
        $content = ContentPage::where('source_type', 'reward')->first();
        $source_type = 'reward';
        return view('tgg-india.admin.showcase.reward', compact('content', 'source_type'));
    }

    public function editLeadReferral()
    {
        $content = ContentPage::where('source_type', 'lead-referral')->first();
        $source_type = 'lead-referral';
        return view('tgg-india.admin.showcase.lead-referral', compact('content', 'source_type'));
    }

    public function editSpouseReferral()
    {
        $content = ContentPage::where('source_type', 'spouse-referral')->first();
        $source_type = 'spouse-referral';
        return view('tgg-india.admin.showcase.spouse-referral', compact('content', 'source_type'));
    }

    
    public function editFreelancerReferral()
    {
        $content = ContentPage::where('source_type', 'freelancer-referral')->first();
        $source_type = 'freelancer-referral';
        return view('tgg-india.admin.showcase.freelancer-referral', compact('content', 'source_type'));
    }


   public function updateContent(Request $request, $source_type)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'min_size'  => 'nullable|integer',
            'max_size'  => 'nullable|integer',
        ]);

        // Generate slug if empty
        $slug = $validated['slug'] ?? \Str::slug($validated['title']);

        // Try to find existing record by slug
        $content = ContentPage::where('source_type', $source_type)->first();

        if ($content) {

            // ✅ Update existing
            $content->update([
                'title'     => $validated['title'],
                'content'   => $validated['content'],
                'min_size'  => $validated['min_size'] ?? 0,
                'max_size'  => $validated['max_size'] ?? 0,
            ]);

        } else {
            // ✅ Create new
            $content = ContentPage::create([
                'title'     => $validated['title'],
                'slug'      => $slug,
                'content'   => $validated['content'],
                'min_size'  => $validated['min_size'] ?? 0,
                'max_size'  => $validated['max_size'] ?? 0,
                'created_by'=> auth('web2')->id(),
                'source_type' => $source_type,
            ]);
        }

        return redirect()->back()->with('success', ucfirst($source_type) . ' content updated successfully.');
    }



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
            'welcome_note_facilitator',
            'welcome_note_rhm_club',
            'welcome_note_nomad_community',
            'welcome_note_freelancer',
            'welcome_note_spouse',
            'modicare_checkout',
            'motilal_checkout',
            'india_insure_checkout',
            'tgg_foundation_checkout',
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
