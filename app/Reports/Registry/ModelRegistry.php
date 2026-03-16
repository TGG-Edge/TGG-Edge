<?php

namespace App\Reports\Registry;

class ModelRegistry
{
    // public static function all(): array
    // {
    //     return [
    //         'users' => \App\Models\User::class,
    //         'orders' => \App\Models\Order::class,
    //         'products' => \App\Models\Product::class,
    //     ];
    // }

    public static function all(): array
    {
        return [
            'users' => \App\Models\UserSecondary::class,
            'assignments' => \App\Models\AssignmentSecondary::class,
            'campaigns' => \App\Models\Campaign::class,
            'campaign_check_emails' => \App\Models\CampaignCheckEmail::class,
            'campaign_recipients' => \App\Models\CampaignRecipient::class,
            'donations' => \App\Models\Donation::class,
            'enquiries' => \App\Models\Enquiry::class,
            'incentives' => \App\Models\Incentive::class,
            'invoices' => \App\Models\Invoice::class,
            'payments' => \App\Models\Payment::class,
            'receipts' => \App\Models\Receipt::class,
            'referrals' => \App\Models\Referral::class,
            'rewards' => \App\Models\Reward::class,
        ];
    }
}