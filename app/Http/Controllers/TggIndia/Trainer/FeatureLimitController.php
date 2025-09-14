<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\FeatureLimit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeatureLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featureLimits = FeatureLimit::where('created_by', auth('web2')->id())
            ->latest()
            ->get();

        return view('tgg-india.trainer.feature_limits.index', compact('featureLimits'));
    }

    public function create()
    {
        return view('tgg-india.trainer.feature_limits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'feature_key' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mysql2.feature_limits', 'feature_key')
                    ->where(function ($query) {
                        return $query->where('created_by', auth('web2')->id());
                    }),
            ],
            'free_limit'  => 'required|integer|min:0',
        ]);


        FeatureLimit::create([
            'feature_key' => $request->feature_key,
            'free_limit'  => $request->free_limit,
            'created_by'  => auth('web2')->id(),
        ]);

        return redirect()->route('tgg-india.trainer.feature-limits.index')
            ->with('success', 'Feature limit created successfully.');
    }

   public function setPrice(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $userId = auth('web2')->id();

        // Update all feature limits of the current user
        FeatureLimit::where('created_by', $userId)
            ->update(['price' => $request->price]);

        return redirect()->back()->with('success', 'Price updated successfully for all your features.');
    }



    public function edit($id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);
        return view('tgg-india.trainer.feature_limits.edit', compact('featureLimit'));
    }

    public function update(Request $request, $id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);

        $request->validate([
            'feature_key' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mysql2.feature_limits', 'feature_key')
                    ->ignore($featureLimit->id)
                    ->where(function ($query) {
                        return $query->where('created_by', auth('web2')->id());
                    }),
            ],
            'free_limit'  => 'required|integer|min:0',
        ]);


        $featureLimit->update([
            'feature_key' => $request->feature_key,
            'free_limit'  => $request->free_limit,
        ]);

        return redirect()->route('tgg-india.trainer.feature-limits.index')
            ->with('success', 'Feature limit updated successfully.');
    }

    public function destroy($id)
    {
        $featureLimit = FeatureLimit::findOrFail($id);
        $featureLimit->delete();

        return redirect()->route('tgg-india.trainer.feature-limits.index')
            ->with('success', 'Feature limit deleted successfully.');
    }
}
