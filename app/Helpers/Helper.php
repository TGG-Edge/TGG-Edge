<?php

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
