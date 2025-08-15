<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
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
