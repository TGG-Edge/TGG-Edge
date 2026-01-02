<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Show settings page (tab based)
     */
    public function index(Request $request)
    {
        $activeGroup = $request->get('group', 'general');

        $groups = Setting::select('group')
            ->distinct()
            ->pluck('group');

        $settings = Setting::group($activeGroup)->get();

        return view('tgg-india.admin.settings.index', compact(
            'groups',
            'settings',
            'activeGroup'
        ));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {

            foreach ($request->settings as $id => $value) {

                $setting = Setting::find($id);
                if (!$setting || !$setting->is_editable) {
                    continue;
                }

                // JSON values
                if ($setting->type === 'json') {
                    $setting->value = array_values($value);
                } else {
                    $setting->value = $value;
                }

                $setting->save();
            }
        });

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
