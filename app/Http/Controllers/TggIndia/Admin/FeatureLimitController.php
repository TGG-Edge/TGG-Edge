<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureLimit;
use Illuminate\Http\Request;

class FeatureLimitController extends Controller
{
    public function index()
    {
        $featureLimits = FeatureLimit::latest()->get();
        return view('tgg-india.admin.feature_limits.index', compact('featureLimits'));
    }

    public function create()
    {
        return view('tgg-india.admin.feature_limits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'feature_key' => 'required|string|max:255|unique:mysql2.feature_limits,feature_key',
            'free_limit'  => 'required|integer|min:0',
        ]);

        FeatureLimit::create($request->all());

        return redirect()->route('tgg-india.admin.feature-limits.index')
                         ->with('success', 'Feature limit created successfully.');
    }

    public function edit($id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);
        return view('tgg-india.admin.feature_limits.edit', compact('featureLimit'));
    }

    public function update(Request $request, $id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);

        $request->validate([
            'feature_key' => 'required|string|max:255|unique:mysql2.feature_limits,feature_key,' . $featureLimit->id,
            'free_limit'  => 'required|integer|min:0',
        ]);

        $featureLimit->update($request->all());

        return redirect()->route('tgg-india.admin.feature-limits.index')
                         ->with('success', 'Feature limit updated successfully.');
    }

    public function destroy($id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);
        $featureLimit->delete();

        return redirect()->route('tgg-india.admin.feature-limits.index')
                         ->with('success', 'Feature limit deleted successfully.');
    }
}