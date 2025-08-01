<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\User;
use App\Services\AIService;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use App\Traits\HandlesAiResearch;


class UserApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HandlesAiResearch;

    public function index()
    {
        $users = User::where('user_role', 2)->latest()->paginate(5);
        return view('user.user-approval', compact('users'));
    }

    public function  newApplication()
    {
        $newApplications = User::whereIn('user_role', [2,3])->where('approval','pending')->latest()->paginate(10);
        return view('user.applications.new-application', compact('newApplications'));
    }

    public function processedApplication()
    {
       $processedApplications = User::whereIn('user_role', [2,3])->where('approval','!=','pending')->latest()->paginate(10);
        return view('user.applications.processed-application', compact('processedApplications'));
    }

    public function userProfile(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        return view('user.user-profile', compact('user'));
    }

    public function updateApproval(Request $request, $id, AIService $aiService, YouTubeService $yt)
    {
        

        $user = User::findOrFail($id);
        $message = "";

        if( $request->action == 'accepted' && $user->approval !== 'accepted'){
            $topic =$user->project;
            $academicLevel =  'Graduate';
            $prompt = $aiService->createPrompt($topic, $academicLevel);
            $response = $aiService->getAiResponseWithFallback($prompt);
            if (!$response) {
                return back()->with('success', 'AI failed to generate content, Please try again.');
                // return response()->json(['success' => false, 'error' => 'AI failed'], 500);
            }
            $parsed = $aiService->parseJsonResponse($response['content']);
            // return      $parsed;
            if($parsed == NULL) {
                return back()->with('success', 'AI failed to generate parse data, Please try again.');
                // return response()->json(['success' => false, 'error' => 'AI response failed'], 500);
            }

            $videos = [];
            foreach ($parsed['video_search_queries'] ?? [] as $query) {
                $videos = array_merge($videos, $yt->fetchVideos($query));
            }

            $parsed['videos'] = array_slice($videos, 0, 10);

            
            $ai_research_assistance_store = AiResearchAssistance::create([
            'user_id'   => $user->id,
            'literature'=> json_encode($parsed['literature']),
            'videos'    => json_encode($parsed['videos']),
            'links'     => json_encode($parsed['links']),
            'linkedin'  => json_encode($parsed['linkedin_profiles']),
            ]);

            $message = " And Research Assistance Contents Generated";

            // $result = $this->generateResearchForUser($user); // ✅ Call from Trait
            // if (!$result['success']) {
            //     return back()->with('error', 'User approved, but AI generation failed: ' . ($result['error'] ?? 'Unknown error'));
            // }
        }

        $user->approval = $request->action;
        $user->save();

        return back()->with('success', 'User '.$request->action.' status updated.' . $message);
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'project' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->project = $request->project;
        $user->save();

        return back()->with('success', 'Project details updated.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
