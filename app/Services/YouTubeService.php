<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouTubeService
{
    public function fetchVideos($query, $max = 5)
    {
        $response = Http::timeout(10)->get('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'q' => $query,
            'type' => 'video',
            'key' => env('YOUTUBE_API_KEY'),
            'maxResults' => $max,
            'videoDuration' => 'long',
            'relevanceLanguage' => 'en',
        ]);

        if (!$response->successful()) {
            Log::error('YouTube API error', ['query' => $query, 'error' => $response->body()]);
            return [];
        }

        return collect($response->json()['items'] ?? [])->map(function ($item) {
            return [
                'title' => $item['snippet']['title'],
                'channel' => $item['snippet']['channelTitle'],
                'url' => "https://www.youtube.com/watch?v=" . $item['id']['videoId'],
                'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? '',
                'description' => $item['snippet']['description'],
            ];
        })->toArray();
    }
}
