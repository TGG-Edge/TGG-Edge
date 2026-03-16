<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $faqs = Faq::with('category', 'children')
            ->when($request->parent_id, function ($q) use ($request) {
                $q->where('parent_id', $request->parent_id);
            }, function ($q) {
                $q->whereNull('parent_id');
            })
            ->paginate(10);

        return view('tgg-india.admin.faqs.index', compact('faqs'));
    }

    public function create(Request $request)
    {
        $categories = FaqCategory::where('is_active', 1)->get();
        return view('tgg-india.admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required'
        ]);

        Faq::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active ?? 1,
            'created_by' => auth('web2')->id()
        ]);

        return redirect()->route('tgg-india.admin.faqs.index')
            ->with('success', 'FAQ Created Successfully');
    }

    public function show(Faq $faq)
    {
        return view('tgg-india.admin.faqs.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::all();
        return view('tgg-india.admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $faq->update($request->all());

        return redirect()->route('tgg-india.admin.faqs.index')
            ->with('success', 'FAQ Updated Successfully');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', 'FAQ Deleted Successfully');
    }
}
