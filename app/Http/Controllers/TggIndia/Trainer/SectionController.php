<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Literature;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $sections = Section::latest()->get();
        return view('tgg-india.trainer.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('tgg-india.trainer.sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

         if (!$request->filled('literature_id')) {
            $user = auth('web2')->user();

            // Get the first assigned module_instance of this user
            $moduleInstance = $user->modules()
                                ->withPivot('id') // ensure pivot id is loaded
                                ->first();

            if (!$moduleInstance) {
                return back()->withErrors(['error' => 'No module instance found for this user.']);
            }

            $literature = Literature::where('module_instance_id', $moduleInstance->pivot->id)
                                ->first();

            // If not exists, create new one
            if (!$literature) {
                $literature = Literature::create([
                    'module_instance_id' => $moduleInstance->pivot->id,
                    'title' => "Untitled Literature - " . $user->name,
                    'description' => null,
                ]);
            }

            // Inject into request so section will link to it
            $request->merge(['literature_id' => $literature->id]);
        }
        Section::create($request->all());
        return redirect()->route('tgg-india.trainer.sections.index')
                         ->with('success', 'Section created successfully.');
    }

    public function edit($id)
    {
        $section = Section::findOrFail($id);
        return view('tgg-india.trainer.sections.edit', compact('section'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $section = Section::findOrFail($id);
        $section->update($request->all());

        return redirect()->route('tgg-india.trainer.sections.index')
                         ->with('success', 'Section updated successfully.');
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.sections.index')
                         ->with('success', 'Section deleted successfully.');
    }
}
