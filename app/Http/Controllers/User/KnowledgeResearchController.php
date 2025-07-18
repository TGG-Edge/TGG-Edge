<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AIService;

class KnowledgeResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function knowledgeAndResearch()
    {
        return view('user.knowledge-research');
    }

    public function searchKnowledge(Request $request, AIService $aiService)
    {
        // Get API key from environment variable
	    $apiKey = env("TOGETHER_API_KEY", "null");

        $searchQuery = $request->input('searchData');

        if (!$searchQuery) {
            return response()->json(['error' => 'Search query required'], 400);
        }

        $prompt = $this->createResearchPrompt($request->input('searchData'));

        $response = $aiService->getAiResponseWithFallback($prompt, 'gemini');

        if (!$response) {
                return response()->json(['success' => false, 'error' => 'AI failed'], 500);
        }

		// Decode JSON response
		$responseData =  $response['content'];

		// Print the response content
		if ($responseData) {
            $responseResult = $responseData;
			return response()->json( [ 'success' => $responseResult ] );
		} else {
			return response()->json( [ 'error' => 'Could not get response content' ] );
			// echo "\nFull response: " . $response;
		}
	}

    public function createResearchPrompt($topic, $academicLevel = "Graduate", $researchArea = "", $keywords = "", $userContext = "")
    {
        return <<<EOT
            You are an advanced research assistant. Generate comprehensive research content for: "{$topic}"

            Context:
            - Academic Level: {$academicLevel}
            - Research Area: {$researchArea}
            - Keywords: {$keywords}
            - User: {$userContext}

            Return ONLY a valid TEXT:

            Requirements:
            - Return TEXT only
            - Return You are a 1-response API. Your output must strictly be provided in HTML tags [not use and add ```html like this ] , and if you use h tag so use in h4,h5 and rest you can use any html tag. And give response long.
            EOT;
    }
    
    public function index()
    {
        // - Do not user markdown formatting, * or #"
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
