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
            'Interview'      => 'Interview',
            'Interview'  => 'Documentation',
            'Lead Generation' => 'Lead Generation',
            'On Boarding'     => 'On Boarding',
            'Training'       => 'Training', // you can add more here
            'Freelance Assignment' => 'Freelance Assignment'

        ];
    }
}




if (!function_exists('validatePattern')) {

    function validatePattern($type, $value)
    {
        $patterns = [
            'ifsc' => [
                'regex' => '/^[A-Z]{4}0[A-Z0-9]{6}$/',
                'example' => 'Ifsc Code Example: SBIN0001234'
            ],

            // ===== BANK DETAILS =====
            'account_number' => [
                // Common Indian Bank Account Format (9 to 18 digits)
                'regex' => '/^[0-9]{9,18}$/',
                'example' => 'Account number should be 9 to 18 digits'
            ],
            'ifsc_code' => [ // alias, same as ifsc
                'regex' => '/^[A-Z]{4}0[A-Z0-9]{6}$/',
                'example' => 'Ifsc Code Example Example: HDFC0001234'
            ],

            // ===== PERSONAL ID =====
            'pan' => [
                'regex' => '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'example' => 'Pan Number should be - Example: ABCDE1234F'
            ],
            'aadhaar' => [
                'regex' => '/^[2-9]{1}[0-9]{11}$/',
                'example' => '12 Digit Aadhaar – should not start with 0 or 1'
            ],
            'voter_id' => [
                'regex' => '/^[A-Z]{3}[0-9]{7}$/',
                'example' => 'Voter id should be Example: XYZ1234567'
            ],

            'driving_license' => [
                // Example: MH1420012345678 or UP1420012345678
                'regex' => '/^[A-Z]{2}[0-9]{2}[0-9]{11,14}$/',
                'example' => 'Driving License should be Example: MH1420012345678'
            ],

            // ===== CUSTOM =====
            'rhm_number' => [
                // Format: RHM/KL/QLN/0001 (supports any 2–4 letter state and district)
                'regex' => '/^RHM\/[A-Z]{2,3}\/[A-Z]{2,4}\/[0-9]{4}$/',
                'example' => 'Rhm Number Correct Format is: RHM/KL/QLN/0001'
            ],
        ];

        $type = strtolower($type);

        if (!isset($patterns[$type])) {
            return [false, 'Invalid pattern type requested'];
        }

        // Validate
        if (preg_match($patterns[$type]['regex'], trim($value))) {
            return [true, 'Valid'];
        }

        // Failed — return example format
        return [false, $patterns[$type]['example']];
    }
}
