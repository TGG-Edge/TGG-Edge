<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $categories = FaqCategory::with('children')
            ->when($request->parent_id, function ($q) use ($request) {
                $q->where('parent_id', $request->parent_id);
            }, function ($q) {
                $q->whereNull('parent_id');
            })
            ->orderBy('sort_order')
            ->paginate(10);

        return view('tgg-india.admin.faq-categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $categories = FaqCategory::where('is_active', 1)->get();

        return view('tgg-india.admin.faq-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        FaqCategory::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'is_active' => $request->is_active ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('tgg-india.admin.faq-categories.index')
            ->with('success', 'Category Created Successfully');
    }

    public function show(FaqCategory $faq_category)
    {
        return view('tgg-india.admin.faq-categories.show', compact('faq_category'));
    }

    public function edit(FaqCategory $faq_category)
    {
        $categories = FaqCategory::where('id', '!=', $faq_category->id)->get();

        return view('tgg-india.admin.faq-categories.edit', compact('faq_category', 'categories'));
    }

    public function update(Request $request, FaqCategory $faq_category)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $faq_category->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'parent_id' => $request->parent_id,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('tgg-india.admin.faq-categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(FaqCategory $faq_category)
    {
        $faq_category->delete();

        return back()->with('success', 'Category Deleted Successfully');
    }
}
