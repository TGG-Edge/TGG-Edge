<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleFeature;
use App\Models\ModuleInstance;
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
        // $users = User::select('id', 'name')->get();
        $users = collect([
            (object)[
                'id' => 1,
                'name' => 'Demo User'
            ]
        ]);

        $features = [
            'literatures' => 'Literatures',
            'literature_chapters' => 'Literature Chapters',
            'literature_sections' => 'Literature Sections',
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
            'users'  => 'required|array'
        ]);

        $module = Module::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        foreach ($request->users as $userId) {
            ModuleInstance::create([
                'module_id' => $module->id,
                'user_id'   => $userId,
            ]);
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

    public function edit(Module $module)
    {
        // $users = User::select('id', 'name')->get();1
        $users = collect([
            (object)[
                'id' => 1,
                'name' => 'Demo User'
            ]
        ]);
        $selectedUsers = $module->users->pluck('id')->toArray();
        return view('tgg-india.admin.modules.edit', compact('module', 'users', 'selectedUsers'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'users'  => 'required|array'
        ]);

        $module->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $module->users()->sync($request->users);

        return redirect()->route('tgg-india.admin.modules.index')->with('success', 'Module updated successfully.');
    }

    public function destroy(Module $module)
    {
        $module->users()->detach();
        $module->delete();

        return redirect()->route('tgg-india.admin.modules.index')->with('success', 'Module deleted successfully.');
    }
}
