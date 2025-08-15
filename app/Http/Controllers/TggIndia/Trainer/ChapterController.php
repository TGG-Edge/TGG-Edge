<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $chapters = Chapter::latest()->get();
        return view('tgg-india.trainer.chapters.index', compact('chapters'));
    }

    public function create()
    {
        return view('tgg-india.trainer.chapters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'section_id' => 'required',
        ]);

        Chapter::create($request->all());

        return redirect()->route('tgg-india.trainer.chapters.index',['section_id' =>  $request->section_id])
                         ->with('success', 'Chapter created successfully.');
    }   

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('tgg-india.trainer.chapters.edit', compact('chapter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        $chapter = Chapter::findOrFail($id);
        $chapter->update($request->all());

        return redirect()->route('tgg-india.trainer.chapters.index')
                         ->with('success', 'Chapter updated successfully.');
    }

    public function destroy($id)
    {
        Chapter::findOrFail($id)->delete();
        return redirect()->route('tgg-india.trainer.chapters.index')
                         ->with('success', 'Chapter deleted successfully.');
    }
}
