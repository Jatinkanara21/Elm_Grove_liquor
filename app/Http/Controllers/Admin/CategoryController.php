<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Services\ImageService;

class CategoryController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->orderBy('sort_order')->orderBy('name')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category(['is_active' => true])]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'categories', 1200);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $this->images->delete($category->image);
            $data['image'] = $this->images->store($request->file('image'), 'categories', 1200);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function toggle(Category $category)
    {
        $category->update(['is_active' => ! $category->is_active]);

        return back()->with('success', 'Category ' . ($category->is_active ? 'enabled' : 'disabled') . '.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'This category still has products. Move or delete them first, or disable the category instead.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}