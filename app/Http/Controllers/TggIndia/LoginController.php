<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
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

    public function switchAccount($id)
    {
        $currentUser = Auth::guard('web2')->user();

        $otherAccount = UserSecondary::where('id', $id)
            ->where('email', $currentUser->email)
            ->first();

        if ($otherAccount) {
            Auth::guard('web2')->login($otherAccount);

            // Redirect based on role
            switch ($otherAccount->user_role) {
                case 2:
                    return redirect()->route('tgg-india.trainer.dashboard');
                case 3:
                    return redirect()->route('tgg-india.member.dashboard');
                default:
                    return redirect()->route('tgg-india.login');
            }
        }

        return redirect()->back()->with('error', 'No linked account found.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
         return view('tgg-india.login');

    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web2')->attempt($request->only('email', 'password'))) {
            auth()->shouldUse('web2');
            if(auth()->user()->user_role == 1){
            return redirect()->route('tgg-india.admin.dashboard'); 

            }elseif(auth()->user()->user_role == 2){
            return redirect()->route('tgg-india.trainer.dashboard'); 

            }elseif(auth()->user()->user_role == 3){
            return redirect()->route('tgg-india.member.dashboard'); 

            }
            elseif(auth()->user()->user_role == 4){
            return redirect()->route('tgg-india.rhm-club.dashboard'); 

            }
            elseif(auth()->user()->user_role == 5){
            return redirect()->route('tgg-india.nomad-community.dashboard'); 

            }else{
                 return redirect()->route('tgg-india.freelancer.dashboard'); 
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function logout(Request $request)
    {
        //
        Auth::guard('web2')->logout();
        return redirect()->route('tgg-india.login');
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
}