<?php

namespace App\Http\Controllers\TggIndia;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query();

        if (auth('web2')->user()->id != 1) {

            $products->where('user_id', auth('web2')->user()->id);
        }

        $products = $products->latest()->paginate(10);

        return view('tgg-india.products.index', compact('products'));
    }

    public function create()
    {
        return view('tgg-india.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'amount' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required',
            'is_active' => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'user_id' => auth('web2')->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'stock' => $request->stock,
            'image' => $image,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('tgg-india.products.index', [
                'role' => auth('web2')->user()->role_key
            ])
            ->with('success', 'Product created successfully.');
    }

    public function show($role,Product $product)
    {
        return view('tgg-india.products.show', compact('product'));
    }

    public function edit($role, Product $product)
    {
        return view('tgg-india.products.edit', compact('product'));
    }

    public function update($role, Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'amount' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required',
            'is_active' => 'required',
        ]);

        $image = $product->image;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('products', 'public');
        }

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'stock' => $request->stock,
            'image' => $image,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('tgg-india.products.index', [
                'role' => auth('web2')->user()->role_key
            ])
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($role,Product $product)
    {
        $product->delete();

        return redirect()
            ->route('tgg-india.products.index', [
                'role' => auth('web2')->user()->role_key
            ])
            ->with('success', 'Product deleted successfully.');
    }

    public function spouseProducts( $spouse)
    {
        $products = Product::where('user_id', $spouse)
            ->latest()
            ->paginate(10);

        return view('tgg-india.products.spouse-products', compact(
            'products',
            'spouse'
        ));
    }
}