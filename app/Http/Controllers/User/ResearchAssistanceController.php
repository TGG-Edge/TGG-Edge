<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\CollectionPaginationService;

use App\Services\AIService;
use App\Services\YoutubeService;

class ResearchAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

    public function literature(CollectionPaginationService $paginationService)
    {
        $data = AiResearchAssistance::where('user_id', Auth::id())->latest()->first();
        $literatureArray = json_decode($data->literature ?? '[]', true);

        $literature = $paginationService->paginate($literatureArray, 5);
        return view('user.research-assistance.literature', compact('literature'));
    }

    public function videos(CollectionPaginationService $paginationService)
    {
        $data = AiResearchAssistance::where('user_id', Auth::id())->latest()->first();
        $videoArray = json_decode($data->videos ?? '[]', true);

        $videos = $paginationService->paginate($videoArray, 5);

        return view('user.research-assistance.videos', compact('videos'));
    }

    public function links(CollectionPaginationService $paginationService)
    {
        $data = AiResearchAssistance::where('user_id', Auth::id())->latest()->first();
        $linkArray = json_decode($data->links ?? '[]', true);

        $links = $paginationService->paginate($linkArray, 5); // Adjust per-page as needed

        return view('user.research-assistance.links', compact('links'));
    }

    public function linkedin(CollectionPaginationService $paginationService)
    {
        $data = AiResearchAssistance::where('user_id', Auth::id())->latest()->first();
        $linkedinArray = json_decode($data->linkedin ?? '[]', true);

        $linkedin = $paginationService->paginate($linkedinArray, 5); // Change 10 to your preferred per-page count

        return view('user.research-assistance.linkedin', compact('linkedin'));
    }
    
    public function index()
    {
        //
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


    public function generate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        if (!$user || empty($user->project)) {
            return response()->json(['success' => false, 'error' => 'Project information missing.'], 400);
        }

        $prompt = $this->createPrompt($user);

        $aiResponse = $this->callAiApi($prompt);

        if (!$aiResponse['success']) {
            return response()->json(['success' => false, 'error' => 'AI response failed'], 500);
        }

        // Store in DB
        $store = AiResearchAssistance::create([
            'user_id' => $user->id,
            'literature' => json_encode($aiResponse['data']['literature']),
            'videos'     => json_encode($aiResponse['data']['videos']),
            'links'      => json_encode($aiResponse['data']['links']),
            'linkedin'   => json_encode($aiResponse['data']['linkedin_profiles']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'AI research stored successfully.',
            'data' => $store
        ]);
    }

    private function createPrompt($user)
    {
        $project = $user->project;
        $academic_level = 'Graduate';
        $research_area = '';
        $keywords = '';
        $user_context = $user->name;

        return `You are an advanced research assistant. Generate comprehensive research content for: \"$project\"

        Context:
        - Academic Level: $academic_level
        - Research Area: $research_area
        - Keywords: $keywords
        - User: $user_context

        Return ONLY a valid JSON object with these keys:
        {
            \"literature\": [...],
            \"videos\": [...],
            \"links\": [...],
            \"linkedin_profiles\": [...]
        }

        Requirements:
        - 8-10 items per list (literature, videos, links)
        - 6-8 linkedin_profiles
        - Real accessible URLs
        - Return ONLY JSON
        `;
    }

    private function callAiApi($prompt)
    {
        try {
            $response = Http::withToken(env('TOGETHER_API_KEY'))->post('https://api.together.xyz/v1/chat/completions', [
                'model' => 'deepseek-ai/DeepSeek-V3',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a research assistant that provides valid JSON only.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 4000,
            ]);

            if (!$response->ok()) {
                return ['success' => false];
            }

            $text = $response->json('choices')[0]['message']['content'] ?? '';

            // Clean and parse JSON
            $jsonStart = strpos($text, '{');
            $jsonEnd = strrpos($text, '}');

            if ($jsonStart !== false && $jsonEnd !== false) {
                $clean = substr($text, $jsonStart, $jsonEnd - $jsonStart + 1);
                $parsed = json_decode($clean, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'data' => [
                            'literature' => $parsed['literature'] ?? [],
                            'videos' => $parsed['videos'] ?? [],
                            'links' => $parsed['links'] ?? [],
                            'linkedin_profiles' => $parsed['linkedin_profiles'] ?? [],
                        ]
                    ];
                }
            }

            return ['success' => false];

        } catch (\Exception $e) {
            Log::error('AI API call failed: ' . $e->getMessage());
            return ['success' => false];
        }
    }


    public function CronGenerateRA()
    {
        // Prevent external access (optional)
        // if (request()->ip() !== '127.0.0.1' && !request()->has('key')) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        $user = User::where('approval', 'accepted')
                    ->where('research_assistance_attempts', '<', 2)
                    ->whereNotNull('project')
                    ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No eligible user found.']);
        }

        $aiService = app(AIService::class);
        $yt = app(YoutubeService::class); // your YouTube service
        $prompt = $aiService->createPrompt($user->project, 'Graduate');
        $response = $aiService->getAiResponseWithFallback($prompt);

        if (!$response) {
            Log::error("AI failed for user ID {$user->id}");
            return response()->json(['success' => false, 'error' => 'AI failed']);
        }

        $parsed = $aiService->parseJsonResponse($response['content']);

        // YouTube video merging
        $videos = [];
        foreach ($parsed['video_search_queries'] ?? [] as $query) {
            $videos = array_merge($videos, $yt->fetchVideos($query));
        }
        $parsed['videos'] = array_slice($videos, 0, 10);

        // Merge with existing
        $existing = AiResearchAssistance::firstOrNew(['user_id' => $user->id]);

        $existing->literature = json_encode(array_merge(
            json_decode($existing->literature ?? '[]', true),
            $parsed['literature'] ?? []
        ));
        $existing->videos = json_encode(array_merge(
            json_decode($existing->videos ?? '[]', true),
            $parsed['videos'] ?? []
        ));
        $existing->links = json_encode(array_merge(
            json_decode($existing->links ?? '[]', true),
            $parsed['links'] ?? []
        ));
        $existing->linkedin = json_encode(array_merge(
            json_decode($existing->linkedin ?? '[]', true),
            $parsed['linkedin_profiles'] ?? []
        ));
        $existing->save();

        // Increment attempt
        $user->increment('research_assistance_attempts');

        return response()->json([
            'success' => true,
            'message' => "Research content generated and merged for user {$user->name}"
        ]);
    }


}
