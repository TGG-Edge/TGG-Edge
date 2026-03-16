<?php
namespace App\Services\Chat;

use App\Models\User;
use App\Models\Enquiry;
use App\Models\Incentive;
use App\Models\Referral;
use App\Models\UserSecondary;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Traits\MailTrait;


class UserRegistrationService
{
    use MailTrait;
    public function registerFromEnquiry($enquiryId)
    {
        $enquiry = Enquiry::findOrFail($enquiryId);

        $userMailData = [
            'name' => $enquiry->name,
            'message' => 'Thank you for registering with TGG India! Your account has been successfully created. We’re excited to have you on board and look forward to your journey with us.',
            'button_text' => 'Login to Your Account',
            'button_url' => url('https://thegoldengreens.com/tgg-meta/tgg-india/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M')
        ];

        $this->sendMail(
            $enquiry->email,
            'Welcome to TGG India - Registration Successful',
            'tgg-india.emails.tgg-template',
            $userMailData
        );

        $admin = UserSecondary::where('user_role', 1)->first();

        if ($admin && $admin->email) {

            $adminMailData = [
                'name' => 'Admin',
                'message' => "New user registered on TGG India.\n\nName: {$enquiry->name}\nEmail: {$enquiry->email}\nPhone: {$enquiry->number}\nRole: {$enquiry->role}",
                'button_text' => 'View Dashboard',
                'button_url' => url('https://thegoldengreens.com/tgg-meta/tgg-india/login/XCJBDSNJK43RWEFSKDJCXNFL34KRN3DKL3MREFWLMNKL32M')
            ];

            $this->sendMail(
                $admin->email,
                'New User Registration - TGG India',
                'tgg-india.emails.tgg-template',
                $adminMailData
            );
        }
        

        $user = UserSecondary::create([
            'name' => $enquiry->name,
            'email' => $enquiry->email,
            'age' => $enquiry->age,
            'project' => $enquiry->project ?? null,
            'phone' => $enquiry->number,
            'address' => $enquiry->address,
            'user_role' => $enquiry->role,
            'password' => Hash::make('default-password'),
            'referral_code' => generateUniqueReferralCode(),
        ]);

        if (!empty($enquiry['referral_code'])) {
            $referrerUser = UserSecondary::where('referral_code', $enquiry['referral_code'])->first();
            if ($referrerUser) {
                Referral::create([
                    'referrer_id' => $referrerUser->id,
                    'referred_id' => $user->id,
                    'step' => 0
                ]);
            }

            Incentive::create([
                'title'       => 'Referral Incentive',
                'source_id'   => $referrerUser->id,
                'source_type' => 'registration',
                'target_id'   =>  1,  
                'target_type' => null,
                'description' => 'Incentive for successful registration via referral',
                'reason'      => 'registration_referral',
                'amount'      => 250,   
                'status'      => 'pending',
            ]);
        }

        return $user;
    }
}
