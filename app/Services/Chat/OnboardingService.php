<?php
namespace App\Services\Chat;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\UserSecondary;

class OnboardingService
{
    public function store(array $data)
    {
        $referral_user = UserSecondary::where('id', $data['referred_by'])->first();
        return Enquiry::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['number'],
            'address' => $data['address'],
            'role' => $data['role_type'],
            'referral_code' =>  $data['referred_by'] ?? null,
        ]);
    }
}
