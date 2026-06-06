<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'subcategory'])->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products      = $query->paginate(12)->withQueryString();
        $categories    = Category::where('is_active', true)->orderBy('name')->get();
        $subcategories = Subcategory::where('is_active', true)->orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'subcategories'));
    }

    public function create(): View
    {
        $categories    = Category::where('is_active', true)->orderBy('name')->get();
        $subcategories = collect();

        return view('products.create', compact('categories', 'subcategories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $imageName);
        }

        Product::create([
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name'           => $request->name,
            'description'    => $request->description,
            'image'          => $imageName,
            'old_price'      => $request->old_price,
            'new_price'      => $request->new_price,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'subcategory']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories    = Category::where('is_active', true)->orderBy('name')->get();
        $subcategories = Subcategory::where('category_id', $product->category_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $imageName = $product->image;

        if ($request->hasFile('image')) {
            if ($imageName && file_exists(public_path('uploads/products/' . $imageName))) {
                unlink(public_path('uploads/products/' . $imageName));
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $imageName);
        }

        $product->update([
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name'           => $request->name,
            'description'    => $request->description,
            'image'          => $imageName,
            'old_price'      => $request->old_price,
            'new_price'      => $request->new_price,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function getSubcategories(Request $request): JsonResponse
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}
