<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserSecondary;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $donations = Donation::latest()->paginate(10);

        return view('tgg-india.admin.donations.index', compact('donations'));
    }

     public function create()
    {
        $users = UserSecondary::all();
        return view('tgg-india.admin.donations.create',compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email',
            'phone'  => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $donation = Donation::create($request->all());

        if ($request['purpose'] == 'TGG AID' ||  $request['purpose'] == 'TGG GRANT') {
            $amount = round($request['amount'] * 0.05, 0, PHP_ROUND_HALF_UP);
        } else {
            $amount = round($request['amount'] * 0.10, 0, PHP_ROUND_HALF_UP);
        }

        $user = UserSecondary::where('email', $request['email'])->first();
        $check_reward = Reward::where('source_id', $user->id)->first();

        if($check_reward){

            $amount += $check_reward->amount;
            $check_reward->update([
                'title'       => 'Donation Incentive',
                'source_id'   => $user->id ?? auth('web2')->id(),  
                'source_type' => 'donation',
                'target_id'   => 1, 
                'target_type' => null,
                'description' => 'Reward for supporting TGG India through donation from ' . auth('web2')->user()->name ?? $request['name'] ,
                'reason'      => 'donation_reward',
                'amount'      => $amount,
                'status'      => 'approved',
                'model_type'  => Donation::class,
                'model_id'    => $donation->id,   
            ]);

        }else{
                Reward::create([
                    'title'       => 'Donation Incentive',
                    'source_id'   => $user->id ?? auth('web2')->id(),  
                    'source_type' => 'donation',
                    'target_id'   => 1, 
                    'target_type' => null,
                    'description' => 'Reward for supporting TGG India through donation from ' . auth('web2')->user()->name ?? $request['name'] ,
                    'reason'      => 'donation_reward',
                    'amount'      => $amount,
                    'status'      => 'approved',
                    'model_type'  => Donation::class,
                    'model_id'    => $donation->id,   
                ]);
        }

        

        return redirect()
            ->route('tgg-india.admin.donations.index')
            ->with('success', 'Donation created successfully');
    }

    public function edit(Donation $donation)
    {
        $users = UserSecondary::all();
        return view('tgg-india.admin.donations.edit', compact('donation','users'));
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'nullable|email',
            'phone'  => 'nullable|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $old_amount = $donation->amount;
        if ($donation['purpose'] == 'TGG AID' ||  $donation['purpose'] == 'TGG GRANT') {
            $old_amount = round($donation['amount'] * 0.05, 0, PHP_ROUND_HALF_UP);
        } else {
            $old_amount = round($donation['amount'] * 0.10, 0, PHP_ROUND_HALF_UP);
        }

        $donation->update($request->all());

        
        if ($request['purpose'] == 'TGG AID' ||  $request['purpose'] == 'TGG GRANT') {
            $amount = round($request['amount'] * 0.05, 0, PHP_ROUND_HALF_UP);
        } else {
            $amount = round($request['amount'] * 0.10, 0, PHP_ROUND_HALF_UP);
        }

        $user = UserSecondary::where('email', $request['email'])->first();
        $check_reward = Reward::where('source_id', $user->id)->first();

        if($check_reward){
            $amount = $amount + ($check_reward->amount - $old_amount);
            // $amount += $check_reward->amount;
            $check_reward->update([
                'title'       => 'Donation Incentive',
                'source_id'   => $user->id ?? auth('web2')->id(),  
                'source_type' => 'donation',
                'target_id'   => 1, 
                'target_type' => null,
                'description' => 'Reward for supporting TGG India through donation from ' . auth('web2')->user()->name ?? $request['name'] ,
                'reason'      => 'donation_reward',
                'amount'      => $amount,
                'status'      => 'approved',
                'model_type'  => Donation::class,
                'model_id'    => $donation->id,   
            ]);

        }
        

        return redirect()
            ->route('tgg-india.admin.donations.index')
            ->with('success', 'Donation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()
            ->route('tgg-india.admin.donations.index')
            ->with('success', 'Donation deleted successfully');
    }
}
