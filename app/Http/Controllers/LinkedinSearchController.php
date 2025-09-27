<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class LinkedinSearchController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 15,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            ],
        ]);
    }

    public function search(Request $req)
    {
        $limit = (int) $req->get('limit', 5);
        $limit = min(max($limit, 1), 20);

        $query = $req->get('q', implode(' ', [
            'site:linkedin.com/in',
            '("Researcher" OR "Research Assistant" OR "Research Intern" OR "Research Scholar" OR "Research Trainee" OR "Research Associate")',
            '("Student" OR "University Student" OR "College Student" OR "Grad Student")',
            '("Undergraduate" OR "UG Student" OR "Undergrad" OR "Bachelor Student" OR "B.Tech Student" OR "BSc Student")',
            'India'
        ]));

        $duckUrl = "https://html.duckduckgo.com/html/?q=" . urlencode($query);

        try {
            $resp = $this->client->get($duckUrl);
            $html = (string) $resp->getBody();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch search results',
                'detail' => $e->getMessage()
            ], 500);
        }

        $crawler = new Crawler($html);
        $links = [];

        // Extract LinkedIn URLs from DuckDuckGo results
        $crawler->filter('a')->each(function (Crawler $node) use (&$links) {
            $href = $node->attr('href');
            if ($href && stripos($href, 'linkedin.com/in') !== false) {
                if (preg_match('#https?://(www\.)?linkedin\.com/in/[^/?#]+#i', $href, $m)) {
                    $links[] = $m[0];
                }
            }
        });

        $links = array_slice(array_values(array_unique($links)), 0, $limit);

        $results = [];

        foreach ($links as $link) {
            usleep(300000); // 0.3s delay to be polite

            $profile = [
                'url' => $link,
                'title' => null,
                'description' => null,
                'snippet' => null,
                'error' => null
            ];

            try {
                $r = $this->client->get($link);
                $body = (string)$r->getBody();

                $pc = new Crawler($body);

                // Get <title>
                $title = $pc->filter('title')->count() ? trim($pc->filter('title')->text()) : null;

                // Get meta og:description
                $desc = $this->getMeta($pc, 'property', 'og:description');

                // Visible text snippet
                $visible = $this->getVisibleText($pc);
                $snippet = mb_substr($visible, 0, 800);

                $profile['title'] = $title;
                $profile['description'] = $desc;
                $profile['snippet'] = $snippet;

            } catch (\Exception $e) {
                $profile['error'] = 'Failed to fetch profile: ' . $e->getMessage();
            }

            $results[] = $profile;
        }

        return response()->json([
            'query' => $query,
            'count' => count($results),
            'results' => $results
        ]);
    }

    private function getMeta(Crawler $c, $attr, $name)
    {
        try {
            $meta = $c->filterXPath("//meta[@$attr='$name']");
            if ($meta->count()) return $meta->first()->attr('content');
        } catch (\Exception $e) {}
        return null;
    }

    private function getVisibleText(Crawler $c)
    {
        $text = '';
        $c->filter('body')->each(function (Crawler $node) use (&$text) {
            $text .= ' ' . trim($node->text());
        });
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}
