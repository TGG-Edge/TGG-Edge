<?php

use App\Models\UserSecondary;

if (!function_exists('featureList')) {
    function featureList()
    {
        return [
            [
                'id'    => 1,
                'key'   => 'literatures',
                'name'  => 'Literatures',
            ],
            [
                'id'    => 2,
                'key'   => 'links',
                'name'  => 'Links',
            ],
            [
                'id'    => 3,
                'key'   => 'videos',
                'name'  => 'Videos',
            ],
            [
                'id'    => 4,
                'key'   => 'linkedins',
                'name'  => 'LinkedIns',
            ],
        ];
    }
}


function getEmbedUrl($url) {
    // For youtu.be links
    if (preg_match('/youtu\.be\/([^\?]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }

    // For youtube.com/watch?v= links
    if (preg_match('/v=([^\&]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }

    return $url; // fallback
}

if (! function_exists('statusWithColor')) {
    function statusWithColor(string $status): string
    {
        $status = strtolower($status);

        return match ($status) {
            'pending'     => '<span class="badge page-button bg-warning text-dark">' . ucfirst($status) . '</span>',
            'in_progress' => '<span class="badge page-button bg-primary">' . ucfirst(str_replace('_', ' ', $status)) . '</span>',
            'completed'   => '<span class="badge page-button bg-success">' . ucfirst($status) . '</span>',
            default       => '<span class="badge page-button bg-secondary">' . ucfirst($status) . '</span>',
        };
    }
}


function generateUniqueReferralCode($length = 8)
{
    do {
        $code = strtoupper(\Str::random($length));
    } while (UserSecondary::where('referral_code', $code)->exists());

    return $code;
}