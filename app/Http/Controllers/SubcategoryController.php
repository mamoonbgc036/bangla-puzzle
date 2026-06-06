<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    public function index(): View
    {
        $subcategories = Subcategory::with('category')
            ->withCount('products')
            ->latest()
            ->paginate(10);

        return view('subcategories.index', compact('subcategories'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('subcategories.create', compact('categories'));
    }

    public function store(SubcategoryRequest $request): RedirectResponse
    {
        Subcategory::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    public function show(Subcategory $subcategory): View
    {
        $subcategory->load(['category', 'products']);

        return view('subcategories.show', compact('subcategory'));
    }

    public function edit(Subcategory $subcategory): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(SubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $subcategory->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $subcategory->delete();

        return redirect()->route('subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
