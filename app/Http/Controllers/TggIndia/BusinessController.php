<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $businesses = Business::query();
        if(auth('web2')->user()->user_role != 1){
            $businesses->where('user_id', auth('web2')->id());
        }
        $businesses = $businesses->latest()->paginate(10);
        return view('tgg-india.businesses.index', compact('businesses'));
    }

    public function create()
    {
        $users = UserSecondary::whereIn('user_role', [7])->get();
        return view('tgg-india.businesses.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:mysql2.users,id',
            'title' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('businesses', 'public');
        }

        Business::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'code' => $request->code,
            'description' => $request->description,
            'image' => $image,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'status' => $request->status,                   
            'created_by' => Auth('web2')->id(),
        ]);

        return redirect()
            ->route('tgg-india.businesses.index',   ['role' => auth('web2')->user()->role_key])
            ->with('success', 'Business created successfully.');
    }

    public function show($role,Business $business)
    {
        return view('tgg-india.businesses.show', compact('business'));
    }

    public function edit($role,Business $business)
    {
        $users = UserSecondary::whereIn('user_role', [7])->get();

        return view('tgg-india.businesses.edit', compact('business', 'users'));
    }

    public function update(Request $request, Business $business)
    {
        $request->validate([
            'user_id' => 'required|exists:mysql2.users,id',
            'title' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);

        $image = $business->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('businesses', 'public');
        }

        $business->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'code' => $request->code,
            'description' => $request->description,
            'image' => $image,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'status' => $request->status,
            'updated_by' => Auth('web2')->id(),
        ]);

        return redirect()
            ->route('tgg-india.businesses.index',['role' => auth('web2')->user()->role_key])
            ->with('success', 'Business updated successfully.');
    }

    public function destroy($role,Business $business)
    {
        $business->delete();
        return redirect()
            ->route('tgg-india.businesses.index',['role' => auth('web2')->user()->role_key] )
            ->with('success', 'Business deleted successfully.');
    }
}
