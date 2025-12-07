<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiResearchAssistance;
use App\Models\Incentive;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserBankDetailSecondary;
use App\Models\UserIdProofSecondary;
use App\Models\UserSecondary;
use App\Services\AIService;
use App\Services\YouTubeService;
use Illuminate\Http\Request;
use App\Traits\HandlesAiResearch;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HandlesAiResearch;

    public function index()
    {
        $users = UserSecondary::where('user_role', 2)->latest()->paginate(5);
        return view('user.user-approval', compact('users'));
    }

    public function  newApplication()
    {
        $newApplications = UserSecondary::whereIn('user_role', [2,3,4,5,6,7,8,9])->where('approval','pending')->latest()->paginate(10);
        return view('tgg-india.admin.applications.new-application', compact('newApplications'));
    }

    public function processedApplication()
    {
       $processedApplications = UserSecondary::whereIn('user_role', [2,3,4,5,6,7,8,9])->where('approval','!=','pending')->latest()->paginate(10);
        return view('tgg-india.admin.applications.processed-application', compact('processedApplications'));
    }

    public function userProfile(Request $request, $id)
    {
        $user = UserSecondary::where('id',$id)->first();
        $idProof = \App\Models\UserIdProofSecondary::where('user_id', $user->id)->first();
        $bankDetail = \App\Models\UserBankDetailSecondary::where('user_id', $user->id)->first();
        return view('tgg-india.admin.applications.user-profile', compact('user','idProof', 'bankDetail'));
    }

   public function userProfileUpdate(Request $request, $id)
    {
        $user = UserSecondary::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'rhm_number' => 'nullable|string|max:50',
        ]);

        if ($request->filled('rhm_number')) {
            [$valid, $msg] = validatePattern('rhm_number', $request->rhm_number);
            if (!$valid) return back()->withErrors(['rhm_number' => $msg])->withInput();
        }

        if ($request->filled('account_number')) {
            [$valid, $msg] = validatePattern('account_number', $request->account_number);
            if (!$valid) return back()->withErrors(['account_number' => $msg])->withInput();
        }

        if ($request->filled('ifsc_code')) {
            [$valid, $msg] = validatePattern('ifsc_code', $request->ifsc_code);
            if (!$valid) return back()->withErrors(['ifsc_code' => $msg])->withInput();
        }

        if ($request->filled('id_proof_type') && $request->filled('id_proof_number')) {

            // Convert dropdown value to correct pattern key
            $map = [
                'Aadhaar'          => 'aadhaar',
                'PAN'              => 'pan',
                'Voter ID'         => 'voter_id',
                'Driving License'  => 'driving_license',
            ];

            $type = $request->id_proof_type;

            // Only validate if proof type exists in our map
            if (isset($map[$type])) {
                [$valid, $msg] = validatePattern($map[$type], $request->id_proof_number);
                if (!$valid) {
                    return back()->withErrors(['id_proof_number' => $msg])->withInput();
                }
            }
        }


        $proof = UserIdProofSecondary::on('mysql2')->firstOrNew(['user_id' => $user->id]);
        $proof->id_proof_type = $request->id_proof_type;
        $proof->id_proof_number = $request->id_proof_number;

        if ($request->hasFile('id_proof_file')) {
            $proof->id_proof_file = $request->file('id_proof_file')->store('id_proofs', 'public');
        }

        $proof->save();

        $bank = UserBankDetailSecondary::on('mysql2')->firstOrNew(['user_id' => $user->id]);
        $bank->fill($request->only([
            'bank_name',
            'account_holder_name',
            'account_number',
            'ifsc_code',
            'branch_name',
        ]));

        if ($request->hasFile('bank_document')) {
            $bank->bank_document = $request->file('bank_document')->store('bank_docs', 'public');
        }

        $bank->save();
        
        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }


    public function updateApproval(Request $request, $id)
    {
        

        $user = UserSecondary::findOrFail($id);
        $message = "";
        $user->approval = $request->action;
        $user->save();

        return back()->with('success', 'User '.$request->action.' status updated.' . $message);
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'project' => 'required|string|max:255',
        ]);

        $user = UserSecondary::findOrFail($id);
        $user->project = $request->project;
        $user->save();

        return back()->with('success', 'Project details updated.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function incentiveIndex()
    {
        $incentives = Incentive::paginate(10);

        return view('tgg-india.incentives', compact('incentives'));
    }

        public function rewardIndex()
    {
         $rewards = Reward::paginate(10);

        return view('tgg-india.rewards', compact('rewards'));
    }
}
