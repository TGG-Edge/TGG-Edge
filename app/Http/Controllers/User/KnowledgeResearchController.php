<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KnowledgeResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function knowledgeAndResearch()
    {
        return view('user.knowledge-research');
    }

    public function searchKnowledge(Request $request)
    {
        // Get API key from environment variable
	    $apiKey = env("TOGETHER_API_KEY", "null");

        // API endpoint
        $url = 'https://api.together.xyz/v1/chat/completions';

		// Request data
		$data = [
			'model' => 'deepseek-ai/DeepSeek-V3',
			'messages' => [
				[
					'role' => 'user',
					'content' => $request->input('searchData')
				]
			]
		];

		// Initialize cURL
		$ch = curl_init();

		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json',
			'Authorization: Bearer ' . $apiKey
		]);

		// Execute request
		$response = curl_exec($ch);

		// Check for errors
		if (curl_errno($ch)) {
			return response()->json( [ 'error' => curl_error($ch) ] );
			// echo 'cURL Error: ' . curl_error($ch);
			curl_close($ch);
			exit;
		}

		// Close cURL
		curl_close($ch);

		// Decode JSON response
		$responseData = json_decode($response, true);

		// Print the response content
		if (isset($responseData['choices'][0]['message']['content'])) {
			return response()->json( [ 'success' => $responseData['choices'][0]['message']['content'] ] );
		} else {
			return response()->json( [ 'error' => 'Could not get response content' ] );
			// echo "\nFull response: " . $response;
		}
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
}
