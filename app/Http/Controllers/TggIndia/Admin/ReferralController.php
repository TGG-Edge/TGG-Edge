<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\Enquiry;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function program()
    {
        //
        $content = ContentPage::where('source_type', 'referral')->first();
        return view('tgg-india.admin.referral.program', compact('content'));
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
    public function tracking()
    {
        $referrerId = auth('web2')->id();
        // eager load referred users (relationship: referral -> user)
        $referrals = Referral::with('referredUser')
            ->paginate(10);
        return view('tgg-india.admin.referral.tracking', compact('referrals'));
    }

    public function enquiryReferralTracking()
    {
        $enquiries = Enquiry::latest()->paginate(10);
        return view('tgg-india.admin.referral.enquiry-tracking', compact('enquiries'));
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

    public function contentUpdate(Request $request, string $id)
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
