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
    function statusWithColor(?string $status): string
    {
        if (!$status) {
            return '<span class="badge page-button bg-secondary">N/A</span>';
        }

        $status = strtolower($status);

        return match ($status) {
            'pending'     => '<span class="badge page-button bg-warning text-dark">' . ucfirst($status) . '</span>',
            'in_progress' => '<span class="badge page-button bg-primary">' . ucfirst(str_replace('_', ' ', $status)) . '</span>',
            'accepted'    => '<span class="badge page-button bg-info text-dark">' . ucfirst($status) . '</span>',
            'rejected'    => '<span class="badge page-button bg-danger">' . ucfirst($status) . '</span>',
            'completed'   => '<span class="badge page-button bg-success">' . ucfirst($status) . '</span>',
            default       => '<span class="badge page-button bg-secondary">' . ucfirst($status) . '</span>',
        };
    }
}

if (! function_exists('statusWithColorApproval')) {
    function statusWithColorApproval(string|int|null $status): string
    {
        if ($status === null || $status === '') {
            return '<span class="badge page-button bg-secondary">N/A</span>';
        }

        $status = strtolower((string) $status);

        return match ($status) {
            'pending', '0'  => '<span class="badge page-button bg-warning text-dark">Pending</span>',
            'accepted', '1' => '<span class="badge page-button bg-success">Accepted</span>',
            'rejected', '2' => '<span class="badge page-button bg-danger">Rejected</span>',
            default          => '<span class="badge page-button bg-secondary">' . ucfirst($status) . '</span>',
        };
    }
}

if (! function_exists('statusWithColorStep')) {
    function statusWithColorStep(int|string|null $step): string
    {
        if ($step === null || $step === '') {
            return '<span class="badge bg-secondary">N/A</span>';
        }

        $step = (int) $step;

        return match ($step) {
            0       => '<span class="badge bg-warning text-dark">Pending</span>',
            1       => '<span class="badge bg-success">Completed</span>',
            default => '<span class="badge bg-secondary">Other</span>',
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

if (!function_exists('taskTypes')) {
    function taskTypes()
    {
        return [
            'Verification'   => 'Verification',
            'interview'      => 'Interview',
            'Interview'  => 'Documentation',
            'Lead Generation' => 'Lead Generation',
            'On Boarding'     => 'On Boarding',
            'Training'       => 'Training', // you can add more here

        ];
    }
}