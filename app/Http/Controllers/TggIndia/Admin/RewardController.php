<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\UserSecondary;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rewards = Reward::latest()->paginate(10);
        return view('tgg-india.admin.rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = UserSecondary::orderBy('name')->get();
        return view('tgg-india.admin.rewards.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'source_id' => 'required',
            'target_id' => 'required',
            'reason' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'status' => 'required|string',
        ]);
        
        Reward::create($request->all());

        return redirect()->route('tgg-india.admin.rewards.index')->with('success', 'Reward created successfully!');
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        $users = UserSecondary::orderBy('name')->get();
        return view('tgg-india.admin.rewards.edit', compact('reward', 'users'));
    }

    public function update(Request $request, $id)
    {
        $reward = Reward::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'source_id' => 'required',
            'target_id' => 'required',
            'reason' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric',
            'status' => 'required|string',
        ]);

        $reward->update($request->all());

        $data = $request->except('amount');

        if ($request->filled('amount')) {
            $data['amount'] = round($request->amount, 0, PHP_ROUND_HALF_UP);
        }

        $reward->update($data);

        return redirect()->route('tgg-india.admin.rewards.index')->with('success', 'Reward updated successfully!');
    }

    public function destroy($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return redirect()->route('tgg-india.admin.rewards.index')->with('success', 'Reward deleted successfully!');
    }
}
