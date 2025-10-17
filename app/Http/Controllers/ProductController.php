<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $userId = auth()->id();
        
        // $products = Product::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        // return view('products.seller-index', compact('products'));
        $query = Product::where('status', 'approved');

        // Filter by category ID
        if ($request->input('category')) {
            $query->where('category', $request->input('category'));
        }

        // Search by title
        if ($request->input('query')) {
            $query->where('title', 'like', '%' . $request->input('query') . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function indexSeller(Request $request)
    {
        $userId = auth()->id();
        
        $products = Product::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('products.seller-index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'image'=>'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        $userId = auth()->id();

        $product = Product::create([
            'user_id' => $userId,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $path,
            'status' => 'pending', // admin will approve
        ]);

        return redirect()->route('products.index')->with('success','Product submitted for approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Only show approved products to public
        if ($product->status !== 'approved') {
            abort(404);
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all();
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'image'=>'nullable|image|max:2048',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'status' => 'pending', // reset to pending when updated
        ];

        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($updateData);

        return redirect()->route('products.index')->with('success','Product updated and submitted for re-approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $product->delete();
        
        return redirect()->route('products.index')->with('success','Product deleted successfully.');
    }
}
