<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateSlugJob;
use App\Jobs\GenerateSummaryJob;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    //
    public function index(Request $request)
    {
                    return response()->json(['message' => 'Logged in']);

        $query = Article::with('categories', 'author');

        if ($request->has('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('name', $request->category));
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('published_at', [$request->from, $request->to]);
        }

        if (Auth::user()->role === 'author') {
            $query->where('user_id', Auth::id());
        }

        return response()->json($query->latest()->get());
    }


      public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_ids'=> 'array',
            'status'      => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at'=> 'nullable|date',
        ]);

        $article = Article::create([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'status'       => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'user_id'      => Auth::id(),
        ]);

        if (!empty($validated['category_ids'])) {
            $article->categories()->sync($validated['category_ids']);
        }

        GenerateSlugJob::dispatch($article);
        GenerateSummaryJob::dispatch($article);

        return response()->json(['message' => 'Article created successfully', 'article' => $article]);
    }

    public function show($id)
    {
        $article = Article::with('categories', 'author')->findOrFail($id);

        if (Auth::user()->role === 'author' && $article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (Auth::user()->role === 'author' && $article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category_ids'=> 'array',
            'status'      => ['required', Rule::in(['draft', 'published', 'archived'])],
            'published_at'=> 'nullable|date',
        ]);

        $article->update($validated);

        if (!empty($validated['category_ids'])) {
            $article->categories()->sync($validated['category_ids']);
        }

        return response()->json(['message' => 'Article updated', 'article' => $article]);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (Auth::user()->role === 'author' && $article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $article->delete();

        return response()->json(['message' => 'Article deleted']);
    }
    
    public function generateSlug($id)
    {
        $article = Article::findOrFail($id);

        if (Auth::user()->role === 'author' && $article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        GenerateSlugJob::dispatch($article);

        return response()->json(['message' => 'Slug generation dispatched']);
    }

    public function generateSummary($id)
    {
        $article = Article::findOrFail($id);

        if (Auth::user()->role === 'author' && $article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        GenerateSummaryJob::dispatch($article);

        return response()->json(['message' => 'Summary generation dispatched']);
    }


}
