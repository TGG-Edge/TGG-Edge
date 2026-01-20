<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleFeature;
use App\Models\ModuleInstance;
use App\Models\ModuleInstanceAssign;
use App\Models\UserSecondary;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    //
    public function index()
    {
        // $modules = Module::with('users')->latest()->get();
        $modules = Module::latest()->get();
        return view('tgg-india.admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $users = UserSecondary::select('id', 'name')->get();
        $features = [
            'literatures' => 'Literatures',
            // 'literature_chapters' => 'Literature Chapters',
            // 'literature_sections' => 'Literature Sections',
            'links' => 'Links',
            'linkedins' => 'LinkedIns',
            'videos' => 'Videos'
        ];

        return view('tgg-india.admin.modules.create', compact('users', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'users'  => 'required|array',
            'user_id' => 'required',
        ]);

        $module = Module::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $module_instance = ModuleInstance::create([
            'module_id' => $module->id,
            'user_id'   => $request->user_id,
        ]);

        // foreach ($request->users as $userId) {
        //     $module_instance_array = ModuleInstanceAssign::where(
        //         'user_id',$userId)->pluck('module_instances_id')->toArray();
            
        //     if(!in_array($module_instance->id, $module_instance_array)){
        //         $module_instance_array[] = $module_instance->id;
        //     }

        //     ModuleInstanceAssign::create([
        //         'module_instances_id' => $module_instance->id,
        //         'user_id'   => $userId,
        //     ]);
        // }

        $moduleInstanceId = $module_instance->id;
        $incomingUsers   = $request->users ?? [];

        /**
         * STEP 1: REMOVE module_instance_id
         * from users NOT present in request
         */
        if (!empty($incomingUsers)) {
            ModuleInstanceAssign::whereNotIn('user_id', $incomingUsers)
                ->whereJsonContains('module_instance_ids', $moduleInstanceId)
                ->get()
                ->each(function ($assign) use ($moduleInstanceId) {
                    $assign->update([
                        'module_instance_ids' => array_values(
                            array_diff($assign->module_instance_ids, [$moduleInstanceId])
                        ),
                    ]);
                });
        }

        /**
         * STEP 2: ADD / KEEP module_instance_id
         * for users present in request
         */
        foreach ($incomingUsers as $userId) {
            $assign = ModuleInstanceAssign::firstOrCreate(
                ['user_id' => $userId],
                ['module_instance_ids' => []]
            );

            if (!in_array($moduleInstanceId, $assign->module_instance_ids)) {
                $assign->update([
                    'module_instance_ids' => array_values(
                        array_unique(array_merge(
                            $assign->module_instance_ids,
                            [$moduleInstanceId]
                        ))
                    ),
                ]);
            }
        }


        foreach ($request->features as $featureKey) {
            ModuleFeature::create([
                'module_id' => $module->id,
                'feature_key' => $featureKey,
                'feature_name' => ucfirst(str_replace('_', ' ', $featureKey)),
                'feature_type' => null,
                'settings' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // $module->users()->sync($request->users);

        return redirect()->route('tgg-india.admin.modules.index')->with('success', 'Module created successfully.');
    }

    public function edit(Module $module, $id)
    {
        $users = UserSecondary::get();
        $module = Module::with(['users', 'features'])->findOrFail($id);
        $features = [
            'literatures' => 'Literatures',
            // 'literature_chapters' => 'Literature Chapters',
            // 'literature_sections' => 'Literature Sections',
            'links' => 'Links',
            'linkedins' => 'LinkedIns',
            'videos' => 'Videos'
        ];
        return view('tgg-india.admin.modules.edit', compact('module', 'users', 'features'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'users'  => 'required|array',
            'features' => 'required|array',
        ]);

        $module = Module::findOrFail($id);

        // Update module details
        $module->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        ModuleInstance::where('module_id', $module->id)
        ->where('user_id', '!=', $request->user_id)
        ->update([
            'user_id' => $request->user_id
        ]);

        $module_instance = ModuleInstance::where('module_id', $module->id)->first();
        $moduleInstanceId = $module_instance->id;
        $incomingUsers   = $request->users ?? [];

        /**
         * STEP 1: REMOVE module_instance_id
         * from users NOT present in request
         */
        if (!empty($incomingUsers)) {
            ModuleInstanceAssign::whereNotIn('user_id', $incomingUsers)
                ->whereJsonContains('module_instance_ids', $moduleInstanceId)
                ->get()
                ->each(function ($assign) use ($moduleInstanceId) {
                    $assign->update([
                        'module_instance_ids' => array_values(
                            array_diff($assign->module_instance_ids, [$moduleInstanceId])
                        ),
                    ]);
                });
        }

        /**
         * STEP 2: ADD / KEEP module_instance_id
         * for users present in request
         */
        foreach ($incomingUsers as $userId) {
            $assign = ModuleInstanceAssign::firstOrCreate(
                ['user_id' => $userId],
                ['module_instance_ids' => []]
            );

            if (!in_array($moduleInstanceId, $assign->module_instance_ids)) {
                $assign->update([
                    'module_instance_ids' => array_values(
                        array_unique(array_merge(
                            $assign->module_instance_ids,
                            [$moduleInstanceId]
                        ))
                    ),
                ]);
            }
        }

        


        // Sync features (clear old & insert new)
        ModuleFeature::where('module_id', $module->id)->delete();

        foreach ($request->features as $featureKey) {
            ModuleFeature::create([
                'module_id'    => $module->id,
                'feature_key'  => $featureKey,
                'feature_name' => ucfirst(str_replace('_', ' ', $featureKey)),
                'feature_type' => null,
                'settings'     => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        return redirect()
            ->route('tgg-india.admin.modules.index')
            ->with('success', 'Module updated successfully.');
    }


    // public function destroy(Module $module)
    // {
    //     $module->users()->detach();
    //     $module->delete();

    //     return redirect()->route('tgg-india.admin.modules.index')->with('success', 'Module deleted successfully.');
    // }

    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        // Delete related module instances (users)
        ModuleInstance::where('module_id', $module->id)->delete();

        // Delete related module features
        ModuleFeature::where('module_id', $module->id)->delete();

        // Finally delete the module
        $module->delete();

        return redirect()
            ->route('tgg-india.admin.modules.index')
            ->with('success', 'Module deleted successfully.');
    }
}
